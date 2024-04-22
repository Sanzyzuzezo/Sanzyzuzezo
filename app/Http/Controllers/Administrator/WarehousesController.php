<?php

namespace App\Http\Controllers\Administrator;

use DB;
use DataTables;
use App\Models\Stock;
use App\Models\Company;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WarehousesController extends Controller
{
    private static $module = "warehouse";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        return view('administrator.warehouse.index');
    }

    public function getData(Request $request)
    {
        $company_id = getCompanyId();

        $query = Warehouse::select('warehouses.*');
    
        if ($company_id != 0) {
            $query->where('warehouses.company_id', $company_id);
        }
    
        if ($request->status != "") {
            $status = $request->status == "active" ? 1 : 0;
            $query->where("warehouses.status", $status);
        }
    
        $data = $query->get();

        return DataTables::of($data)->make(true);
    }

    public function getMaxWarehouse()
    {
        $company_id = getCompanyId();
        if (($company_id != 0)) {
        $company = Company::where('id', $company_id)->first();
        $max_warehouse = $company->max_warehouse;

            return $max_warehouse;
        } else {
            return 0;
        }
    }

    public function add()
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }
        return view('administrator.warehouse.add');
    }

    public function insert(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $company_id             = getCompanyId();
        $max_warehouse          = $this->getMaxWarehouse();
        $warehouse_company      = Warehouse::where('company_id', $company_id)->get();
        $cek_max_warehouse      = COUNT($warehouse_company);     

        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
            'pic' => 'required',
        ]);

        if (!$request->has('status')) {
            $status = 0;
        } else {
            $status = 1;
        }

        if ($cek_max_warehouse == $max_warehouse) {
            session()->flash('warning', 'Gagal, Jumlah warehouse sudah melebihi batas maksimal.');
            return redirect(route('admin.warehouse'));
        } else {  
        $warehouse = Warehouse::create([
            'code' => $request->code,
            'name' => $request->name,
            'pic' => $request->pic,
            'status' => $status,
            'company_id' => $company_id,
        ]);
        }
        //Write log
        createLog(static::$module, __FUNCTION__, $warehouse->id);

        return redirect('/admin/warehouse')->with(['success' => 'Your data added successfully.']);
    }

    public function edit($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        $warehouse = Warehouse::find($id);
        return view('administrator.warehouse.edit', ['warehouse' => $warehouse]);
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
            'pic' => 'required',
        ]);

        if (!$request->has('status')) {
            $status = 0;
        } else {
            $status = 1;
        }

        $warehouse = Warehouse::find($id);
        $warehouse->code = $request->code;
        $warehouse->name = $request->name;
        $warehouse->pic = $request->pic;
        $warehouse->status = $status;

        $warehouse->save();

        //Write log
        createLog(static::$module, __FUNCTION__, $id);

        return redirect('/admin/warehouse')->with(['success' => 'Your data updated successfully.']);
    }

    public function delete(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $deletedBy = auth()->user() ? auth()->user()->id : '';

        $data = Warehouse::find($request->ix);
        $data->deleted_by = $deletedBy;
        $data->update();
        $data->delete();

         //Write log
         createLog(static::$module, __FUNCTION__, $request->ix);
         return response()->json([
             'success' => true
         ]);
    }

    public function detail()
    {
        // Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $query = Warehouse::orderBy('id', 'asc');

        $company_id = getCompanyId();
        if ($company_id != 0) {
            $query->where('warehouses.company_id', $company_id);
        }

        $gudang = $query->get();

        return view("administrator.warehouse.detail", compact('gudang'));
    }

    public function getDataDetail(Request $request)
    {
        $company_id = getCompanyId();

        $query = Stock::select(['stock.*','stock.stock as stock_warehouse', 'product_variants.*', 'products.name as item_name'])
            ->join('product_variants', 'stock.item_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id');
    
        if ($company_id != 0) {
            $query->where('products.company_id', $company_id);
        }

        if ($request->has('gudang') && $request->gudang != "") {
            $gudang = $request->gudang;
            $data = $query->where("stock.warehouse_id", $gudang);
        }

        if ($request->has('gudang') && $request->gudang == "") {
            $data = [];
        }
       
        $data = $query->get();
    
        return DataTables::of($data)->make(true);
    }
}
