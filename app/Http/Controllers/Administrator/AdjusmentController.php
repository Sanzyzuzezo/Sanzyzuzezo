<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Adjusment;
use App\Models\AdjusmentDetail;
use App\Models\UnitConversions;
use App\Models\Warehouse;
use App\Models\Stock;
use DataTables;
use Image;
use File;
use DB;
use Redirect;

class AdjusmentController extends Controller
{
    private static $module = "adjusment";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        return view("administrator.adjusment.index");
    }

    public function getData()
    {
        $company_id = getCompanyId();

        $query = Adjusment::select(DB::raw('warehouses.name as warehouse_name, adjusment.id, adjusment.date'))
                                ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'adjusment.warehouse_id')
                                ->orderBy('adjusment.created_at', 'DESC');

        if ($company_id != 0) {
            $query->where('adjusment.company_id', $company_id);
        }
    
        $data = $query->get();
        
        return DataTables::of($data)->make(true);
    }

    public function create()
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        return view("administrator.adjusment.add");
    }

    public function getWarehouseData()
    {
        $query = Warehouse::select(DB::raw('warehouses.id, warehouses.code, warehouses.name'))
                        ->where("warehouses.status", 1);

        $company_id = getCompanyId();
        if ($company_id != 0) {
            $query->where('warehouses.company_id', $company_id);
        }

        $data = $query->get();

        return DataTables::of($data)->make(true);
    }

    public function getItemData(Request $request)
    {        
        $query = Product::select(DB::raw('products.name as item_name, product_variants.sku as sku_variant, product_variants.name as item_variant_name, products.id as item_id, product_variants.id as item_variant_id, (SELECT stock.stock FROM stock WHERE stock.item_variant_id=product_variants.id AND stock.warehouse_id='.$request->warehouse_id.') as current_stock'))
                        ->leftJoin(DB::raw('product_variants'), 'product_variants.product_id', '=', 'products.id')
                        ->where("products.status", 1)
                        ->groupBy(["product_variants.id","products.name","products.id"]);

        $company_id = getCompanyId();
        if ($company_id != 0) {
            $query->where('products.company_id', $company_id);
        }

        $data = $query->get();
                        
        return DataTables::of($data)->make(true);
    }

    public function store(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }
        
        $company_id = getCompanyId();

        $this->validate($request, [
            'date' => 'required',
            'warehouse_id' => 'required'
        ]);

        // dd($request->date);
        // exit;

        $data = [
            'date'                          => date('Y-m-d', strtotime($request->date)),
            'warehouse_id'                  => $request->warehouse_id,
            'company_id'                    => $company_id,
        ];
        $adjusments = Adjusment::create($data);
        
        if ($request->has('item')) {
            $adjusments_data = $request->item;
            foreach ($adjusments_data as $adjusment) {
                $adjusments->adjusment_detail()->create([
                    'adjusment_id'                  => $adjusments->id,
                    'item_id'                       => $adjusment['item_id'],
                    'item_variant_id'               => $adjusment['item_variant_id'],
                    'current_stock'                 => str_replace([',', '.00'], '', $adjusment['current_stock']),
                    'new_stock'                     => str_replace([',', '.00'], '', $adjusment['new_stock']),
                    'difference'                    => str_replace([',', '.00'], '', $adjusment['difference']),
                    'note'                          => $adjusment['note'],
                ]);
                
                // update stock gudang
                $cek_stock = Stock::where(["item_variant_id" => $adjusment['item_variant_id']])->where(["warehouse_id" => $request->warehouse_id]);
                if($cek_stock->count() == 0){
                    $stock_data = [
                        'item_variant_id'   => $adjusment['item_variant_id'],
                        'warehouse_id'      => $request->warehouse_id,
                        'stock'             => str_replace([',', '.00'], '', $adjusment['new_stock']),
                    ];
                    Stock::create($stock_data);
                }else{
                    $stock_id = $cek_stock->first()->id;
                    $stock_data = [
                        'stock'             => str_replace([',', '.00'], '', $adjusment['new_stock']),
                    ];
                    Stock::where('id', $stock_id)->update($stock_data);
                }
            }
        }

        //Write log
        createLog(static::$module, __FUNCTION__, $adjusments->id);
        return redirect(route('admin.adjusment'));
    }

    public function edit($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $edit = Adjusment::select(DB::raw('warehouses.id as warehouse_id, warehouses.code as warehouse_code, warehouses.name as warehouse_name, adjusment.id, adjusment.date'))
                                ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'adjusment.warehouse_id')
                                ->find($id);
                                                    
        $adjusment_detail = AdjusmentDetail::select(DB::raw('adjusment_detail.id, products.name as item_name, product_variants.sku as sku_variant, product_variants.name as item_variant_name, adjusment_detail.new_stock, adjusment_detail.difference, products.id as item_id, product_variants.id as item_variant_id, adjusment_detail.current_stock, adjusment_detail.note'))
                                            ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'adjusment_detail.item_variant_id')
                                            ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                                            ->where("adjusment_detail.adjusment_id", $id)
                                            ->get();

        if (!$edit) {
            return abort(404);
        }

        return view("administrator.adjusment.edit", compact("edit", "adjusment_detail"));
    }

    public function update(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $this->validate($request, [
            'date' => 'required',
            'warehouse_id' => 'required'
        ]);

        $data = [
            'date'                          => date('Y-m-d', strtotime($request->date)),
            'warehouse_id'                  => $request->warehouse_id,
        ];
        $id = $request->id;
        $adjusments = Adjusment::where('id', $id)->update($data);

        if ($request->has('item')) {
            $adjusments_req = $request->item;
            $adjusments_id = collect($request->item)->pluck('id');
            foreach ($adjusments_req as $adjusment) {
                if($adjusment['new_stock'] == null){
                    return Redirect::back();
                }else{
                    $adjusment_id = isset($adjusment['id']) ? $adjusment['id'] : null;
                    $data_update = [
                        'adjusment_id'     => $id,
                        'item_id'          => $adjusment['item_id'],
                        'item_variant_id'  => $adjusment['item_variant_id'],
                        'current_stock'    => str_replace([',', '.00'], '', $adjusment['current_stock']),
                        'new_stock'        => str_replace([',', '.00'], '', $adjusment['new_stock']),
                        'difference'       => str_replace([',', '.00'], '', $adjusment['difference']),
                        'note'             => $adjusment['note'],
                    ];

                    if ($adjusment_id == null) {
                        AdjusmentDetail::create($data_update);
                    } else {
                        AdjusmentDetail::where(["id" => $adjusment_id])->update($data_update);
                    }
                    
                    // update stock gudang
                    $cek_stock = Stock::where(["item_variant_id" => $adjusment['item_variant_id']])->where(["warehouse_id" => $request->warehouse_id]);
                    if($cek_stock->count() == 0){
                        $stock_data = [
                            'item_variant_id'   => $adjusment['item_variant_id'],
                            'warehouse_id'      => $request->warehouse_id,
                            'stock'             => str_replace([',', '.00'], '', $adjusment['new_stock']),
                        ];
                        Stock::create($stock_data);
                    }else{
                        $stock_id = $cek_stock->first()->id;
                        $stock_data = [
                            'stock'             => str_replace([',', '.00'], '', $adjusment['new_stock']),
                        ];
                        Stock::find($stock_id)->update($stock_data);
                    }
                }
            }
            AdjusmentDetail::whereNotIn('id', $adjusments_id)->where('adjusment_id', $id)->delete();
        }

        //Write log
        createLog(static::$module, __FUNCTION__, $id);
        return redirect(route('admin.adjusment'));
    }

    public function show($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $detail = Adjusment::select(DB::raw('warehouses.id as warehouse_id, warehouses.code as warehouse_code, warehouses.name as warehouse_name, adjusment.id, adjusment.date'))
                                ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'adjusment.warehouse_id')
                                ->find($id);
                                                    
        $adjusment_detail = AdjusmentDetail::select(DB::raw('adjusment_detail.id, products.name as item_name, product_variants.sku as sku_variant, product_variants.name as item_variant_name, adjusment_detail.new_stock, adjusment_detail.difference, product_variants.id as item_variant_id, (SELECT stock.stock FROM stock WHERE stock.item_variant_id=product_variants.id AND stock.warehouse_id='.$detail->warehouse_id.') as current_stock'))
                                            ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'adjusment_detail.item_variant_id')
                                            ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                                            ->where("adjusment_detail.adjusment_id", $id)
                                            ->get();

        if (!$detail) {
            return abort(404);
        }

        return view("administrator.adjusment.detail", compact("detail", "adjusment_detail"));
    }
        

    public function destroy(Request $request)
    {        
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $id = $request->ix;
        $adjusment = Adjusment::find($id);
        $adjusment_detail = AdjusmentDetail::where('adjusment_id', $id)->get();
        $deletedBy = auth()->user() ? auth()->user()->id : ''; 

        foreach ( $adjusment_detail as $detail ) {
            $detail->deleted_by = $deletedBy;
            $detail->update();
            $detail->delete();
        }

        $adjusment->deleted_by = $deletedBy;
        $adjusment->update();
        $adjusment->delete();

        // Adjusment::destroy($request->ix);
        // AdjusmentDetail::where('adjusment_id', $request->ix)->delete();
        //Write log
        createLog(static::$module, __FUNCTION__, $request->ix);
        return response()->json([
            'success' => true
        ]);
    }
    
    public function deleteDetail(Request $request)
    {        
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        AdjusmentDetail::destroy($request->ix);
        //Write log
        createLog(static::$module, __FUNCTION__, $request->ix);
        return response()->json([
            'success' => true
        ]);
    }
}