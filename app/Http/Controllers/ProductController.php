<?php

namespace App\Http\Controllers;

use App\Helper\CustomSanitize;
use App\Helper\FetchCurrentAdmin;
use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // generate Product SKU
    public function ProductSKUGenerator(Request $request)
    {
        try {
            $id = CustomSanitize::sanitize($request->input('id'));
            $category = Category::where('id', $id)->first();

            if ($category) {
                // Clean and sanitize category name
                $cleanName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $category->name));
                $prefix = substr($cleanName, 0, 4);
                // Generate initial SKU
                $sku = $prefix . '-' . mt_rand(1000, 999999);
                // Check if SKU already exists
                while (Product::where('sku', $sku)->exists()) {
                    $sku = $prefix . '-' . mt_rand(1000, 999999);
                }
                return ResponseHelper::Out('success', 'Product SKU Generated', $sku, 200);
            } else {
                return ResponseHelper::Out('error', 'Category Not Found', null, 200);
            }
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| ProductController--ProductSKUGenerator ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // generate Product Barcode
    public function productBarcodeGenerator(Request $request)
    {
        try {
             // Generate a random 12-digit number
            $barcode = mt_rand(100000000000, 999999999999);
            // Check if barcode already exists
            while (Product::where('barcode', $barcode)->exists()) {
                $barcode = mt_rand(100000000000, 999999999999);
            }
            return ResponseHelper::Out('success', 'Product Barcode Generated', $barcode, 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| ProductController--productBarcodeGenerator ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // product create
    public function productCreate(Request $request) {
        try {
            $name = CustomSanitize::sanitize($request->input('name'));
            // check if product name already exists
            $check_name = Product::where('name', $name)->first();
            if ($check_name) {
                return ResponseHelper::Out('error', 'Product name already exists', null, 200);
            }
            // check if slug already exists
            $check_slug = Product::where('slug', CustomSanitize::sanitize($request->input('slug')))->first();
            if ($check_slug) {
                return ResponseHelper::Out('error', 'Product slug already exists', null, 200);
            }
            $admin = FetchCurrentAdmin::GetCurrentAdmin($request);
            $product = new Product();
            $product->admin_id = $admin->userID;
            if (!$request->brand_id) {
                $product->brand_id = null;
            } else {
                $product->brand_id = CustomSanitize::sanitize($request->input('brand_id'));
            }
            $product->category_id = CustomSanitize::sanitize($request->input('category_id'));
            $product->unit_id = CustomSanitize::sanitize($request->input('unit_id'));
            $product->name = $name;
            $product->slug = CustomSanitize::sanitize($request->input('slug'));
            $product->sku = CustomSanitize::sanitize($request->input('sku'));
            $product->barcode = CustomSanitize::sanitize($request->input('barcode'));
            $product->quantity = CustomSanitize::sanitize($request->input('quantity'));
            $product->quantity_alert = CustomSanitize::sanitize($request->input('quantity_alert'));
            $product->purchase_price = CustomSanitize::sanitize($request->input('purchase_price'));
            $product->mrp = CustomSanitize::sanitize($request->input('mrp'));
            $product->selling_price = CustomSanitize::sanitize($request->input('selling_price'));
            $product->discount = CustomSanitize::sanitize($request->input('discount') ? $request->discount : 0);
            $product->discount_type = CustomSanitize::sanitize($request->input('discount_type') ? $request->discount_type : 'Fixed');
            if (!$request->tax_id) {
                $product->tax_id = null;
            } else {
                $product->tax_id = CustomSanitize::sanitize($request->input('tax_id'));
            }
            $product->short_description = CustomSanitize::sanitize($request->input('short_description'));

            // Handle main image upload
            if ($request->hasFile('main_image')) {
                $image = $request->file('main_image');
                // Use slug and unique number in filename
                $slug = Str::slug($request->name); // assuming product name is used for slug
                $imageName = $slug . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                // Save to public/assets/uploads/products/
                $image->move(public_path('assets/uploads/products'), $imageName);

                // Save image name in the product model
                $product->image = $imageName;
            }
            $product->save();
            return ResponseHelper::Out('success', 'Product created successfully', null, 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| ProductController--productCreate ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // product list
    public function productList(Request $request) {
        try {
            $admin = FetchCurrentAdmin::GetCurrentAdmin($request);
            $products = Product::with([
                    'brand',
                    'category',
                    'unit',
                    'tax',
                ])
                ->orderBy('id', 'desc')
                ->get();
            return ResponseHelper::Out('success', 'Product list fetched successfully', $products, 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| ProductController--productList ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // product single
    public function productSingleData(Request $request)
    {
        try {
            $slug = $request->input('slug');

            $product = Product::where('slug', '=',$slug)->with([
                'brand',
                'category',
                'unit',
                'tax',
            ])->first();


            if ($product) {
                return ResponseHelper::Out('success', 'Product fetched successfully', $product, 200);
            } else {
                return ResponseHelper::Out('error', 'Product not found', null, 200);
            }
        } catch (\Exception $e) {
            // save error in log file
            logger()->error(now().' ||| ProductController--productSingleData ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // product update
    public function productUpdate(Request $request, $slug) {
        try {
            $product = Product::where('slug', $slug)->firstOrFail();

            // Validate and sanitize input data
            $name = CustomSanitize::sanitize($request->input('name'));
            $newSlug = CustomSanitize::sanitize($request->input('new_slug'));

            // Check for duplicate name and slug
            if (Product::where('name', $name)->where('id', '!=', $product->id)->exists()) {
                return ResponseHelper::Out('error', 'Product name already exists', null, 200);
            }
            if ($newSlug !== $slug && Product::where('slug', $newSlug)->where('id', '!=', $product->id)->exists()) {
                return ResponseHelper::Out('error', 'Product slug already exists', null, 200);
            }

            // Update product properties
            $admin = FetchCurrentAdmin::GetCurrentAdmin($request);
            $product->admin_id = $admin->userID;
            $product->brand_id = $request->brand_id ? CustomSanitize::sanitize($request->input('brand_id')) : null;
            $product->category_id = CustomSanitize::sanitize($request->input('category_id'));
            $product->unit_id = CustomSanitize::sanitize($request->input('unit_id'));
            $product->name = $name;
            $product->slug = $newSlug;
            $product->sku = CustomSanitize::sanitize($request->input('sku'));
            $product->barcode = CustomSanitize::sanitize($request->input('barcode'));
            $product->quantity = CustomSanitize::sanitize($request->input('quantity'));
            $product->quantity_alert = CustomSanitize::sanitize($request->input('quantity_alert'));
            $product->purchase_price = CustomSanitize::sanitize($request->input('purchase_price'));
            $product->mrp = CustomSanitize::sanitize($request->input('mrp'));
            $product->selling_price = CustomSanitize::sanitize($request->input('selling_price'));
            $product->discount = CustomSanitize::sanitize($request->input('discount') ? $request->discount : 0);
            $product->discount_type = CustomSanitize::sanitize($request->input('discount_type') ? $request->discount_type : 'Fixed');
            $product->tax_id = $request->tax_id ? CustomSanitize::sanitize($request->input('tax_id')) : null;
            $product->tax_type = CustomSanitize::sanitize($request->input('tax_type') ? $request->tax_type : 'Inclusive');
            $product->short_description = CustomSanitize::sanitize($request->input('short_description'));
            $product->status = CustomSanitize::sanitize($request->input('status'));


            // Handle file uploads
            $uploadPath = public_path('assets/uploads/products');

            // Ensure upload directory exists
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if ($request->hasFile('main_image')) {
                // delete old file from database
                $oldImage = Product::where('id', $product->id)
                    ->first();
                if ($oldImage) {
                    $oldFile = $uploadPath . '/' . $oldImage->image;
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
                }
                // upload new file
                // Handle image upload
                $image = $request->file('main_image');
                // Use slug and unique number in filename
                $slug = Str::slug($request->name); // assuming product name is used for slug
                $imageName = $slug . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                // Save to public/assets/uploads/products/
                $image->move(public_path('assets/uploads/products'), $imageName);
                $product->image = $imageName;
            }

            // Save the product
            $product->save();

            return ResponseHelper::Out('success', 'Product updated successfully', $product, 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ResponseHelper::Out('error', 'Product not found', null, 404);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| ProductController--productUpdate ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // product delete
    public function productDelete(Request $request) {
        try {
            $id = CustomSanitize::sanitize($request->input('id'));
            $product = Product::where('id', $id)->first();
            if( !$product) {
                return ResponseHelper::Out('error', 'Product not found', null, 200);
            }
            // check product has image or not
            if ($product->image) {
                // delete product image
                $oldFile = public_path('assets/uploads/products') . '/' . $product->image;
                if (file_exists($oldFile)) {
                    @unlink($oldFile);
                }
            }
            $product->delete();
            return ResponseHelper::Out('success', 'Product deleted successfully', null, 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| ProductController--productDelete ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }

}
