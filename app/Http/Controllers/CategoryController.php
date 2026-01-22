<?php

namespace App\Http\Controllers;

use App\Helper\CustomSanitize;
use App\Helper\FetchCurrentAdmin;
use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // +++++++ Category ++++++++
    // create category
    public function categoryCreate(Request $request){
        try {
            // validate data
            $request->validate([
                'name' => 'required',
                'slug' => 'required',
            ]);
            // check
            $data = FetchCurrentAdmin::GetCurrentAdmin($request);
            // name is unique
            $category = Category::where('name', CustomSanitize::sanitize($request->input('name')))->first();
            if ($category) {
                return ResponseHelper::Out('error', 'Category Name Already Exists', null, 200);
            }
            // slug is unique
            $category = Category::where('slug', CustomSanitize::sanitize($request->input('slug')))->first();
            if ($category) {
                return ResponseHelper::Out('error', 'Category Slug Already Exists', null, 200);
            }
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
                $image->move(public_path('assets/uploads/category/'), $imageName);
            }else{
                $imageName = null;
            }

            // Create new category
            $category = new Category();
            $category->name = CustomSanitize::sanitize($request->input('name'));
            $category->slug = CustomSanitize::sanitize($request->input('slug'));
            $category->image = $imageName;
            $category->status = 'Active';
            $category->admin_id = $data->userID;
            $category->save();
            return ResponseHelper::Out('success', 'Category Created Successfully', null, 200);
        }catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| CategoryController--categoryCreate ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // list category
    public function categoryList(Request $request){
        try {
            // check
            $data = FetchCurrentAdmin::GetCurrentAdmin($request);
            // get all categories
            $categories = Category::where('admin_id', $data->userID)
                ->orderBy('id', 'desc')
                ->get();
            return ResponseHelper::Out('success', 'Category List Found', $categories, 200);
        }catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| CategoryController--categoryList ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // single category
    public function categorySingle(Request $request){
        try {
            $id = CustomSanitize::sanitize($request->input('id'));
            $category = Category::where('id', $id)->first();
            if ($category) {
                return ResponseHelper::Out('success', 'Category Found', $category, 200);
            } else {
                return ResponseHelper::Out('error', 'Category Not Found', null, 200);
            }
        }catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| CategoryController--categorySingle ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // update category
    public function categoryUpdate(Request $request){
        try {
            $request->validate([
                'id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'status' => 'required|in:Active,Inactive',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // optional image
            ]);

            $category = Category::find(CustomSanitize::sanitize($request->id));

            // Check if category name already exists for another category
            $existingCategory = Category::where('name', CustomSanitize::sanitize($request->name))
                ->where('id', '!=', $category->id)
                ->first();
            if ($existingCategory) {
                return ResponseHelper::Out('error', 'Category name already exists', null, 200);
            }
            // Check if category slug already exists for another category
            $existingCategory = Category::where('slug', CustomSanitize::sanitize($request->slug))
                ->where('id', '!=', $category->id)
                ->first();
            if ($existingCategory) {
                return ResponseHelper::Out('error', 'Category slug already exists', null, 200);
            }

            // Check if new image is uploaded
            if ($request->hasFile('image')) {
                // Validate image type
                $imageType = $request->file('image')->getClientOriginalExtension();
                if (!in_array($imageType, ['jpeg', 'png', 'jpg'])) {
                    return ResponseHelper::Out('error', 'Only jpeg, png, and jpg are allowed', null, 200);
                }
                // Validate image size
                if ($request->file('image')->getSize() > 2048000) {
                    return ResponseHelper::Out('error', 'Image size should be less than 2MB', null, 200);
                }
                // Delete old image
                if ($category->image && file_exists(public_path('assets/uploads/category/' . $category->image))) {
                    unlink(public_path('assets/uploads/category/' . $category->image));
                }
                // Save new image
                $image = $request->file('image');
                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/uploads/category/'), $imageName);
                $category->image = $imageName;
            }

            // Update other fields
            $category->name = CustomSanitize::sanitize($request->name);
            $category->slug = CustomSanitize::sanitize($request->slug);
            $category->status = CustomSanitize::sanitize($request->status);
            $category->save();
            return ResponseHelper::Out('success', 'Category updated successfully', null, 200);
        } catch (\Exception $e) {
            // save error in log file
            logger()->error(now().' ||| CategoryController--categoryUpdate ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // delete category
    public function categoryDelete(Request $request){
        try {
            $id = CustomSanitize::sanitize($request->input('id'));
            $category = Category::find($id);
            if ($category) {
                if($category->image === null){
                    $category->delete();
                }else if ($category->image && file_exists(public_path('assets/uploads/category/' . $category->image))) {
                    unlink(public_path('assets/uploads/category/' . $category->image));
                    $category->delete();
                }
                return ResponseHelper::Out('success', 'Category Deleted Successfully', null, 200);
            } else {
                return ResponseHelper::Out('error', 'Category Not Found', null, 200);
            }
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| CategoryController--categoryDelete ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // status category
    public function categoryStatus()
    {
        try {
            $data = Category::where('status', '=', 'Active')->get();
            return ResponseHelper::Out('success', 'Category Status Updated Successfully', $data, 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| CategoryController--categoryStatus ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    //category By Name
    public function categoryByName()
    {
        try {
            $name = CustomSanitize::sanitize(request()->input('category'));

            // Check if search term is provided
            if (empty($name)) {
                return ResponseHelper::Out('error', 'Category name is required', null, 400);
            }

            $data = Category::where('name', 'LIKE', '%' . $name . '%')->get();

            return ResponseHelper::Out('success', 'Categories retrieved successfully', $data, 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| CategoryController--categoryByName ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
}
