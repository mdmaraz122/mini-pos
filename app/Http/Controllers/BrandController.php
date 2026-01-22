<?php

namespace App\Http\Controllers;

use App\Helper\CustomSanitize;
use App\Helper\FetchCurrentAdmin;
use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    // +++++++ Brand ++++++++
    // create Brand
    public function brandCreate(Request $request){
        try {
            // validate data
            $request->validate([
                'name' => 'required',
                'slug' => 'required',
            ]);
            // check
            $data = FetchCurrentAdmin::GetCurrentAdmin($request);
            // name is unique
            $brand = Brand::where('name', CustomSanitize::sanitize($request->input('name')))->first();
            if ($brand) {
                return ResponseHelper::Out('error', 'Brand Name Already Exists', null, 200);
            }
            // slug is unique
            $brand = Brand::where('slug', CustomSanitize::sanitize($request->input('slug')))->first();
            if ($brand) {
                return ResponseHelper::Out('error', 'Brand Slug Already Exists', null, 200);
            }
            // Save new image
            // Save new image
            if($request->file('image')){
                // check image type
                $imageType = $request->file('image')->getClientOriginalExtension();
                if (!in_array($imageType, ['jpeg', 'png', 'jpg',])) {
                    return ResponseHelper::Out('error', 'Only jpeg, png, and jpg are allowed', null, 200);
                }
                // check image size
                if ($request->file('image')->getSize() > 2048000) {
                    return ResponseHelper::Out('error', 'Image size should be less than 2MB', null, 200);
                }
                $image = $request->file('image');
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/uploads/brands/'), $imageName);
            }else{
                $imageName = null;
            }
            // Create new category
            $brand = new Brand();
            $brand->name = CustomSanitize::sanitize($request->input('name'));
            $brand->slug = CustomSanitize::sanitize($request->input('slug'));
            $brand->image = $imageName;
            $brand->status = 'Active';
            $brand->admin_id = $data->userID;
            $brand->save();
            return ResponseHelper::Out('success', 'Brand Created Successfully', null, 200);
        }catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| BrandController--brandCreate ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // list brand
    public function brandList(Request $request){
        try {
            // check
            $data = FetchCurrentAdmin::GetCurrentAdmin($request);
            // get all brands
            $categories = Brand::orderBy('id', 'desc')
                ->get();
            return ResponseHelper::Out('success', 'Brand List Found', $categories, 200);
        }catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| BrandController--brandList ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // list brand by status
    public function brandStatus(Request $request){
        try {
            // get all brands
            $categories = Brand::orderBy('id', 'desc')
                ->where('status', 'Active')
                ->get();
            return ResponseHelper::Out('success', 'Brand List Found', $categories, 200);
        }catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| BrandController--brandStatus ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // single brand
    public function brandSingle(Request $request){
        try {
            $id = $request->input('id');
            $brand = Brand::where('id', $id)->first();
            if ($brand) {
                return ResponseHelper::Out('success', 'Brand Found', $brand, 200);
            } else {
                return ResponseHelper::Out('error', 'Brand Not Found', null, 200);
            }
        }catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| BrandController--brandSingle ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // update brand
    public function brandUpdate(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'status' => 'required|in:Active,Inactive',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // optional image
            ]);

            $brand = Brand::find(CustomSanitize::sanitize($request->id));

            // Check if Brand name already exists for another Brand
            $existingBrand = Brand::where('name', CustomSanitize::sanitize($request->name))
                ->where('id', '!=', $brand->id)
                ->first();
            if ($existingBrand) {
                return ResponseHelper::Out('error', 'Brand name already exists', null, 200);
            }
            // Check if Brand slug already exists for another Brand
            $existingBrand = Category::where('slug', CustomSanitize::sanitize($request->slug))
                ->where('id', '!=', $brand->id)
                ->first();
            if ($existingBrand) {
                return ResponseHelper::Out('error', 'Brand slug already exists', null, 200);
            }

            // Check if new image is uploaded
            if ($request->hasFile('image')) {
                // Delete old image
                if ($brand->image && file_exists(public_path('assets/uploads/brands/' . $brand->image))) {
                    unlink(public_path('assets/uploads/brands/' . $brand->image));
                }

                // Save new image
                $image = $request->file('image');
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/uploads/brands/'), $imageName);
                $brand->image = $imageName;
            }

            // Update other fields
            $brand->name = CustomSanitize::sanitize($request->name);
            $brand->slug = CustomSanitize::sanitize($request->slug);
            $brand->status = CustomSanitize::sanitize($request->status);
            $brand->save();
            return ResponseHelper::Out('success', 'Brand updated successfully', null, 200);
        } catch (\Exception $e) {
            // save error in log file
            logger()->error(now().' ||| BrandController--brandUpdate ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // delete brand
    public function brandDelete(Request $request){
        try {
            $id = CustomSanitize::sanitize($request->input('id'));
            $brand = Brand::find($id);
            if ($brand) {
                // Delete image
                if ($brand->image && file_exists(public_path('assets/uploads/brands/' . $brand->image))) {
                    unlink(public_path('assets/uploads/brands/' . $brand->image));
                }
                // Delete brand
                $brand->delete();
                return ResponseHelper::Out('success', 'Brand Deleted Successfully', null, 200);
            } else {
                return ResponseHelper::Out('error', 'Brand Not Found', null, 200);
            }
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| BrandController--brandDelete ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
}
