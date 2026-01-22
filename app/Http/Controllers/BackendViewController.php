<?php

namespace App\Http\Controllers;

use App\Helper\CustomSanitize;
use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class BackendViewController extends Controller
{
    // Load Admin Data In every Page;
    private function loadAdminPage(Request $request, $viewPath, $extraData = [])
    {
        $data = JWTToken::ReadToken($request->cookie('l_token'));
        if ($data == 'unauthorized') {
            return redirect()->route('Login');
        }

        $admin = Admin::find($data->userID);
        $mergedData = array_merge(['admin' => $admin], $extraData);

        return view($viewPath, $mergedData);
    }

    // Dashboard Page View

    public function DashboardView(Request $request)
    {
        // Set explicit timezone (use your application's timezone)
        $timezone = 'Asia/Dhaka';
        $now = Carbon::now($timezone);
        // Date ranges
        $today = $now->copy()->startOfDay();
        $yesterday = $now->copy()->subDay()->startOfDay();

        // Current month (June if today is June)
        $startOfMonth = $now->copy()->startOfMonth();

        // Previous month (May 1 - May 31 if today is June)
        $startOfPreviousMonth = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $endOfPreviousMonth = $now->copy()->subMonthNoOverflow()->endOfMonth()->endOfDay();

        // Total data
        $totalSalesCount = Order::count();
        $totalRevenue = Order::sum('total_amount');
        $totalDue = Order::sum('due');

        // Calculate total profit by joining with order details and products
        $totalProfit = OrderDetail::join('products', 'order_details.product_id', '=', 'products.id')
            ->selectRaw('SUM((order_details.price - products.purchase_price) * order_details.quantity) as profit')
            ->value('profit') ?? 0;

        // Today data
        $todaySalesCount = Order::whereDate('created_at', $today)->count();
        $todayRevenue = Order::whereDate('created_at', $today)->sum('total_amount');
        $todayDue = Order::whereDate('created_at', $today)->sum('due');
        $todayProfit = Order::whereDate('orders.created_at', $today)
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->selectRaw('SUM((order_details.price - products.purchase_price) * order_details.quantity) as profit')
            ->value('profit') ?? 0;

        // Previous day data
        $previousDaySalesCount = Order::whereDate('created_at', $yesterday)->count();
        $previousDayRevenue = Order::whereDate('created_at', $yesterday)->sum('total_amount');
        $previousDayDue = Order::whereDate('created_at', $yesterday)->sum('due');
        $previousDayProfit = Order::whereDate('orders.created_at', $yesterday)
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->selectRaw('SUM((order_details.price - products.purchase_price) * order_details.quantity) as profit')
            ->value('profit') ?? 0;
        // This month data
        $thisMonthSalesCount = Order::where('created_at', '>=', $startOfMonth)
            ->where('created_at', '<=', $now)
            ->count();
        $thisMonthRevenue = Order::where('created_at', '>=', $startOfMonth)
            ->where('created_at', '<=', $now)
            ->sum('total_amount');
        $thisMonthDue = Order::where('created_at', '>=', $startOfMonth)
            ->where('created_at', '<=', $now)
            ->sum('due');
        $thisMonthProfit = Order::where('orders.created_at', '>=', $startOfMonth)
            ->where('orders.created_at', '<=', $now)
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->selectRaw('SUM((order_details.price - products.purchase_price) * order_details.quantity) as profit')
            ->value('profit') ?? 0;

        // Previous month data
        $previousMonthSalesCount = Order::where('created_at', '>=', $startOfPreviousMonth)
            ->where('created_at', '<=', $endOfPreviousMonth)
            ->count();
        $previousMonthRevenue = Order::where('created_at', '>=', $startOfPreviousMonth)
            ->where('created_at', '<=', $endOfPreviousMonth)
            ->sum('total_amount');
        $previousMonthDue = Order::where('created_at', '>=', $startOfPreviousMonth)
            ->where('created_at', '<=', $endOfPreviousMonth)
            ->sum('due');
        $previousMonthProfit = Order::where('orders.created_at', '>=', $startOfPreviousMonth)
            ->where('orders.created_at', '<=', $endOfPreviousMonth)
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->selectRaw('SUM((order_details.price - products.purchase_price) * order_details.quantity) as profit')
            ->value('profit') ?? 0;

        // Other counts
        $totalCategory = Category::count();
        $totalBrand = Brand::count();
        $totalProduct = Product::count();
        $totalCustomer = Customer::count();

        $data = [
            'totalSalesCount' => $totalSalesCount,
            'totalRevenue' => $totalRevenue,
            'totalDue' => $totalDue,
            'totalProfit' => $totalProfit,
            'todaySalesCount' => $todaySalesCount,
            'todayRevenue' => $todayRevenue,
            'todayDue' => $todayDue,
            'todayProfit' => $todayProfit,
            'previousDaySalesCount' => $previousDaySalesCount,
            'previousDayRevenue' => $previousDayRevenue,
            'previousDayDue' => $previousDayDue,
            'previousDayProfit' => $previousDayProfit,
            'thisMonthSalesCount' => $thisMonthSalesCount,
            'thisMonthRevenue' => $thisMonthRevenue,
            'thisMonthDue' => $thisMonthDue,
            'thisMonthProfit' => $thisMonthProfit,
            'previousMonthSalesCount' => $previousMonthSalesCount,
            'previousMonthRevenue' => $previousMonthRevenue,
            'previousMonthDue' => $previousMonthDue,
            'previousMonthProfit' => $previousMonthProfit,
            'totalCategory' => $totalCategory,
            'totalBrand' => $totalBrand,
            'totalProduct' => $totalProduct,
            'totalCustomer' => $totalCustomer,
        ];

        return $this->loadAdminPage($request, 'Backend.Pages.Dashboard.Dashboard-Page', [
            'data' => $data,
        ]);
    }


    // Profile Page View
    public function BackendProfileView(Request $request)
    {
        return $this->loadAdminPage($request, 'Backend.Pages.Profile.Profile-Page');
    }

    // Categories Page View
    public function BackendCategoriesView(Request $request)
    {
        return $this->loadAdminPage($request, 'Backend.Pages.Categories.Categories-Page');
    }

    // Categories Page View
    public function BackendSubCategoriesView(Request $request)
    {
        return $this->loadAdminPage($request, 'Backend.Pages.SubCategories.SubCategories-Page');
    }

    // Brand Page View
    public function BackendBrandView(Request $request)
    {
        return $this->loadAdminPage($request, 'Backend.Pages.Brands.Brands-Page');
    }

    // Tax Page View
    public function BackendTaxView(Request $request)
    {
        return $this->loadAdminPage($request, 'Backend.Pages.Taxes.Taxes-Page');
    }

    // Base Unit Page View
    public function BackendUnitView(Request $request)
    {
        return $this->loadAdminPage($request, 'Backend.Pages.Units.Units-Page');
    }

    // Variants Page View
    public function BackendVariantsView(Request $request)
    {
        return $this->loadAdminPage($request, 'Backend.Pages.Variants.Variants-Page');
    }

    // VariantItems Page View
    public function BackendVariantItemsView(Request $request)
    {
        return $this->loadAdminPage($request, 'Backend.Pages.VariantItems.VariantItems-Page');
    }

    // Product Page View
    public function BackendProductsView(Request $request)
    {
        return $this->loadAdminPage($request, 'Backend.Pages.Products.Products-Page');
    }

    // Customer Page View
    public function BackendCustomersView(Request $request)
    {
        return $this->loadAdminPage($request, 'Backend.Pages.Customers.Customers-Page');
    }

    // Product create Page View
    public function BackendProductCreateView(Request $request)
    {
        return $this->loadAdminPage($request, 'Backend.Pages.Products.Product-Create-Page');
    }

    public function BackendProductSingleView(Request $request, $slug)
    {
        $slug = CustomSanitize::sanitize($slug);
        $product = Product::where('slug', $slug)->with(
            'brand',
            'category',
            'unit',
            'tax',
        )->first();

        if (!$product) {
            return redirect()->route('Products');
        }

        return $this->loadAdminPage($request, 'Backend.Pages.Products.Product-View-Page', [
            'product' => $product,
        ]);
    }

    public function BackendProductSingleUpdateView(Request $request, $slug)
    {
        $slug = CustomSanitize::sanitize($slug);
        $product = Product::where('slug', $slug)->with(
            'brand',
            'category',
            'unit',
            'tax',
        )->first();

        if (!$product) {
            return redirect()->route('Products');
        }

        return $this->loadAdminPage($request, 'Backend.Pages.Products.Product-Update-Page', [
            'product' => $product
        ]);
    }

    // POS Page View
    public function BackendPOSView(Request $request)
    {
        $product = Product::with(
            'brand',
            'category',
            'unit',
            'tax',
        )->where('status', 'Active')->get();
        $categories = Category::where('status', 'Active')->get();
        return $this->loadAdminPage($request, 'Backend.Pages.POS.POS-Page', [
            'products' => $product,
            'categories' => $categories,
        ]);
    }

    // Invoice Print Receipt Page View
    public function printReceipt($order_number)
    {
        $order = Order::with([
            'customer',
            'orderDetails.product.unit'
        ])->where('order_number', $order_number)->firstOrFail();
        $settings = Setting::get();
        return view('Backend.Pages.Orders.Order-Receipt-Page', compact('order', 'settings'));
    }

    // Orders Page View
    public function BackendOrdersView(Request $request)
    {
        return $this->loadAdminPage($request, 'Backend.Pages.Orders.Orders-Page');
    }

    // Support Page View
    public function BackendSupportView(Request $request)
    {
        return $this->loadAdminPage($request, 'Backend.Pages.Support.Support-Page');
    }

    // Support Page View
    public function BackendNotificationsView(Request $request)
    {
        $notifications = Notification::orderBy('created_at', 'desc')->paginate(5);
        return $this->loadAdminPage($request, 'Backend.Pages.Notification.Notification-Page', [
            'notifications' => $notifications,
        ]);
    }

    // All product Barcode Print
    public function productAllBarcodePrint(Request $request)
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return $this->loadAdminPage($request, 'Backend.Pages.Products.Product-Barcode-Print-Page', [
            'products' => $products,
        ]);
    }

    // print single product barcode
    public function productSingleBarcodePrint(Request $request, $slug)
    {
        $products = Product::where('slug', CustomSanitize::sanitize($slug))->get();
        return $this->loadAdminPage($request, 'Backend.Pages.Products.Product-Barcode-Print-Page', [
            'products' => $products,
        ]);
    }

    // print single product barcode
    public function BackendSettingView(Request $request)
    {
        return $this->loadAdminPage($request, 'Backend.Pages.Settings.Settings-Page');
    }

    //++++++++++++++ Auth ++++++++++++++
    // Backend Login View
    public function BackendLogin()
    {
        return view('Backend.Pages.Auth.Login-Page');
    }

    // Backend Forgot Password View
    public function BackendForgot()
    {
        return view('Backend.Pages.Auth.Forgot-Page');
    }

    // Backend Reset Password View
    public function BackendReset()
    {
        return view('Backend.Pages.Auth.Reset-Page');
    }


}
