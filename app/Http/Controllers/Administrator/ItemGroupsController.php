<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ItemGroup;
use DataTables;
use DB;

class ItemGroupsController extends Controller
{
    private static $module = "item_groups";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        return view('administrator.item_groups.index');
    }

    public function getData(Request $request)
    {
        $company_id = getCompanyId();
    
        $query = ItemGroup::select('item_groups.*');
    
        if ($company_id != 0) {
            $query->where('item_groups.company_id', $company_id);
        }
    
        if ($request->status != "") {
            $status = $request->status == "active" ? 1 : 0;
            $query->where("item_groups.status", $status);
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
        return view('administrator.item_groups.add');
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

        $item_groups = ItemGroup::create([
            'code' => $request->code,
            'name' => $request->name,
            'status' => $status,
            'company_id' => $company_id
        ]);

        //Write log
        createLog(static::$module, __FUNCTION__, $item_groups->id);

        return redirect('/admin/item_groups')->with(['success' => 'Your data added successfully.']);
    }

    public function edit($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        $item_groups = ItemGroup::find($id);
        return view('administrator.item_groups.edit', ['item_groups' => $item_groups]);
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

        $item_groups = ItemGroup::find($id);
        $item_groups->code = $request->code;
        $item_groups->name = $request->name;
        $item_groups->status = $status;

        $item_groups->save();

        //Write log
        createLog(static::$module, __FUNCTION__, $id);

        return redirect('/admin/item_groups')->with(['success' => 'Your data updated successfully.']);
    }

    public function delete(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $deletedBy = auth()->user() ? auth()->user()->id : '';

        $data = ItemGroup::find($request->ix);
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
