<?php

namespace App\Http\Controllers\Administrator;

use DB;
use File;
use Image;
use Redirect;
use DataTables;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Production;
use App\Models\Ingredients;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\UnitConversions;
use App\Models\IngredientDetail;
use App\Models\ProductionDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ProduksiController extends Controller
{
    private static $module = "produksi";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        return view("administrator.produksi.index");
    }

    public function getData(Request $request)
    {
        $company_id = getCompanyId();

        $query = Production::select(DB::raw('warehouses.name as nama_warehouse, product_variants.name as nama_item_variant, products.name as nama_item, productions.id, productions.date, productions.no_production'))
                                ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'productions.warehouse_id')
                                ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'productions.item_variant_id')
                                ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                                ->orderBy('productions.created_at', 'DESC');

        if ($company_id != 0) {
            $query->where('productions.company_id', $company_id);
        }
                                                        
        if ($request->warehouse_id || $request->item_id || $request->variant_id) {
            $query = $query->where(function ($query) use ($request) {
                if ($request->warehouse_id != "") {
                    $query->where("productions.warehouse_id", $request->warehouse_id);
                }
                if ($request->item_id != "") {
                    $query->where("products.id", $request->item_id);
                }
                if ($request->variant_id != "") {
                    $query->where("productions.item_variant_id", $request->variant_id);
                }
            });
        }

        $data = $query->get();

        return DataTables::of($data)
        ->addColumn('action', function ($row) {
            $btn = "";
            if(isAllowed(static::$module, "detail"))://Check permission
                $btn .= '<a href="' . route('admin.produksi.detail', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/>
                        <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/>
                    </svg>
                </span>
            </a>';
            endif;
            if(isAllowed(static::$module, "edit"))://Check permission
            $btn .= '<a href="' . route('admin.produksi.edit', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                    </svg>
                </span>
            </a>';
            endif;
            if(isAllowed(static::$module, "delete"))://Check permission
            $btn .= '<a href="#" data-ix="' . $row->id . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete">
                <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                    </svg>
                </span>
            </a>';
            endif;
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    function generateNomor() {
        $company_id = getCompanyId();
        $nomorUrut = Production::select('id')->where('company_id', $company_id)->withTrashed()->orderBy('id', 'desc')->first();
        $nomorUrut = $nomorUrut ? $nomorUrut->id + 1 : 1;

        $bulan = date('n');
        $bulanRomawi = $this->konversiBulanKeRomawi($bulan);
        $tahun = date('Y');

        $kodeTertentu = $nomorUrut . '/PRODUCTION/'. $company_id . '/' . $bulanRomawi . '/' . $tahun;

        return $kodeTertentu;
    }

    function konversiBulanKeRomawi($bulan) {
        $bulanRomawi = [
            1 => "I",
            2 => "II",
            3 => "III",
            4 => "IV",
            5 => "V",
            6 => "VI",
            7 => "VII",
            8 => "VIII",
            9 => "IX",
            10 => "X",
            11 => "XI",
            12 => "XII"
        ];

        return isset($bulanRomawi[$bulan]) ? $bulanRomawi[$bulan] : "lain";
    }

    public function create()
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $nomor_produksi = $this->generateNomor();

        return view("administrator.produksi.add", compact('nomor_produksi'));
    }

    public function getVariantData(Request $request)
    {
        $company_id = getCompanyId();
        $data = ProductVariant::select(DB::raw('product_variants.id, product_variants.name, products.name as item_name'))
        ->leftJoin('products', 'products.id', '=', 'product_variants.product_id')
                    ->where("product_variants.production", 1)
                    ->where("product_variants.status", 1);
        
        if ($company_id != 0) {
            $data->where('products.company_id', $company_id);
        }
        $data = $data->get();

        if (!empty($request->variant_id)) {
            $data = $data->where('id',$request->variant_id)->first();
        }
        // $data = Ingredients::select(DB::raw('ingredients.item_variant_id as item_variant_id, product_variants.name as item_variant_name'))
        //                     ->leftJoin('product_variants', 'product_variants.id', '=', 'ingredients.item_variant_id')
        //                     ->groupBy(
        //                         'ingredients.item_variant_id',
        //                         'product_variants.name',)

        //                     ->get();
        //                     if (!empty($request->item_variant_id)) {
        //                     $data = $data->where('ingredients.item_variant_id',$request->item_variant_id)->first();
        //                     }
        return $data;
    }

    public function getStok(Request $request)
    {
        $data = Stock::select(DB::raw('stock.id, stock.item_variant_id, stock.warehouse_id, stock.stock, product_variants.name as variant_name, warehouses.name as warehouse_name'))
            ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'stock.item_variant_id')
            ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'stock.warehouse_id')
            ->where("stock.item_variant_id", $request->item_variant_id)
            ->get();

        return $data;
    }

    public function getIngredients(Request $request)
    {
        $company_id = getCompanyId();
        $data = IngredientDetail::select(
                DB::raw('ingredient_details.id, 
                products.name as item_name, 
                product_variants.name as item_variant_name, 
                ingredient_details.quantity, 
                ingredient_details.quantity_after_conversion, 
                ingredient_details.unit_id, 
                units.name as unit_name,
                ingredient_details.item_variant_id')
            )
            ->leftJoin('ingredients', 'ingredients.id', '=', 'ingredient_details.ingredient_id')
            ->leftJoin('product_variants', 'product_variants.id', '=', 'ingredient_details.item_variant_id')
            ->leftJoin('products', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('unit_conversions', 'unit_conversions.id', '=', 'ingredient_details.unit_id')
            ->leftJoin('units', 'units.id', '=', 'product_variants.unit_id')
            ->where('ingredients.item_variant_id', $request->id)
            ->groupBy(
                'ingredient_details.id',
                'products.name',
                'product_variants.name',
                'ingredient_details.quantity',
                'ingredient_details.quantity_after_conversion',
                'ingredient_details.unit_id',
                'units.name',
                'ingredient_details.item_variant_id'
            );

        if ($company_id != 0) {
            $data->where('ingredients.company_id', $company_id);
        }

        if ($request->ingredient_id) {
            $data->where('ingredient_id', $request->ingredient_id);
        }

        $data = $data->get();

        return $data;
    }

    public function getStock(Request $request){
        $data = Stock::where('warehouse_id', $request->warehouse_id)
                        ->where('item_variant_id', $request->variant_id)
                        ->first();

        if (!empty($data)) {
            return $data;
        } else {
            return response()->json([
                'stock' => 0,
            ]);
        }
        
    }

    
    public function getIngredient(Request $request)
    {
        $company_id = getCompanyId();
        $query = Ingredients::select(DB::raw('ingredients.id, ingredients.information'))
                            ->leftJoin('ingredient_details', 'ingredient_details.ingredient_id', '=', 'ingredients.id')
                            ->leftJoin('product_variants', 'product_variants.id', '=', 'ingredient_details.item_variant_id')
                            ->leftJoin('products', 'products.id', '=', 'product_variants.product_id')
                            ->leftJoin('units', 'units.id', '=', 'product_variants.unit_id')
                            ->where("ingredients.status", 1)
                            ->where("ingredients.item_variant_id", $request->variant_id)
                            ->groupBy(
                                'ingredients.id',
                                'ingredients.information'
                            );

        if ($company_id != 0) {
            $query->where('ingredients.company_id', $company_id);
        }

        $data = $query->get();

        if (!empty($request->id)) {
            $data = $data->where('id',$request->id)->first();
        }
            

        return $data;
    }

    // public function getItemData(Request $request)
    // {
    //     $data = Product::select(DB::raw('products.name as item_name, stock.sku as sku_variant, product_variants.name as item_variant_name, products.id as item_id, product_variants.id as item_variant_id, (SELECT stock.stock FROM stock WHERE stock.item_variant_id=product_variants.id AND stock.warehouse_id='.$request->warehouse_id.') as current_stock'))
    //                     ->leftJoin(DB::raw('product_variants'), 'product_variants.product_id', '=', 'products.id')
    //                     ->where("products.status", 1)
    //                     ->groupBy("product_variants.id")
    //                     ->get();

    //     return DataTables::of($data)->make(true);
    // }

    public function getGudangData(Request $request)
    {
        $company_id = getCompanyId();

        $query = Warehouse::select(DB::raw('warehouses.id, warehouses.code, warehouses.name, warehouses.pic'))
                    ->where("warehouses.status", 1);

        if ($company_id != 0) {
            $query->where('warehouses.company_id', $company_id);
        }

        $data = $query->get();

        if (!empty($request->gudang_id)) {
            $data = $data->where('id',$request->gudang_id)->first();
        }

        return $data;
    }

    public function getItemData(Request $request)
    {
        // $data = Product::select(DB::raw('products.name , products.id, brands.name, categories.name'))
        //                 ->leftJoin(DB::raw('brands'), 'products.brand_id', '=', 'brands.id')
        //                 ->leftJoin(DB::raw('categories'), 'products.category_id', '=', 'categories.id')
        //                 ->where("products.status", 1)
        //                 ->get();
        $company_id = getCompanyId();
        $query = Product::with('brands', 'categories')->where('status', 1)->get();

        if ($company_id != 0) {
            $query->where('products.company_id', $company_id);
        }

        $data = $query->get();

        return $data;
    }

    public function cekNomor(Request $request)
    {
        $data = Production::where('no_production', $request->no_produksi)->exists() ? true : false;
        return $data;
    }

    public function generateNomorProduksi(Request $request)
    {
        $nomor_produksi = $this->generateNomor();
        return $nomor_produksi;
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
            'gudang_id' => 'required',
            'warehouse_ingredient_id' => 'required',
            'item_variant_id' => 'required',
            'jumlah_produksi' => 'required',
            'nomor_produksi' => 'required',
            'ingredient_id' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $data = [
                'date'                  => date('Y-m-d', strtotime($request->date)),
                'warehouse_id'          => $request->gudang_id,
                'item_variant_id'       => $request->item_variant_id,
                'no_production'         => $request->nomor_produksi,
                'production_quantity'   => $request->jumlah_produksi,
                'information'           => $request->information,
                'ingredient_id'         => $request->ingredient_id,
                'company_id'            => $company_id
            ];
    
            $productions = Production::create($data);
            
            // update stock gudang
            $cek_stock = Stock::where("item_variant_id", $data['item_variant_id'])
                                ->where("warehouse_id", $data['warehouse_id'])
                                ->first();
    
    
            if ($cek_stock) {
                $new_stok = $cek_stock->stock + $data['production_quantity'];
                
                $stock_data = [
                    'stock'             => $new_stok,
                ];
        
                $stock_id = $cek_stock->id;
                Stock::where('id', $stock_id)->update($stock_data);
            } else {
                Stock::create([
                    'item_variant_id' => $data['item_variant_id'],
                    'warehouse_id' => $data['warehouse_id'],
                    'stock' => $data['production_quantity'],
                ]);
            }
            
    
            if ($request->has('ingredients')) {
                $production_data = $request->ingredients;
                
                foreach ($production_data as $production) {
                    // dd($production);
                    $productions->production_detail()->create([
                        'production_id'                 => $productions->id,
                        'warehouse_id'                  => $request->warehouse_ingredient_id,
                        'item_variant_id'               => $production['item_variant_id'],
                        'quantity'                      => str_replace(',', '', $production['quantity']),
                        'ingredient_detail_id'          => $production['ingredient_detail_id'],
                    ]);
    
                    // update stock gudang
                    $cek_stock = Stock::where("item_variant_id", $production['item_variant_id'])
                                ->where("warehouse_id", $request->warehouse_ingredient_id)
                                ->first();
    
                    $new_stok = $cek_stock->stock - str_replace(',', '', $production['quantity']);
    
                    $stock_data = [
                        'stock'             => $new_stok,
                    ];
    
                    $stock_id = $cek_stock->id;
                    Stock::where('id', $stock_id)->update($stock_data);
    
                }
            }
    
            //Write log
            createLog(static::$module, __FUNCTION__, $productions->id);
            DB::commit();
            return redirect(route('admin.produksi'));
        } catch (\Throwable $th) {
            DB::rollback();
            // Add a script to display an alert to the user
            dd($th->getMessage());
        }
        
    }

    public function edit($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $edit = Production::select(DB::raw('productions.id, productions.no_production, productions.production_quantity, warehouses.name as nama_warehouse, warehouses.id as id_warehouse, product_variants.name as nama_product_variant, product_variants.id as id_product_variant, productions.date, productions.information, productions.ingredient_id, ingredients.information as ingredient_information, 
        (
            SELECT
            MAX(warehouses.name)
            FROM
                production_details
            JOIN
                productions ON productions.id = production_details.production_id
            JOIN
                warehouses ON warehouses.id = production_details.warehouse_id
            WHERE
                production_details.production_id = productions.id
                AND production_details.deleted_at IS NULL
        ) as warehouse_ingredient_name
                                '))
                        ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'productions.warehouse_id')
                        ->leftJoin(DB::raw('ingredients'), 'ingredients.id', '=', 'productions.ingredient_id')
                        ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'productions.item_variant_id')
                        ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                        ->find($id);

        if (!$edit) {
            return abort(404);
        }


        $production_detail = ProductionDetail::select(DB::raw('production_details.id, products.name as nama_item, product_variants.name as nama_item_variant, product_variants.id as id_item_variant, production_details.quantity, units.name as unit_name'))
                        ->leftJoin(DB::raw('ingredient_details'), 'ingredient_details.id', '=', 'production_details.ingredient_detail_id')
                        ->leftJoin(DB::raw('ingredients'), 'ingredients.id', '=', 'ingredient_details.unit_id')
                        ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'production_details.item_variant_id')
                        ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
                        ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                        ->where("production_details.production_id", $id)
                        ->get();
                    

        return view("administrator.produksi.edit", compact("edit", "production_detail"));
    }

    public function update(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $this->validate($request, [
            'date' => 'required',
            'nomor_produksi' => 'required'
        ]);

        $data = [
            'date'                          => date('Y-m-d', strtotime($request->date)),
            'no_production'                 => $request->nomor_produksi,
            'information'                   => $request->information,
        ];

        $id = $request->id;
        $production = Production::where('id', $id)->update($data);

        //Write log
        createLog(static::$module, __FUNCTION__, $id);
        return redirect(route('admin.produksi'));
    }

    public function show($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $detail = Production::select(DB::raw('productions.id, productions.no_production, productions.production_quantity, warehouses.name as nama_warehouse, warehouses.id as id_warehouse, product_variants.name as nama_product_variant, product_variants.id as id_product_variant, productions.date, productions.information, productions.ingredient_id, ingredients.information as ingredient_information, 
        (
            SELECT
            MAX(warehouses.name)
            FROM
                production_details
            JOIN
                productions ON productions.id = production_details.production_id
            JOIN
                warehouses ON warehouses.id = production_details.warehouse_id
            WHERE
                production_details.production_id = productions.id
                AND production_details.deleted_at IS NULL
        ) as warehouse_ingredient_name
        '))
                        ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'productions.warehouse_id')
                        ->leftJoin(DB::raw('ingredients'), 'ingredients.id', '=', 'productions.ingredient_id')
                        ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'productions.item_variant_id')
                        ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                        ->find($id);

        if (!$detail) {
            return abort(404);
        }


        $production_detail = ProductionDetail::select(DB::raw('production_details.id, products.name as nama_item, product_variants.name as nama_item_variant, product_variants.id as id_item_variant, production_details.quantity, units.name as unit_name'))
                        ->leftJoin(DB::raw('ingredient_details'), 'ingredient_details.id', '=', 'production_details.ingredient_detail_id')
                        ->leftJoin(DB::raw('ingredients'), 'ingredients.id', '=', 'ingredient_details.unit_id')
                        ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'production_details.item_variant_id')
                        ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
                        ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                        ->where("production_details.production_id", $id)
                        ->get();

        return view("administrator.produksi.detail", compact("detail", "production_detail"));
    }


    public function destroy(Request $request)
    {
        // Validate input
        $request->validate([
            'ix' => 'required|integer', // Adjust the validation rule accordingly
        ]);

        try {
            // Use a database transaction
            DB::beginTransaction();

            // Check permission
            if (!isAllowed(static::$module, "delete")) {
                abort(403);
            }

            // Retrieve Production and associated production_detail for rollback
            $production = Production::with('production_detail')->find($request->ix);

            // Update stock for Production (reverse the subtraction)
            $status = $this->updateStock(true, $production->item_variant_id, $production->warehouse_id, $production->production_quantity);

            if ($status == false) {
                return response()->json([
                    'status' => 'error'
                ], 500);
            }
            $deletedBy = auth()->user() ? auth()->user()->id : '';

            // Update stock for production_detail (reverse the addition)
            foreach ($production->production_detail as $detail) {
                $this->updateStock(false, $detail->item_variant_id, $detail->warehouse_id, $detail->quantity);
                $detail->deleted_by = $deletedBy;
                $detail->update();
                $detail->delete();
            }

            // Delete Production and associated production_detail
                $production->deleted_by = $deletedBy;
                $production->update();
                $production->delete();

            // Commit the transaction
            DB::commit();

            // Write log
            createLog(static::$module, __FUNCTION__, $request->ix);

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an exception
            DB::rollBack();

            // Handle the exception (log, report, etc.)
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function updateStock($is_production, $itemVariantId, $warehouseId, $quantity)
    {
        // Update stock for a given item variant and warehouse
        $stock = Stock::where("item_variant_id", $itemVariantId)
            ->where("warehouse_id", $warehouseId)
            ->first();
        
        if ($is_production == true) {
            if ($stock->stock <= 0 || $stock->stock < $quantity) {
                return false;
            } else {
                $newStock = $stock->stock - $quantity;
                
                $stock->update([
                    'stock' => $newStock,
                ]);

                return true;
            }
        }else{
            $newStock = $stock->stock + $quantity;
    
            $stock->update([
                'stock' => $newStock,
            ]);
        }


    }

    public function getDataWarehouse(Request $request)
    {
        $company_id = getCompanyId();

        $query = Warehouse::select(DB::raw('warehouses.id, warehouses.code, warehouses.name, warehouses.pic'))
                    ->where("warehouses.status", 1);

        if ($company_id != 0) {
            $query->where('warehouses.company_id', $company_id);
        }

        $data = $query->get();

        if (!empty($request->id)) {
            $data = $data->where('id',$request->id)->first();
        }

        return $data;
    }

    public function getDataItem(Request $request)
    {
        $company_id = getCompanyId();
        $query = Product::select(DB::raw('products.name , products.id'))
                        ->where("products.status", 1);

        if ($company_id != 0) {
            $query->where('products.company_id', $company_id);
        }

        $data = $query->get();

        if (!empty($request->id)) {
            $data = $data->where('id',$request->id)->first();
        }

        return $data;
    }

    public function getDataVariant(Request $request)
    {
        $data = ProductVariant::select(DB::raw('product_variants.id, product_variants.name'))
                    ->where("product_variants.status", 1)
                    ->where("product_variants.product_id", $request->product_id)
                    ->get();

        if (!empty($request->id)) {
            $data = $data->where('id',$request->id)->first();
        }

        return $data;
    }

    public function export(Request $request){
        if (!isAllowed(static::$module, "export")) {
            abort(403);
        }
        // dd('s');
        $params = [];
        $whereClauses = [];
        $start_date="";
        $end_date="";
        $suppliers = "";
        $warehouses = "";
        $whereSearch = ''; 

        if($request->warehouse_id || $request->item_id || $request->variant_id || $request->search_datatable){
            if (!empty($request->warehouse_id)){
                $params[] = ["productions.warehouse_id", "=", $request->warehouse_id];
            }
            if (!empty($request->item_id)){
                $params[] = ["product.id", "=", $request->item_id];
            }
            if (!empty($request->variant_id)){
                $params[] = ["productions.item_variant_id", "=", $request->variant_id];
            }

            if (!empty($request->search_datatable)) {
                $whereClauses[] = [
                    'column' => 'productions.date',
                    'value' => '%' . strtolower($request->search_datatable) . '%'
                ];
                $whereClauses[] = [
                    'column' => 'warehouses.name',
                    'value' => '%' . strtolower($request->search_datatable) . '%'
                ];
                $whereClauses[] = [
                    'column' => 'products.name',
                    'value' => '%' . strtolower($request->search_datatable) . '%'
                ];
                $whereClauses[] = [
                    'column' => 'product_variants.name',
                    'value' => '%' . strtolower($request->search_datatable) . '%'
                ];
                $whereClauses[] = [
                    'column' => 'productions.no_production',
                    'value' => '%' . strtolower($request->search_datatable) . '%'
                ];
            }
        }
        $company_id = getCompanyId();
        $query = Production::select(DB::raw('warehouses.name as nama_warehouse, product_variants.name as nama_item_variant, products.name as nama_item, productions.id, productions.date, productions.production_quantity, productions.no_production'))
                            ->leftJoin('warehouses', 'warehouses.id', '=', 'productions.warehouse_id')
                            ->leftJoin('product_variants', 'product_variants.id', '=', 'productions.item_variant_id')
                            ->leftJoin('products', 'products.id', '=', 'product_variants.product_id')
                            ->orderBy('productions.created_at', 'DESC')
                            ->groupBy(
                                'warehouses.name',
                                'product_variants.name',
                                'products.name',
                                'productions.id',
                                'productions.date',
                                'productions.production_quantity',
                                'productions.no_production'
                            )
                            ->where($params);

                        if ($company_id != 0) {
                            $query->where('productions.company_id', $company_id);
                        }
                    
                        foreach ($whereClauses as $clause) {
                            $query->orWhere($clause['column'], 'LIKE', $clause['value']);
                        }

        $productions = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->getStyle('G')->getNumberFormat()
        ->setFormatCode('#,##0');

        $textCenter = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
        
        $textLeft = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ];

        $sheet->mergeCells('A1:G1')->getStyle('A1:G1')->getFont()->setBold(true)->setSize(16);
        $sheet->mergeCells('A1:G1')->getStyle('A1:G1')->applyFromArray($textCenter);
        $sheet->setCellValue('A1', 'Daftar Produksi');
        $sheet->setCellValue('A2', 'No')->getStyle('A2')->getFont()->setBold(true);
        $sheet->setCellValue('B2', 'Tanggal')->getStyle('B2')->getFont()->setBold(true);
        $sheet->setCellValue('C2', 'Nomor Produksi')->getStyle('C2')->getFont()->setBold(true);
        $sheet->setCellValue('D2', 'Gudang')->getStyle('D2')->getFont()->setBold(true);
        $sheet->setCellValue('E2', 'Item')->getStyle('E2')->getFont()->setBold(true);
        $sheet->setCellValue('F2', 'Item Variant')->getStyle('F2')->getFont()->setBold(true);
        $sheet->setCellValue('G2', 'Total Produksi')->getStyle('G2')->getFont()->setBold(true);
        

        $rows = 3;
        $no = 1;

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $textTopLeft = [
            'alignment' => array(
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP, 
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
			),
        ];

        $textCenter = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP, 
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $sheet->getStyle('A2:G'.(count($productions)+2))->applyFromArray($styleArray);
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(30);

        foreach ($productions as $data){
            $sheet->setCellValue('A' . $rows, $no)->getStyle('A')->getAlignment();
            $sheet->setCellValue('B' . $rows, date('d F Y', strtotime($data['date'])))->getStyle('B')->getAlignment();
            $sheet->setCellValue('C' . $rows, $data['no_production'])->getStyle('C')->getAlignment();
            $sheet->setCellValue('D' . $rows, $data['nama_warehouse'])->getStyle('D')->getAlignment();
            $sheet->setCellValue('E' . $rows, $data['nama_item'])->getStyle('E')->getAlignment();
            $sheet->setCellValue('F' . $rows, $data['nama_item_variant'])->getStyle('F')->getAlignment();
            $sheet->setCellValue('G' . $rows, $data['production_quantity'])->getStyle('G');
            $rows++;
            $no++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Daftar Produksi.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
    
    public function exportDetail(Request $request){
        if (!isAllowed(static::$module, "export")) {
            abort(403);
        }
        // dd('s');
        $suppliers = "";
        $warehouses = "";
        $whereSearch = '';

        $query = Production::select(DB::raw('warehouses.name as nama_warehouse, product_variants.name as nama_item_variant, products.name as nama_item, productions.id, productions.date, productions.production_quantity, productions.no_production, ingredients.information as information_ingredient, productions.information'))
                            ->leftJoin('warehouses', 'warehouses.id', '=', 'productions.warehouse_id')
                            ->leftJoin('product_variants', 'product_variants.id', '=', 'productions.item_variant_id')
                            ->leftJoin('products', 'products.id', '=', 'product_variants.product_id')
                            ->leftJoin('ingredients', 'ingredients.id', '=', 'productions.ingredient_id')
                            ->where('productions.id', $request->id)
                            ->groupBy('warehouses.name', 'product_variants.name', 'products.name', 'productions.id', 'productions.date', 'productions.production_quantity', 'productions.no_production', 'ingredients.information', 'productions.information');


        $production = $query->first();

        $production_details = ProductionDetail::select(DB::raw('production_details.id, products.name as nama_item, product_variants.name as nama_item_variant, product_variants.id as id_item_variant, production_details.quantity, units.name as unit_name'))
                        ->leftJoin(DB::raw('ingredient_details'), 'ingredient_details.id', '=', 'production_details.ingredient_detail_id')
                        ->leftJoin(DB::raw('ingredients'), 'ingredients.id', '=', 'ingredient_details.unit_id')
                        ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'production_details.item_variant_id')
                        ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
                        ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                        ->where("production_details.production_id", $production->id)
                        ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->getStyle('G')->getNumberFormat()
        ->setFormatCode('#,##0');

        $textCenter = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
        
        $textLeft = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ];

        $sheet->mergeCells('A1:F1')->getStyle('A1:F1')->getFont()->setBold(true)->setSize(16);
        $sheet->mergeCells('A1:F1')->getStyle('A1:F1')->applyFromArray($textCenter);
        $sheet->mergeCells('A2:F2')->getStyle('A2:F2')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A3:F3')->getStyle('A3:F3')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A4:F4')->getStyle('A4:F4')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A5:F5')->getStyle('A5:F5')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A6:F6')->getStyle('A6:F6')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A7:F7')->getStyle('A7:F7')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A8:F8')->getStyle('A8:F8')->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('A1', 'Detail Produksi');
        $sheet->setCellValue('A2', 'Tanggal : '.($production->date ? $production->date : '-'))->getStyle('A2')->applyFromArray($textLeft);
        $sheet->setCellValue('A3', 'Nomor Produksi : ' . ($production->no_production ? $production->no_production : '-'))->getStyle('A3')->applyFromArray($textLeft);
        $sheet->setCellValue('A4', 'Gudang : '. ($production->nama_warehouse ? $production->nama_warehouse : '-'))->getStyle('A4')->applyFromArray($textLeft);
        $sheet->setCellValue('A5', 'Item Variant : '. ($production->nama_item_variant ? $production->nama_item_variant : '-'))->getStyle('A4')->applyFromArray($textLeft);
        $sheet->setCellValue('A6', 'Ingredient : '. ($production->information_ingredient ? $production->information_ingredient : '-'))->getStyle('A4')->applyFromArray($textLeft);
        $sheet->setCellValue('A7', 'Informasi : '. ($production->information ? $production->information : '-'))->getStyle('A4')->applyFromArray($textLeft);
        $sheet->setCellValue('A8', 'Jumlah Produksi : '. ($production->production_quantity ? $production->production_quantity : '-'))->getStyle('A4')->applyFromArray($textLeft);
        $sheet->setCellValue('A10', 'No')->getStyle('A10')->getFont()->setBold(true);
        $sheet->setCellValue('B10', 'Item')->getStyle('B10')->getFont()->setBold(true);
        $sheet->setCellValue('C10', 'Item Variant')->getStyle('C10')->getFont()->setBold(true);
        $sheet->setCellValue('D10', 'Qty')->getStyle('D10')->getFont()->setBold(true);
        $sheet->setCellValue('E10', 'Unit')->getStyle('E10')->getFont()->setBold(true);
        

        $rows = 11;
        $no = 1;

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $textTopLeft = [
            'alignment' => array(
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP, 
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
			),
        ];

        $textCenter = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP, 
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $sheet->getStyle('A10:E'.(count($production_details)+10))->applyFromArray($styleArray);
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(30);

        foreach ($production_details as $data){
            $sheet->setCellValue('A' . $rows, $no)->getStyle('A')->getAlignment();
            $sheet->setCellValue('B' . $rows, $data['nama_item'])->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('C' . $rows, $data['nama_item_variant'])->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('D' . $rows, $data['quantity'])->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('E' . $rows, $data['unit_name'])->getStyle('E')->getAlignment();
            $rows++;
            $no++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Detail Produksi'.($production->no_production ? $production->no_production : '-').'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

}
