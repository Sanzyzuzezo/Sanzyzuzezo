<?php

namespace App\Http\Controllers\Administrator;

use DB;
use File;
use Image;
use Redirect;
use DataTables;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\SettingCompany;
use App\Models\PromotionProduct;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class PromoProductsController extends Controller
{
    private static $module = "promo_products";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        return view("administrator.promo_products.index");
    }

    public function getData(Request $request)
    {
        $company_id = getCompanyId();

        $query = Promotion::select(DB::raw('*'))
                        ->orderBy('promotions.created_at', 'DESC');

        if ($company_id != 0) {
            $query->where('promotions.company_id', $company_id);
        }

        if ($request->type != "") {
            $query->where("promotions.type", $request->type);
        }

        if ($request->status != "") {
            $status = $request->status == "active" ? 1 : 0;
            $query->where("promotions.status", $status);
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

        return view("administrator.promo_products.add");
    }

    public function getProductData()
    {
        $company_id = getCompanyId();

        $settings = SettingCompany::where("company_id", $company_id)
        ->where("settings_companies.name", "gudang_penjualan")
        ->first();

        // dd($settings->value);
        $query = Product::select(DB::raw('products.name as product_name, products.id as product_id, product_variants.sku, product_variants.name as variant_name, product_variants.id as variant_id, stock.stock, product_variants.price'))
                        ->leftJoin(DB::raw('product_variants'), 'product_variants.product_id', '=', 'products.id')
                        ->leftJoin(DB::raw('stock'), 'product_variants.id', '=', 'stock.item_variant_id')
                        ->where("stock.warehouse_id", $settings->value)
                        ->where("products.status", 1)
                        ->where("stock.stock", '>', 0)
                        ->groupBy(["product_variants.id","products.name", "products.id","stock.stock"]);

        if ($company_id != 0) {
            $query->where("products.company_id", $company_id);
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
            'promo_type' => 'required',
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $check_data = Promotion::select('promotions.*')
                        ->where('start_date', $request->start_date)
                        ->where('end_date', $request->end_date)
                        ->get();

        if($request->promo_type == 'flash_sale' && $check_data->count() > 0){
            return back()->with(['error' => 'Flash sale dengan waktu tersebut sudah ada!']);
        }else{
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName  = time() . '_' . Str::slug(strtolower($request->title)) . '.' . $image->getClientOriginalExtension();
                $path = upload_path('banner');
                $image->move($path, $fileName);
            }

            $discount_value = str_replace(',', '',  $request->discount_value);

            $data = [
                'type'                          => $request->promo_type,
                'start_at'                      => $request->start_at,
                'start_date'                    => $request->start_date,
                'end_date'                      => $request->end_date,
                'title'                         => $request->title,
                'discount_type'                 => $request->has('discount_type') ? 1 : 0,
                'discount_value'                => floatval($discount_value),
                'note'                          => $request->note,
                'status'                        => $request->has('status') ? 1 : 0,
                'image'                         => isset($fileName) ? $fileName : '',
                'company_id'                    => $company_id
            ];
            $promotion = Promotion::create($data);

            if ($request->has('product')) {
                $promotion_product = $request->product;
                foreach ($promotion_product as $data_product) {
                    $discount_value = str_replace(',', '',  $data_product['discount_value_product']);
                    $product_data = [
                        'promotion_id'                  => $promotion->id,
                        'product_id'                    => $data_product['product_id'],
                        'product_variant_id'            => $data_product['variant_id'],
                        'discount_type'                 => isset($data_product['discount_type_product']) ? 1 : 0,
                        'discount_value'                => floatval($discount_value),
                        'after_discount_price'          => $data_product['after_discount_price'],
                        // 'promotion_stock'               => floatval($data_product['promotion_stock']),
                        // 'current_stock'                 => $data_product['current_stock'],
                    ];
                    // dd($product_data);
                    PromotionProduct::create($product_data);
                }
            }
        }

        //Write log
        createLog(static::$module, __FUNCTION__, $promotion->id);
        return redirect(route('admin.promo_products'));
    }

    public function edit($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $edit = Promotion::select('promotions.*')
                            ->find($id);
                            
        $company_id = getCompanyId();

        $settings = SettingCompany::where("company_id", $company_id)
        ->where("settings_companies.name", "gudang_penjualan")
        ->first();

        $promotion_products = PromotionProduct::select(DB::raw('promotion_products.*, products.name as product_name, products.id as product_id, product_variants.sku, product_variants.name as variant_name, product_variants.id as variant_id, stock.stock, product_variants.price'))
                                            ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'promotion_products.product_variant_id')
                                            ->leftJoin(DB::raw('stock'), 'product_variants.id', '=', 'stock.item_variant_id')
                                            ->leftJoin(DB::raw('products'), 'products.id', '=', 'promotion_products.product_id')
                                            ->leftJoin(DB::raw('promotions'), 'promotions.id', '=', 'promotion_products.promotion_id')
                                            ->where("promotion_products.promotion_id", $id)
                                            ->where("stock.warehouse_id", $settings->value)
                                            ->groupBy('promotion_products.id','products.name', 'products.id', 'product_variants.sku', 'product_variants.name', 'product_variants.id', 'stock.stock', 'product_variants.price')
                                            ->get();

        if (!$edit) {
            return abort(404);
        }

        return view("administrator.promo_products.edit", compact("edit", "promotion_products"));
    }

    public function update(Request $request)
    {
        // dd($request->product);
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $this->validate($request, [
            'promo_type' => 'required',
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $promotion = Promotion::find($request->id);
            if(file_exists('./administrator/assets/media/banners/'.$promotion->image) && $promotion->image != null){
                $file_old = './administrator/assets/media/banners/'.$promotion->image;
                unlink($file_old);
            }

            $image = $request->file('image');
            $fileName  = time() . '_' . Str::slug(strtolower($request->title)) . '.' . $image->getClientOriginalExtension();
            $path = upload_path('banner');
            $image->move($path, $fileName);
        }

        $data = [
            'type'                          => $request->promo_type,
            'start_at'                      => $request->start_at,
            'start_date'                    => $request->start_date,
            'end_date'                      => $request->end_date,
            'title'                         => $request->title,
            'discount_type'                 => $request->has('discount_type') ? 1 : 0,
            'discount_value'                => $request->discount_value,
            'note'                          => $request->note,
            'status'                        => $request->has('status') ? 1 : 0,
            'image'                         => isset($fileName) ? $fileName : '',
        ];
        $id = $request->id;
        $promotion = Promotion::where('id', $id)->update($data);
        if ($request->has('product')) {
            $promotion_req = $request->product;
            $promotions_id = collect($request->product)->pluck('id')->toArray();
            foreach ($promotion_req as $data_product) {
                $promotion_id = isset($data_product['id']) ? $data_product['id'] : null;
                $discount_value = str_replace(',', '',  $data_product['discount_value_product']);
                $data_update = [
                    'promotion_id'                  => $id,
                    'product_id'                    => $data_product['product_id'],
                    'product_variant_id'            => $data_product['variant_id'],
                    'discount_type'                 => isset($data_product['discount_type_product']) ? 1 : 0,
                    'discount_value'                => floatval($discount_value),
                    'after_discount_price'          => $data_product['after_discount_price'],
                    // 'promotion_stock'               => floatval($data_product['promotion_stock']),
                    // 'current_stock'                 => $data_product['current_stock'],
                ];

                // dd($data_update);

                if ($promotion_id == null) {
                    PromotionProduct::create($data_update);
                } else {
                    PromotionProduct::where(["id" => $promotion_id])->update($data_update);
                }
            }
            PromotionProduct::whereNotIn('id', $promotions_id)->where('promotion_id', $id)->delete();
        }

        //Write log
        createLog(static::$module, __FUNCTION__, $id);
        return redirect(route('admin.promo_products'));
    }

    public function show($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $edit = Promotion::select('promotions.*')
                            ->find($id);

        $promotion_products = PromotionProduct::select(DB::raw('promotion_products.*, products.name as product_name, products.id as product_id, product_variants.sku, product_variants.name as variant_name, product_variants.id as variant_id, stock.stock, product_variants.price'))
                                            ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'promotion_products.product_variant_id')
                                            ->leftJoin(DB::raw('stock'), 'product_variants.id', '=', 'stock.item_variant_id')
                                            ->leftJoin(DB::raw('products'), 'products.id', '=', 'promotion_products.product_id')
                                            ->leftJoin(DB::raw('promotions'), 'promotions.id', '=', 'promotion_products.promotion_id')
                                            ->where("promotion_products.promotion_id", $id)
                                            ->get();

        if (!$edit) {
            return abort(404);
        }

        return view("administrator.promo_products.detail", compact("edit", "promotion_products"));
    }

    public function destroy(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $id = $request->ix;
        $promotion = Promotion::find($id);
        $promotion_product = PromotionProduct::where('promotion_id', $id)->get();
        $deletedBy = auth()->user() ? auth()->user()->id : '';

        if(file_exists('./administrator/assets/media/banners/'.$promotion->image) && $promotion->image != null){
            $file_old = './administrator/assets/media/banners/'.$promotion->image;
            unlink($file_old);
        }

        foreach ( $promotion_product as $detail ) {
            $detail->deleted_by = $deletedBy;
            $detail->update();
            $detail->delete();
        }

        $promotion->deleted_by = $deletedBy;
        $promotion->update();
        $promotion->delete();

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
            $unit_conversion = UnitConversions::select(DB::raw('unit_conversions.quantity'))->find($request->unit_id);
            $stock_id = $cek_stock->first()->id;
            $stock_data = [
                'stock'         => $cek_stock->first()->stock - (str_replace(',', '', $request->quantity))*(str_replace(',', '', $unit_conversion['quantity']) != null ? str_replace(',', '', $unit_conversion['quantity']) : 1),
            ];
            Stock::where('id', $stock_id)->update($stock_data);
        }else if($request->transaction_type == 'out'){
            // delete stock card detail
            StockCardDetail::destroy($request->ix);

            // update stock
            $cek_stock = Stock::where(["item_variant_id" => $request->item_variant_id])->where(["warehouse_id" => $request->warehouse_id]);
            $unit_conversion = UnitConversions::select(DB::raw('unit_conversions.quantity'))->find($request->unit_id);
            $stock_id = $cek_stock->first()->id;
            $stock_data = [
                'stock'         => $cek_stock->first()->stock + (str_replace(',', '', $request->quantity))*(str_replace(',', '', $unit_conversion['quantity']) != null ? str_replace(',', '', $unit_conversion['quantity']) : 1),
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
