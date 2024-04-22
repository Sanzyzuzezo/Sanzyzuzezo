<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;
use DataTables;
use DB;

class UnitsController extends Controller
{
    private static $module = "units";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        return view('administrator.units.index');
    }

    public function getData(Request $request)
    {
        $company_id = getCompanyId();

        $query = Unit::select('units.*');
    
        if ($company_id != 0) {
            $query->where('units.company_id', $company_id);
        }
    
        if ($request->status != "") {
            $status = $request->status == "active" ? 1 : 0;
            $query->where("units.status", $status);
        }
    
        $data = $query->get();

        return DataTables::of($data)->make(true);
    }

    public function add()
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }
        return view('administrator.units.add');
    }

    public function insert(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $company_id = getCompanyId();

        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
        ]);

        if (!$request->has('status')) {
            $status = 0;
        } else {
            $status = 1;
        }

        $units = Unit::create([
            'code' => $request->code,
            'name' => $request->name,
            'status' => $status,
            'company_id' => $company_id,
        ]);

        //Write log
        createLog(static::$module, __FUNCTION__, $units->id);

        return redirect('/admin/units')->with(['success' => 'Your data added successfully.']);
    }

    public function edit($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        $units = Unit::find($id);
        return view('administrator.units.edit', ['units' => $units]);
    }

    public function update($id, Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
        ]);

        if (!$request->has('status')) {
            $status = 0;
        } else {
            $status = 1;
        }

        $units = Unit::find($id);
        $units->code = $request->code;
        $units->name = $request->name;
        $units->status = $status;

        $units->save();

        //Write log
        createLog(static::$module, __FUNCTION__, $id);

        return redirect('/admin/units')->with(['success' => 'Your data updated successfully.']);
    }

    public function delete(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $deletedBy = auth()->user() ? auth()->user()->id : '';

        $data = Unit::find($request->ix);
        $data->deleted_by = $deletedBy;
        $data->update();
        $data->delete();

         //Write log
         createLog(static::$module, __FUNCTION__, $request->ix);
         return response()->json([
             'success' => true
         ]);
    }
}
