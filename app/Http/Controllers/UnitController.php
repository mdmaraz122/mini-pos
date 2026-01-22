<?php

namespace App\Http\Controllers;

use App\Helper\CustomSanitize;
use App\Helper\FetchCurrentAdmin;
use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function UnitsCreate(Request $request){
        try {
            // validate data
            $request->validate([
                'name' => 'required',
            ]);
            // check
            $data = FetchCurrentAdmin::GetCurrentAdmin($request);
            $name = CustomSanitize::sanitize($request->input('name'));
            // name is unique
            $base_unit = Unit::where('name', $name)->first();
            if ($base_unit) {
                return ResponseHelper::Out('error', 'Unit Name Already Exists', null, 200);
            }
            // Create new BaseUnit
            $base_unit = new Unit();
            $base_unit->name = $name;
            $base_unit->admin_id = $data->userID;
            $base_unit->save();
            return ResponseHelper::Out('success', 'Unit Created Successfully', null, 200);
        }catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| UnitController--UnitsCreate ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // list Units
    public function UnitsList(Request $request){
        try {
            // check
            $data = FetchCurrentAdmin::GetCurrentAdmin($request);
            // get all categories
            $base_unit = Unit::orderBy('id', 'asc')
                ->get();
            if(!$base_unit){
                return ResponseHelper::Out('error', 'Unit Not Found', null, 200);
            }
            return ResponseHelper::Out('success', 'Unit List Found', $base_unit, 200);
        }catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| UnitController--UnitsList ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // single Units
    public function UnitsSingle(Request $request){
        try {
            $id = CustomSanitize::sanitize($request->input('id'));
            $base_unit = Unit::where('id', $id)->first();
            if ($base_unit) {
                return ResponseHelper::Out('success', 'Unit Found', $base_unit, 200);
            } else {
                return ResponseHelper::Out('error', 'Unit Not Found', null, 200);
            }
        }catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| UnitController--UnitsSingle ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // update Units
    public function UnitsUpdate(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:units,id',
                'name' => 'required',
                'status' => 'required|in:Active,Inactive',
            ]);

            $base_unit = Unit::find(CustomSanitize::sanitize($request->id));

            // Check if Tax name already exists for another Tax
            $existingTax = Unit::where('name', CustomSanitize::sanitize($request->name))
                ->where('id', '!=', $base_unit->id)
                ->first();
            if ($existingTax) {
                return ResponseHelper::Out('error', 'Unit name already exists', null, 200);
            }

            // Update other fields
            $base_unit->name = CustomSanitize::sanitize($request->name);
            $base_unit->status = CustomSanitize::sanitize($request->status);
            $base_unit->save();
            return ResponseHelper::Out('success', 'Unit updated successfully', null, 200);
        } catch (\Exception $e) {
            // save error in log file
            logger()->error(now().' ||| UnitController--UnitsUpdate ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // delete Units
    public function UnitsDelete(Request $request)
    {
        try {
            $id = CustomSanitize::sanitize($request->input('id'));
            $base_unit = Unit::find($id);
            if ($base_unit) {
                // Delete tax
                $base_unit->delete();
                return ResponseHelper::Out('success', 'Unit Deleted Successfully', null, 200);
            } else {
                return ResponseHelper::Out('error', 'Unit Not Found', null, 200);
            }
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| UnitController--UnitsDelete ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
    // Units by Status
    public function UnitsStatus(Request $request)
    {
        try {
            $base_unit = Unit::where('status', 'Active')->get();
            return ResponseHelper::Out('success', 'Unit List Found', $base_unit, 200);
        } catch (Exception $e) {
            // save error in log file
            logger()->error(now().' ||| UnitController--UnitsStatus ||| ' . $e->getMessage());
            return ResponseHelper::Out('error', 'Something Went Wrong', null, 200);
        }
    }
}
