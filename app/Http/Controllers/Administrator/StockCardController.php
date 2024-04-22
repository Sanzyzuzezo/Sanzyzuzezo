<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\StockCard;
use App\Models\StockCardDetail;
use App\Models\UnitConversion;
use App\Models\Warehouse;
use App\Models\Stock;
use App\Models\Store;
use App\Models\StoreStock;
use DataTables;
use Image;
use File;
use DB;
use Redirect;

class StockCardController extends Controller
{
    private static $module = "stock_card";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        return view("administrator.stock_card.index");
    }

    public function getData(Request $request)
    {
        $company_id = getCompanyId();

        $query = StockCard::select(DB::raw('warehouses.name as warehouse_name, stock_card.id, stock_card.date, stock_card.transaction_type, stock_card.status, stock_card.canceled_at, stock_card.warehouse_id, stock_card.destination_warehouse_id, stock_card.store_id'))
                                ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'stock_card.warehouse_id')
                                ->orderBy('stock_card.created_at', 'DESC');

        if ($company_id != 0) {
            $query->where('stock_card.company_id', $company_id);
        }

        if ($request->transaction_type != "") {
            $query->where("stock_card.transaction_type", $request->transaction_type);
        }

        if ($request->status != "canceled" && $request->status != "") {
            $status = $request->status == "active" ? 1 : 0;
            $query->where("stock_card.status", $status)
                  ->whereNull("stock_card.canceled_at");
        }        
    
        if ($request->status == "canceled") {
            $query->whereNotNull("stock_card.canceled_at");
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

        return view("administrator.stock_card.add");
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

    // public function getItemData()
    // {
    //     $data = Product::select(DB::raw('products.name as item_name, product_variants.name as item_variant_name, product_variants.id as item_variant_id, units.name as unit_name, units.id as unit_id'))
    //                     ->leftJoin(DB::raw('product_variants'), 'product_variants.product_id', '=', 'products.id')
    //                     ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
    //                     ->where("products.status", 1)
    //                     ->groupBy("product_variants.id")
    //                     ->get();

    //     return DataTables::of($data)->make(true);
    // }

    public function getItemData(Request $request)
    {        
        $query = Product::select(DB::raw('products.name as item_name, product_variants.sku as sku_variant, product_variants.name as item_variant_name, product_variants.id as item_variant_id, (SELECT SUM(stock.stock) FROM stock WHERE stock.item_variant_id=product_variants.id AND stock.warehouse_id='.$request->warehouse_id.') as stock, units.name as unit_name, units.id as unit_id'))
                        ->leftJoin(DB::raw('product_variants'), 'product_variants.product_id', '=', 'products.id')
                        ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
                        ->where("products.status", 1)
                        ->groupBy(["product_variants.id","products.name","units.name","units.id"]);
                        
        $company_id = getCompanyId();
        if ($company_id != 0) {
            $query->where('products.company_id', $company_id);
        }

        $data = $query->get();
        // dd($data);
                        
        return DataTables::of($data)->make(true);
    }
    
    public function getUnitData(Request $request)
    {                    
        $query = UnitConversion::select(DB::raw('unit_conversions.new_unit as name, unit_conversions.id'))
                                ->where("unit_conversions.item_variant_id", $request->item_variant_id)
                                ->where("unit_conversions.status", 1);

        $company_id = getCompanyId();
        if ($company_id != 0) {
            $query->where('unit_conversions.company_id', $company_id);
        }

        $data = $query->get();

        return $data;
    }

    public function getDestinationWarehouseData(Request $request)
    {
        $query = Warehouse::select(DB::raw('warehouses.id, warehouses.code, warehouses.name'))
                        ->where("warehouses.status", 1)
                        ->where("warehouses.id", "!=", $request->id);

        $company_id = getCompanyId();
        if ($company_id != 0) {
            $query->where('warehouses.company_id', $company_id);
        }

        $data = $query->get();

        return DataTables::of($data)->make(true);
    }    
    
    public function getStoreData()
    {
        $query = Store::select(DB::raw('stores.id, stores.name'))
                        ->where("stores.status", 1);

        $company_id = getCompanyId();
        if ($company_id != 0) {
            $query->where('stores.company_id', $company_id);
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
            'transaction_type' => 'required',
            'warehouse_id' => 'required'
        ]);

        if ($request->has('item')) {
            $stock_cards_data = $request->item;
            // dd($stock_cards_data);
            foreach ($stock_cards_data as $stock_card) {
                // dd($stock_card['unit_id']);
                $unit_conversion = UnitConversion::select(DB::raw('unit_conversions.quantity'))->find($stock_card['unit_id']);
                // $unit_conversion = UnitConversion::where('id', $stock_card['unit_id'])->value('quantity');


                                                    // dd($unit_conversion);
                $stock = Stock::select(DB::raw('stock.stock'))
                                ->where("item_variant_id", $stock_card['item_variant_id'])
                                ->where("warehouse_id", $request->warehouse_id)
                                ->first();

                $item = ProductVariant::select(DB::raw('products.name as item_name, product_variants.name as item_variant_name'))
                                        ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                                        ->find($stock_card['item_variant_id']);                

                if($request->transaction_type == 'out' && ((str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1)) > $stock['stock']){
                    return redirect('/admin/stock_card/add')->with(['error' => $item->item_name.' - '.$item->item_variant_name.' Out of stock!']);
                }
            }
        }

        $data = [
            'date'                          => date('Y-m-d', strtotime($request->date)),
            'transaction_type'              => $request->transaction_type,
            'warehouse_id'                  => $request->warehouse_id,
            'destination_warehouse_id'      => $request->destination_warehouse_id,
            'store_id'                      => $request->store_id,
            'status'                        => $request->has('status') ? 1 : 0,
            'company_id'                    => $company_id
        ];
        $stock_cards = StockCard::create($data);
        
        if ($request->has('item')) {
            $stock_cards_data = $request->item;
            foreach ($stock_cards_data as $stock_card) {
                $unit_conversion = UnitConversion::select(DB::raw('unit_conversions.quantity'))
                                                    ->find($stock_card['unit_id']);

                $stock_cards->stock_card_detail()->create([
                    'stock_card_id'                 => $stock_cards->id,
                    'item_variant_id'               => $stock_card['item_variant_id'],
                    'quantity'                      => str_replace(',', '', $stock_card['quantity']),
                    // 'quantity_after_conversion'     => (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                    'quantity_after_conversion'     => (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                    'unit_id'                       => $stock_card['unit_id'],
                ]);

                if($request->transaction_type == 'in' || $request->transaction_type == 'out'){
                    // transfer gudang -> update stock di tabel stock
                    $cek_stock = Stock::where(["item_variant_id" => $stock_card['item_variant_id']])->where(["warehouse_id" => $request->warehouse_id]);
                    if($cek_stock->count() == 0){
                        $stock_data = [
                            'item_variant_id'   => $stock_card['item_variant_id'],
                            'warehouse_id'      => $request->warehouse_id,
                            'stock'             => (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                        ];
                        Stock::create($stock_data);
                    }else{
                        $stock_id = $cek_stock->first()->id;
                        if($request->transaction_type == 'in'){
                            $stock_data = [
                                'stock'         => $cek_stock->first()->stock + (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                            ];
                            Stock::where('id', $stock_id)->update($stock_data);
                        }else if($request->transaction_type == 'out'){
                            $stock_data = [
                                'stock'         => $cek_stock->first()->stock - (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                            ];
                            Stock::where('id', $stock_id)->update($stock_data);
                        }
                    }

                    // transfer gudang -> update stock di item variant
                    $cek_variant = ProductVariant::where(["id" => $stock_card['item_variant_id']]);
                    if($cek_variant->count() != 0){
                        $variant_data = [
                            'stock' => Stock::where("item_variant_id", $stock_card['item_variant_id'])
                                            ->sum(\DB::raw('CAST(stock AS NUMERIC)')),
                        ];       
                        // ProductVariant::where('id', $stock_card['item_variant_id'])->update($variant_data);                                               
                    }
                }else if($request->transaction_type == 'move_location'){
                    // transfer gudang -> move location
                    $cek_stock = Stock::where(["item_variant_id" => $stock_card['item_variant_id']])->where(["warehouse_id" => $request->warehouse_id]);
                    if($cek_stock->count() == 0){
                        $stock_data = [
                            'item_variant_id'   => $stock_card['item_variant_id'],
                            'warehouse_id'      => $request->warehouse_id,
                            'stock'             => (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                        ];
                        Stock::create($stock_data);
                    }else{
                        $stock_id = $cek_stock->first()->id;
                        $origin_warehouse = [
                            'stock'         => $cek_stock->first()->stock - (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                        ];
                        Stock::where('id', $stock_id)->update($origin_warehouse);
                    }
                    
                    $destination = Stock::where(["item_variant_id" => $stock_card['item_variant_id']])->where(["warehouse_id" => $request->destination_warehouse_id]);
                    if($destination->count() == 0){
                        $destination_warehouse = [
                            'item_variant_id'   => $stock_card['item_variant_id'],
                            'warehouse_id'      => $request->destination_warehouse_id,
                            'stock'         => (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                        ];
                        Stock::create($destination_warehouse);
                    }else{
                        $destination_warehouse = [
                            'stock'         => $destination->first()->stock + (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                        ];
                        $destination_id = $destination->first()->id;
                        Stock::where('id', $destination_id)->update($destination_warehouse);
                    }
                }else if($request->transaction_type == 'transfer_to_store'){
                    // transfer warehouse to store

                    // stok keluar dari gudang
                    $cek_stock = Stock::where(["item_variant_id" => $stock_card['item_variant_id']])->where(["warehouse_id" => $request->warehouse_id]);
                    $stock_id = $cek_stock->first()->id;
                    $stock_data = [
                        'stock'         => $cek_stock->first()->stock - (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                    ];
                    Stock::where('id', $stock_id)->update($stock_data);
                    
                    // stok masuk ke store
                    $store = StoreStock::where(["item_variant_id" => $stock_card['item_variant_id']])->where(["store_id" => $request->store_id]);
                    if($store->count() == 0){
                        $store_data = [
                            'item_variant_id'   => $stock_card['item_variant_id'],
                            'store_id'      => $request->store_id,
                            'stock'         => (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                        ];
                        StoreStock::create($store_data);
                    }else{
                        $store_data = [
                            'stock'         => $store->first()->stock + (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                        ];
                        $store_id = $store->first()->id;
                        StoreStock::where('id', $store_id)->update($store_data);
                    }
                }
            }
        }

        //Write log
        createLog(static::$module, __FUNCTION__, $stock_cards->id);
        return redirect(route('admin.stock_card'));
    }

    public function edit($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $edit = StockCard::select(DB::raw('warehouses.id as warehouse_id, warehouses.code as warehouse_code, warehouses.name as warehouse_name, stock_card.id, stock_card.date, stock_card.transaction_type, stock_card.status, stock_card.destination_warehouse_id, stock_card.store_id, stock_card.canceled_at'))
                                ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'stock_card.warehouse_id')
                                ->find($id);
        
        $stock_card_detail = StockCardDetail::select(DB::raw('stock_card_detail.id, products.name as item_name, product_variants.name as item_variant_name, stock_card_detail.quantity, stock_card_detail.unit_id, units.name as unit_name, stock_card_detail.stock_card_id, product_variants.id as item_variant_id, (SELECT stock.stock FROM stock WHERE stock.item_variant_id=product_variants.id AND stock.warehouse_id='.$edit->warehouse_id.') as stock, stock_card_detail.quantity_after_conversion, stock_card_detail.canceled_at'))
                                            ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'stock_card_detail.item_variant_id')
                                            ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                                            ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
                                            ->where("stock_card_detail.stock_card_id", $id)
                                            ->get();

        if($edit->destination_warehouse_id != 0){
            $destination_warehouse = Warehouse::select(DB::raw('warehouses.id, warehouses.code, warehouses.name'))->find($edit->destination_warehouse_id);
        }else{
            $destination_warehouse = Warehouse::select(DB::raw('warehouses.id, warehouses.code, warehouses.name'))->first();
        }
        
        if($edit->store_id != 0){
            $store = Store::select(DB::raw('stores.id, stores.name'))->find($edit->store_id);
        }else{
            $store = Store::select(DB::raw('stores.id, stores.name'))->first();
        }

        if (!$edit) {
            return abort(404);
        }

        return view("administrator.stock_card.edit", compact("edit", "stock_card_detail", "destination_warehouse", "store"));
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
            'destination_warehouse_id'      => $request->destination_warehouse_id,
            'store_id'                      => $request->store_id,
            'status'                        => $request->has('status') ? 1 : 0
        ];
        $id = $request->id;
        $stock_cards = StockCard::where('id', $id)->update($data);
        if ($request->has('item')) {
            $stock_cards_req = $request->item;
            $stock_cards_id = collect($request->item)->pluck('id');
            foreach ($stock_cards_req as $stock_card) {
                if(!isset($stock_card['quantity'])){
                    return Redirect::back();
                }else{
                    $stock_card_id = isset($stock_card['id']) ? $stock_card['id'] : null;
                    $unit_conversion = UnitConversion::select(DB::raw('unit_conversions.quantity'))->find($stock_card['unit_id']);
                    $data_update = [
                        'stock_card_id'             => $id,
                        'item_variant_id'           => $stock_card['item_variant_id'],
                        'quantity'                  => str_replace(',', '', $stock_card['quantity']),
                        // 'quantity_after_conversion' => (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                        'quantity_after_conversion' => (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                        'unit_id'                   => $stock_card['unit_id'],
                    ];

                    if ($stock_card_id == null) {
                        StockCardDetail::create($data_update);
                    } else {
                        StockCardDetail::where(["id" => $stock_card_id])->update($data_update);
                    }
                    
                    if($request->transaction_type == 'in' || $request->transaction_type == 'out'){
                        // transfer gudang -> update stock di tabel stock
                        $cek_stock = Stock::where(["item_variant_id" => $stock_card['item_variant_id']])->where(["warehouse_id" => $request->warehouse_id]);
                        if($cek_stock->count() == 0){
                            $stock_data = [
                                'item_variant_id'   => $stock_card['item_variant_id'],
                                'warehouse_id'      => $request->warehouse_id,
                                'stock'             => (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                            ];
                            Stock::create($stock_data);
                        }else{
                            $stock_id = $cek_stock->first()->id;
                            if($request->transaction_type == 'in'){
                                $stock_data = [
                                    'stock'         => ($cek_stock->first()->stock - $stock_card['old_quantity']) + (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                                ];
                                Stock::where('id', $stock_id)->update($stock_data);
                            }else if($request->transaction_type == 'out'){
                                $stock_data = [
                                    'stock'         => ($cek_stock->first()->stock + $stock_card['old_quantity']) - (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                                ];
                                Stock::where('id', $stock_id)->update($stock_data);
                            }
                        }

                        // transfer gudang -> update stock di item variant
                        $cek_variant = ProductVariant::where(["id" => $stock_card['item_variant_id']]);
                        if($cek_variant->count() != 0){
                            $variant_data = [
                                'stock'          => Stock::where("item_variant_id", $stock_card['item_variant_id'])->sum(\DB::raw('CAST(stock AS NUMERIC)')),      
                            ];
                            // ProductVariant::where('id', $stock_card['item_variant_id'])->update($variant_data);
                        }
                    }else if($request->transaction_type == 'move_location'){
                        // transfer gudang -> move location
                        $cek_stock = Stock::where(["item_variant_id" => $stock_card['item_variant_id']])->where(["warehouse_id" => $request->warehouse_id]);
                        if($cek_stock->count() == 0){
                            $stock_data = [
                                'item_variant_id'   => $stock_card['item_variant_id'],
                                'warehouse_id'      => $request->warehouse_id,
                                // 'stock'             => (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                                'stock'             => (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                            ];
                            Stock::create($stock_data);
                        }else{
                            $stock_id = $cek_stock->first()->id;
                            $origin_warehouse = [
                                'stock'         => ($cek_stock->first()->stock + $stock_card['old_quantity']) - (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                            ];
                            Stock::where('id', $stock_id)->update($origin_warehouse);
                        }
                        
                        $destination = Stock::where(["item_variant_id" => $stock_card['item_variant_id']])->where(["warehouse_id" => $request->destination_warehouse_id]);
                        if($destination->count() == 0){
                            $destination_warehouse = [
                                'item_variant_id'   => $stock_card['item_variant_id'],
                                'warehouse_id'      => $request->destination_warehouse_id,
                                'stock'         => (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                            ];
                            Stock::create($destination_warehouse);
                        }else{
                            $destination_warehouse = [
                                'stock'         => ($destination->first()->stock - $stock_card['old_quantity']) + (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                            ];
                            $destination_id = $destination->first()->id;
                            Stock::where('id', $destination_id)->update($destination_warehouse);
                        }
                    }else if($request->transaction_type == 'transfer_to_store'){
                        // transfer warehouse to store
                        
                        // update stok keluar dari gudang
                        $cek_stock = Stock::where(["item_variant_id" => $stock_card['item_variant_id']])->where(["warehouse_id" => $request->warehouse_id]);
                        $stock_id = $cek_stock->first()->id;
                        $stock_data = [
                            'stock'         => ($cek_stock->first()->stock + $stock_card['old_quantity']) - (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                        ];
                        Stock::where('id', $stock_id)->update($stock_data);
                        
                        // update stok masuk ke store
                        $store = StoreStock::where(["item_variant_id" => $stock_card['item_variant_id']])->where(["store_id" => $request->store_id]);
                        if($store->count() == 0){
                            $store_data = [
                                'item_variant_id'   => $stock_card['item_variant_id'],
                                'store_id'      => $request->store_id,
                                'stock'         => (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                            ];
                            StoreStock::create($store_data);
                        }else{
                            $store_data = [
                                'stock'         => ($store->first()->stock - $stock_card['old_quantity']) + (str_replace(',', '', $stock_card['quantity']))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
                            ];
                            $store_id = $store->first()->id;
                            StoreStock::where('id', $store_id)->update($store_data);
                        }
                    }
                }
            }
            StockCardDetail::whereNotIn('id', $stock_cards_id)->where('stock_card_id', $id)->delete();
        }

        //Write log
        createLog(static::$module, __FUNCTION__, $id);
        return redirect(route('admin.stock_card'));
    }

    public function show($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $detail = StockCard::select(DB::raw('warehouses.id as warehouse_id, warehouses.code as warehouse_code, warehouses.name as warehouse_name, stock_card.id, stock_card.date, stock_card.transaction_type'))
                                ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'stock_card.warehouse_id')
                                ->find($id);
                                
        $stock_card_detail = StockCardDetail::select(DB::raw('stock_card_detail.id, products.name as item_name, product_variants.name as item_variant_name, stock_card_detail.quantity, stock_card_detail.unit_id, units.name as unit_name, stock_card_detail.stock_card_id, product_variants.id as item_variant_id'))
                                            ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'stock_card_detail.item_variant_id')
                                            ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                                            ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
                                            ->where("stock_card_detail.stock_card_id", $id)
                                            ->get();

        // dd($stock_card_detail);

        if($detail->destination_warehouse_id != null){
            $destination_warehouse = Warehouse::select(DB::raw('warehouses.id, warehouses.code, warehouses.name'))
                                                ->find($detail->destination_warehouse_id);
        }else{
            $destination_warehouse = Warehouse::select(DB::raw('warehouses.id, warehouses.code, warehouses.name'))->first();
        }

        if (!$detail) {
            return abort(404);
        }

        return view("administrator.stock_card.detail", compact("detail", "stock_card_detail", "destination_warehouse"));
    }

    public function destroy(Request $request)
    {        
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        if($request->transaction_type == 'in' || $request->transaction_type == 'out'){

            $id = $request->ix;
            $stockCard = StockCard::find($id);
            $stockCardDetail = $stockCard->stock_card_detail;
            foreach ( $stockCardDetail as $dataDetail ) {
                $dataDetail->deleted_by = auth()->user() ? auth()->user()->id : '';
                $dataDetail->update();
                $dataDetail->delete();
            }
            $deletedBy = auth()->user() ? auth()->user()->id : '';
            $stockCard->deleted_by = $deletedBy;
            $stockCard->update();
            $stockCard->delete();

             //Write log
            createLog(static::$module, __FUNCTION__, $id);
            return response()->json([
                'success' => true
            ]);
            // StockCard::destroy($request->ix);
            // StockCardDetail::where('stock_card_id', $request->ix)->delete();

        }else if($request->transaction_type == 'move_location'){
            // cancel stock card data
            $data_update = [
                'canceled_at' => date("Y-m-d h:i:s")
            ];
            StockCard::where('id', $request->ix)->update($data_update);
            
            $stock_card_detail = StockCardDetail::where('stock_card_id', $request->ix)->whereNull('canceled_at')->get();
            foreach($stock_card_detail as $row){
                // update stock di warehouse
                $cek_stock = Stock::where(["item_variant_id" => $row->item_variant_id])->where(["warehouse_id" => $request->warehouse_id])->first();
                $origin_warehouse = [
                    'stock'         => $cek_stock->stock + $row->quantity_after_conversion,
                ];
                Stock::where('id', $cek_stock->id)->update($origin_warehouse);
                
                // update stock di destination warehouse
                $destination = Stock::where(["item_variant_id" => $row->item_variant_id])->where(["warehouse_id" => $request->destination_warehouse_id]);
                $destination_warehouse = [
                    'stock'         => $destination->first()->stock - $row->quantity_after_conversion,
                ];
                $destination_id = $destination->first()->id;
                Stock::where('id', $destination_id)->update($destination_warehouse);
                
                // cancel stock card detail data
                $data_update = [
                    'canceled_at' => date("Y-m-d h:i:s")
                ];
                StockCardDetail::where('id', $row->id)->update($data_update);
            }
        }else if($request->transaction_type == 'transfer_to_store'){
            // cancel stock card data
            $data_update = [
                'canceled_at' => date("Y-m-d h:i:s")
            ];
            StockCard::where('id', $request->ix)->update($data_update);
            
            $stock_card_detail = StockCardDetail::where('stock_card_id', $request->ix)->whereNull('canceled_at')->get();
            foreach($stock_card_detail as $row){
                // update stock di warehouse
                $cek_stock = Stock::where(["item_variant_id" => $row->item_variant_id])->where(["warehouse_id" => $request->warehouse_id]);
                $stock_id = $cek_stock->first()->id;
                $origin_warehouse = [
                    'stock'         => $cek_stock->first()->stock + $row->quantity_after_conversion,
                ];
                Stock::where('id', $stock_id)->update($origin_warehouse);
                
                // update stock di store
                $store = StoreStock::where(["item_variant_id" => $row->item_variant_id])->where(["store_id" => $request->store_id])->first();
                $store_stock = [
                    'stock'         => $store->stock - $row->quantity_after_conversion,
                ];
                StoreStock::where('id', $store->id)->update($store_stock);
                
                // cancel stock card detail data
                $data_update = [
                    'canceled_at' => date("Y-m-d h:i:s")
                ];
                StockCardDetail::where('id', $row->id)->update($data_update);
            }
        }

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

        // update stock
        if($request->transaction_type == 'in'){
            // delete stock card detail
            StockCardDetail::destroy($request->ix);

            // update stock
            $cek_stock = Stock::where(["item_variant_id" => $request->item_variant_id])->where(["warehouse_id" => $request->warehouse_id]);
            $unit_conversion = UnitConversion::select(DB::raw('unit_conversions.quantity'))->find($request->unit_id);
            $stock_id = $cek_stock->first()->id;
            $stock_data = [
                'stock'         => $cek_stock->first()->stock - (str_replace(',', '', $request->quantity))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
            ];
            Stock::where('id', $stock_id)->update($stock_data);
        }else if($request->transaction_type == 'out'){
            // delete stock card detail
            StockCardDetail::destroy($request->ix);

            // update stock
            $cek_stock = Stock::where(["item_variant_id" => $request->item_variant_id])->where(["warehouse_id" => $request->warehouse_id]);
            $unit_conversion = UnitConversion::select(DB::raw('unit_conversions.quantity'))->find($request->unit_id);
            $stock_id = $cek_stock->first()->id;
            $stock_data = [
                'stock'         => $cek_stock->first()->stock + (str_replace(',', '', $request->quantity))*( !empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1),
            ];
            Stock::where('id', $stock_id)->update($stock_data);
        }else if($request->transaction_type == 'move_location'){
            // cancel stock card
            $data_update = [
                'canceled_at' => date("Y-m-d h:i:s")
            ];
            StockCardDetail::where(["id" => $request->ix])->update($data_update);
            
            // update stock di warehouse
            $cek_stock = Stock::where(["item_variant_id" => $request->item_variant_id])->where(["warehouse_id" => $request->warehouse_id]);
            $stock_id = $cek_stock->first()->id;
            $origin_warehouse = [
                'stock'         => $cek_stock->first()->stock + $request->quantity,
            ];
            Stock::where('id', $stock_id)->update($origin_warehouse);
            
            // update stock di destination warehouse
            $destination = Stock::where(["item_variant_id" => $request->item_variant_id])->where(["warehouse_id" => $request->destination_warehouse_id]);
            $destination_warehouse = [
                'stock'         => $destination->first()->stock - $request->quantity,
            ];
            $destination_id = $destination->first()->id;
            Stock::where('id', $destination_id)->update($destination_warehouse);
        }else if($request->transaction_type == 'transfer_to_store'){
            // cancel stock card
            $data_update = [
                'canceled_at' => date("Y-m-d h:i:s")
            ];
            StockCardDetail::where(["id" => $request->ix])->update($data_update);
            
            // update stock di warehouse
            $cek_stock = Stock::where(["item_variant_id" => $request->item_variant_id])->where(["warehouse_id" => $request->warehouse_id]);
            $stock_id = $cek_stock->first()->id;
            $origin_warehouse = [
                'stock'         => $cek_stock->first()->stock + $request->quantity,
            ];
            Stock::where('id', $stock_id)->update($origin_warehouse);
            
            // update stock di store
            $store = StoreStock::where(["item_variant_id" => $request->item_variant_id])->where(["store_id" => $request->store_id]);
            $store_stock = [
                'stock'         => $store->first()->stock - $request->quantity,
            ];
            $store_id = $store->first()->id;
            StoreStock::where('id', $store_id)->update($store_stock);
        }
        
        //Write log
        createLog(static::$module, __FUNCTION__, $request->ix);
        return response()->json([
            'success' => true
        ]);
    }

}