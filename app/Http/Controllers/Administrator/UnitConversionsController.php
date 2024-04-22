<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use App\Models\UnitConversion;
use App\Models\ProductVariant;
use App\Models\Product;
use DataTables;
use Image;
use File;
use DB;

class UnitConversionsController extends Controller
{
    private static $module = "unit_conversions";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        return view("administrator.unit_conversions.index");
    }

    public function getData(Request $request)
    {
        $company_id = getCompanyId();

        $query = UnitConversion::select(DB::raw('unit_conversions.*, products.name as item_name, product_variants.name as item_variant_name, units.name as unit_name'))
                                ->leftJoin(DB::raw('units'), 'units.id', '=', 'unit_conversions.unit_id')
                                ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'unit_conversions.item_variant_id')
                                ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                                ->orderBy('unit_conversions.created_at', 'DESC');
    
        if ($company_id != 0) {
            $query->where('unit_conversions.company_id', $company_id);
        }
    
        if ($request->status != "") {
            $status = $request->status == "active" ? 1 : 0;
            $query->where("unit_conversions.status", $status);
        }
    
        $data = $query->get();
        
        return DataTables::of($data)->make(true);
    }
    
    public function getItemDataSelect(Request $request)
    {
        $data = Product::select(DB::raw('products.name as item_name, products.id as item_id'))
                    ->where("products.id", $request->id)
                    ->first();

        return $data;
    }

    public function add()
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }
        $company_id = getCompanyId();
        
        $query = Product::select(DB::raw('products.name, products.id'))
        ->where("products.status", 1);

        if ($company_id != 0) {
            $query->where('products.company_id', $company_id);
        }

        $items = $query->get();

        return view("administrator.unit_conversions.add", compact("items"));
    }

    public function getVariantData(Request $request)
    {
        $data = ProductVariant::select(DB::raw('product_variants.name, product_variants.id'))
                    ->where("product_variants.product_id", $request->id)
                    ->get();

        return $data;
    }
    
    public function getUnitData(Request $request)
    {
        $data = ProductVariant::select(DB::raw('product_variants.name, product_variants.id, units.name as unit_name, units.id as unit_id'))
                    ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
                    ->where("product_variants.id", $request->id)
                    ->first();

        return $data;
    }

    public function save(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $company_id = getCompanyId();
        
        $this->validate($request, [
            'item_variant_id' => 'required'
        ]);

        $edit = UnitConversion::select('unit_conversions.id')
                                ->leftJoin(DB::raw('units'), 'units.id', '=', 'unit_conversions.unit_id')
                                ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'unit_conversions.item_variant_id')
                                ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                                ->where('product_variants.id', $request->item_variant_id)
                                ->where('unit_conversions.new_unit', $request->new_unit)
                                ->first();
              
        if($edit == null){
            $data = [
                'item_variant_id'    => $request->item_variant_id,
                'unit_id'      => $request->unit_id,
                'quantity'      => str_replace(',', '', $request->quantity),
                'new_quantity'      => $request->new_quantity,
                'new_unit'      => $request->new_unit,
                'status'    => $request->has('status') ? 1 : 0,
                'company_id'    => $company_id,
            ];
    
            $unit_conversions = UnitConversion::create($data);
            //Write log
            createLog(static::$module, __FUNCTION__, $unit_conversions->id);

            return redirect(route('admin.unit_conversions'));
        }else{
            return redirect(route('admin.unit_conversions'))->with(['danger' => 'This unit conversion for the product already exists.']);
        }

    }

    public function edit($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $edit = UnitConversion::select(DB::raw('unit_conversions.*, units.name as unit_name, products.id as item_id, products.name as item_name, product_variants.name as item_variant_name'))
                                ->leftJoin(DB::raw('units'), 'units.id', '=', 'unit_conversions.unit_id')
                                ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'unit_conversions.item_variant_id')
                                ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                                ->find($id);
        if (!$edit) {
            return abort(404);
        }

        $items = Product::select(DB::raw('products.name, products.id'))
                    ->where("products.status", 1)
                    ->get();

        $item_variants = ProductVariant::select(DB::raw('product_variants.name, product_variants.id'))
                                        ->where("product_variants.product_id", $edit->item_id)
                                        ->get();

        return view("administrator.unit_conversions.edit", compact("edit", "items", "item_variants"));
    }

    public function update(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        
        $this->validate($request, [
            'item_variant_id' => 'required'
        ]);

        $data = [
            'item_variant_id'    => $request->item_variant_id,
            'unit_id'      => $request->unit_id,
            'quantity'      => str_replace(',', '', $request->quantity),
            'new_quantity'      => $request->new_quantity,
            'new_unit'      => $request->new_unit,
            'status'    => $request->has('status') ? 1 : 0,
        ];

        $id = $request->id;
        $unit_conversions = UnitConversion::where('id', $id)->update($data);
        //Write log
        createLog(static::$module, __FUNCTION__, $id);
        return redirect(route('admin.unit_conversions'));
    }

    public function delete(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $deletedBy = auth()->user() ? auth()->user()->id : '';

        $data = UnitConversion::find($request->ix);
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
