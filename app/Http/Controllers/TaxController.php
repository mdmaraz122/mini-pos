<?php

namespace App\Http\Controllers;

use App\Helper\CustomSanitize;
use App\Helper\FetchCurrentAdmin;
use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Tax;
use Exception;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    // +++++++ Tax ++++++++
    // create Tax
    public function taxCreate(Request $request){
        try {
            // validate data
            $request->validate([
                'name' => 'required',
                'percentage' => 'required|numeric'
            ]);
            // check
            $data = FetchCurrentAdmin::GetCurrentAdmin($request);

            $name = CustomSanitize::sanitize($request->input('name'));
            $percentage = CustomSanitize::sanitize($request->input('percentage'));


            // name is unique
            $tax = Tax::where('name', $name)->first();
            if ($tax) {
                return ResponseHelper::Out('error', 'Tax Name Already Exists', null, 200);
            }
            // Create new category
            $tax = new Tax();
            $tax->name = $name;
            $tax->percentage = $percentage;
            $tax->admin_id = $data->userID;
            $tax->save();
            return ResponseHelper::Out('success', 'Tax Created Successfully', null, 200);
        }catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| TaxController--taxCreate ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // list Tax
    public function taxList(Request $request){
        try {
            // check
            $data = FetchCurrentAdmin::GetCurrentAdmin($request);
            // get all categories
            $taxes = Tax::orderBy('id', 'desc')
                ->get();
            return ResponseHelper::Out('success', 'Tax List Found', $taxes, 200);
        }catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| TaxController--taxList ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // single Tax
    public function taxSingle(Request $request){
        try {
            $id = CustomSanitize::sanitize($request->input('id'));
            $tax = Tax::where('id', $id)->first();
            if ($tax) {
                return ResponseHelper::Out('success', 'Tax Found', $tax, 200);
            } else {
                return ResponseHelper::Out('error', 'Tax Not Found', null, 200);
            }
        }catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| TaxController--taxSingle ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // update Tax
    public function taxUpdate(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:taxes,id',
                'name' => 'required',
                'percentage' => 'required|numeric',
                'status' => 'required|in:Active,Inactive',
            ]);

            $tax = Tax::find(CustomSanitize::sanitize($request->id));

            // Check if Tax name already exists for another Tax
            $existingTax = Tax::where('name', CustomSanitize::sanitize($request->name))
                ->where('id', '!=', $tax->id)
                ->first();
            if ($existingTax) {
                return ResponseHelper::Out('error', 'Tax name already exists', null, 200);
            }

            // Update other fields
            $tax->name = CustomSanitize::sanitize($request->name);
            $tax->percentage = CustomSanitize::sanitize($request->percentage);
            $tax->status = CustomSanitize::sanitize($request->status);
            $tax->save();
            return ResponseHelper::Out('success', 'Tax updated successfully', null, 200);
        } catch (\Exception $e) {
            // save error in log file
            logger()->error(now().' ||| TaxController--taxUpdate ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // delete Tax
    public function taxDelete(Request $request)
    {
        try {
            $id = CustomSanitize::sanitize($request->input('id'));
            $tax = Tax::find($id);
            if ($tax) {
                // Delete tax
                $tax->delete();
                return ResponseHelper::Out('success', 'Tax Deleted Successfully', null, 200);
            } else {
                return ResponseHelper::Out('error', 'Tax Not Found', null, 200);
            }
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| TaxController--taxDelete ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // get Tax by status
    public function taxStatus(Request $request)
    {
        try {
            $taxes = Tax::where('status', 'Active')->get();
            return ResponseHelper::Out('success', 'Tax List Found', $taxes, 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| TaxController--taxStatus ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
}
