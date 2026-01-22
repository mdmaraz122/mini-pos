<?php

namespace App\Http\Controllers;

use App\Helper\CustomSanitize;
use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // order create
    public function orderCreate(Request $request) {
        try {
            // Generate 7-digit order number
            $orderNumber = $this->generateOrderNumber();

            // Calculate due amount
            $dueAmount = $request->total_amount - $request->paid_amount;

            // Create the order
            $order = Order::create([
                'order_number' => $orderNumber,
                'customer_id' => $request->customer_id,
                'total_amount' => $request->total_amount,
                'quantity' => count($request->order_items),
                'pay' => $request->paid_amount,
                'due' => $dueAmount,
                'payment_method' => $request->payment_method,
                'note' => $request->notes ?? null,
                'status' => 'Completed' // or 'pending' based on your business logic
            ]);

            // Create order details
            foreach ($request->order_items as $item) {
                // Calculate item total with tax and discount
                $subtotal = $item['price'] * $item['quantity'];

                // Apply discount
                $discountAmount = ($item['discount_type'] === 'Percentage')
                    ? ($subtotal * $item['discount'] / 100)
                    : $item['discount'];

                $discountedAmount = $subtotal - $discountAmount;

                // Apply tax
                $taxAmount = ($item['tax_type'] === 'Exclusive')
                    ? ($discountedAmount * $item['tax_rate'] / 100)
                    : 0; // For Inclusive tax, it's already included in price

                $total = $discountedAmount + $taxAmount;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'tax' => $item['tax_rate'],
                    'tax_type' => $item['tax_type'],
                    'discount' => $item['discount'],
                    'discount_type' => $item['discount_type'],
                    'total' => $total
                ]);

                // Update product stock (if needed)
                $product = Product::find($item['product_id']);
                if ($product) {
                    // Check if stock falls below alert level
                    if (($product->quantity - $item['quantity']) < $product->quantity_alert) {
                        Notification::create([
                            'url' => '/products/view/' . $product->slug,
                            'title' => 'Stock Alert',
                            'message' => 'Product ' . $product->name . ' stock is low. Only ' . ($product->quantity - $item['quantity']) . ' left. Please restock.',
                            'type' => 'warning',
                            'is_read' => false,
                        ]);
                    }

                    // Update product stock
                    $product->quantity -= $item['quantity'];
                    $product->save();
                }

            }
            return ResponseHelper::Out('success', 'Order created successfully', $orderNumber, 201);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| OrderController--orderCreate ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }

    // Generate 7-digit order number
    protected function generateOrderNumber() {
        do {
            $number = str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);
        } while (Order::where('order_number', $number)->exists());
        return $number;
    }
    // Order list
    public function orderList(Request $request) {
        try {
            $orders = Order::with('customer',
                    'orderDetails.product.unit')
                ->orderBy('id', 'desc')->get();
            return ResponseHelper::Out('success', 'Order list retrieved successfully', $orders, 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| OrderController--orderList ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // make due payment
    public function makeDuePayment(Request $request) {
        try {
            $order = Order::where('id',CustomSanitize::sanitize($request->input('id')))->first();
            if( !$order) {
                return ResponseHelper::Out('error', 'Order not found', null, 404);
            }
            $due = CustomSanitize::sanitize($request->input('due_amount'));
            if ($due <= 0) {
                return ResponseHelper::Out('error', 'Due amount must be greater than zero', null, 400);
            }
            $order->due -= $due;
            $order->pay += $due;
            $order->save();
            return ResponseHelper::Out('success', 'Due payment made successfully', null, 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| OrderController--makeDuePayment ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // order delete
    public function orderDelete(Request $request) {
        try {
            // first the update product quantity
            $order = Order::findOrFail($request->id);
            $orderDetails = OrderDetail::where('order_id', $order->id)->get();
            foreach ($orderDetails as $detail) {
                $product = Product::find($detail->product_id);
                if ($product) {
                    $product->quantity += $detail->quantity; // Restore stock
                    $product->save();
                }
            }
            // then delete the order details
            OrderDetail::where('order_id', $order->id)->delete();
            // finally delete the order
            $order->delete();
            return ResponseHelper::Out('success', 'Order deleted successfully', null, 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| OrderController--orderDelete ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }

}
