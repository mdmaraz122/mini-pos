<?php

namespace App\Http\Controllers;

use App\Helper\CustomSanitize;
use App\Helper\FetchCurrentAdmin;
use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // customer create
    public function CustomersCreate(Request $request){
        try {
            // validate data
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'address' => 'nullable|string',
            ]);
            $name = CustomSanitize::sanitize($request->input('name'));
            $phone = CustomSanitize::sanitize($request->input('phone'));
            $address = CustomSanitize::sanitize($request->input('address'));

            // name is unique
            $customer = Customer::where('phone', $phone)->first();
            if ($customer) {
                return ResponseHelper::Out('error', 'Phone Number Already Exists', null, 200);
            }
            // Create new category
            $customer = new Customer();
            $customer->name = $name;
            $customer->phone = $phone;
            $customer->address = $address;
            $customer->save();
            return ResponseHelper::Out('success', 'Customer Created Successfully', null, 200);
        }catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| CustomerController--CustomersCreate ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // customer list
    public function CustomersList(Request $request){
        try {
            // check
            $data = FetchCurrentAdmin::GetCurrentAdmin($request);
            // get all Customers
            $customers = Customer::orderBy('id', 'desc')
                ->get();
            if(!$customers){
                return ResponseHelper::Out('error', 'Unit Not Found', null, 200);
            }
            return ResponseHelper::Out('success', 'Unit List Found', $customers, 200);
        }catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| CustomerController--CustomersList ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // single customer
    public function CustomersSingle(Request $request){
        try {
            $id = CustomSanitize::sanitize($request->input('id'));
            $customer = Customer::where('id', $id)->first();
            if ($customer) {
                return ResponseHelper::Out('success', 'Customer Found', $customer, 200);
            } else {
                return ResponseHelper::Out('error', 'Customer Not Found', null, 200);
            }
        }catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| CustomerController--CustomersSingle ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // customer update
    public function CustomerUpdate(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:customers,id',
                'name' => 'required',
                'phone' => 'required',
                'address' => 'nullable|string',
                'status' => 'required|in:Active,Inactive',
            ]);

            $customer = Customer::find(CustomSanitize::sanitize($request->id));

            // Check if Tax name already exists for another Tax
            $existingCustomer = Customer::where('name', CustomSanitize::sanitize($request->name))
                ->where('id', '!=', $customer->id)
                ->first();
            if ($existingCustomer) {
                return ResponseHelper::Out('error', 'Customer name already exists', null, 200);
            }

            // Update other fields
            $customer->name = CustomSanitize::sanitize($request->name);
            $customer->phone = CustomSanitize::sanitize($request->phone);
            $customer->address = CustomSanitize::sanitize($request->address);
            $customer->status = CustomSanitize::sanitize($request->status);
            $customer->save();
            return ResponseHelper::Out('success', 'Customer updated successfully', null, 200);
        } catch (\Exception $e) {
            // save error in log file
            logger()->error(now().' ||| CustomerController--CustomerUpdate ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // Customer delete
    public function CustomerDelete(Request $request)
    {
        try {
            $id = CustomSanitize::sanitize($request->input('id'));
            $customer = Customer::find($id);
            if($customer->name === 'Walking Customer') {
                return ResponseHelper::Out('error', 'Walking Customer Cannot Be Deleted', null, 200);
            }
            if ($customer) {
                // Delete tax
                $customer->delete();
                return ResponseHelper::Out('success', 'Customer Deleted Successfully', null, 200);
            } else {
                return ResponseHelper::Out('error', 'Customer Not Found', null, 200);
            }
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| CustomerController--CustomerDelete ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
}
