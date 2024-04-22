<?php

namespace App\Http\Controllers\Administrator;

use DB;
use PDF;
use File;
use Image;
use Redirect;
use DataTables;
use App\Http\Layout;
use App\Models\Buys;
use App\Models\Unit;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Karyawan;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\BuysDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\UnitConversion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class BuysController extends Controller
{
    private static $module = "buys";
    private $access_detail;
    private $access_edit;
    private $access_delete;
    use SoftDeletes;

    // view halaman index
    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        $company_id = getCompanyId();
        $query_supplier = Supplier::where('status',1);
        if ($company_id != 0) {
            $query_supplier->where('company_id', $company_id);
        }
        $supplier = $query_supplier->get();
        
        $query_warehouses = Warehouse::where('status',1);
        if ($company_id != 0) {
            $query_warehouses->where('company_id', $company_id);
        }
        $warehouses = $query_warehouses->get();

        return view("administrator.buys.index", compact('supplier','warehouses'));
    }

    public function getDataProduct(Request $request)
    {   
        $company_id = getCompanyId();
        $query = ProductVariant::select(DB::raw('products.name as item_name, product_variants.name as item_variant_name, product_variants.id'))
            ->leftJoin(DB::raw('products'), 'product_variants.product_id', '=', 'products.id')
            ->where("product_variants.status", 1)
            ->where("product_variants.bought", 1)
            ->where("products.status", 1);

        if ($company_id != 0) {
            $query->where('products.company_id', $company_id);
        }
        $data = $query->get();
        
        return DataTables::of($data)->make(true);
    }

    public function getData(Request $request)
    {   
        $company_id = getCompanyId();

        $query = Buys::select(DB::raw('buys.*, suppliers.name as supplier, warehouses.name as warehouse'))
                        ->leftJoin(DB::raw('buys_detail'), 'buys.id', '=', 'buys_detail.buys_id')
                        ->leftJoin(DB::raw('suppliers'), 'suppliers.id', '=', 'buys.supplier_id')
                        ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'buys.warehouse_id')
                        ->orderBy('buys.created_at', 'DESC')
                        ->groupBy('buys.id', 'suppliers.name', 'warehouses.name');
                        
        $start_date = '';
        if($request->tanggal) {
            $tanggal = explode("-", $request->tanggal);
            $start_date = date('Y-m-d', strtotime($tanggal[0]));
            $end_date = date('Y-m-d', strtotime($tanggal[1]));
            $query->whereBetween('buys.tanggal', [$start_date, $end_date]);
        }
        
        if ($company_id != 0) {
            $query->where('buys.company_id', $company_id);
        }

        if ($request->warehouses != "") {
            $query->where("buys.warehouse_id", $request->warehouses);
        }

        if ($request->suppliers != "") {
            $query->where("buys.supplier_id", $request->suppliers);
        }

        if (!empty(request('search')['value'])) {
            $search = strtolower(request()->search['value']);
            $query->where(function($dt) use ($search){
                // $dt->orWhere(function ($query) use ($search) {
                //     $query->orWhere(DB::raw("TO_CHAR(buys.tanggal, 'YYYY-MM-DD')"), "like", "%" . $search . "%");
                // });
                $dt->orWhere(DB::raw("LOWER(buys.nomor_pembelian)"), "like", "%".$search."%");
                $dt->orWhere(DB::raw("LOWER(suppliers.name)"), "like", "%".$search."%");
                $dt->orWhere(DB::raw("LOWER(warehouses.name)"), "like", "%".$search."%");
                $dt->orWhere(DB::raw("LOWER(buys.total_item)"), "like", "%".$search."%");
                $dt->orWhere(DB::raw("LOWER(buys.total_keseluruhan)"), "like", "%".$search."%");
            });
        }
        // echo $query->toSql();
        // print($query->getBindings());
        // die;
        $data = $query->get();

        $this->access_detail = isAllowed(static::$module, "detail");
        $this->access_edit = isAllowed(static::$module, "edit");
        $this->access_delete = isAllowed(static::$module, "delete");

        return DataTables::of($data)
            ->addColumn('nomor_pembelian', function ($row) {
                return $row->nomor_pembelian;
            })
            ->addColumn('action', function ($row) {
                $btn = "";
                if($this->access_detail)://Check permission
                $btn .= '<a href="' . route('admin.buys.detail', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                    <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/>
                            <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/>
                        </svg>
                    </span>
                </a>';
                endif;
                    if (isAllowed(static::$module, "edit"))
                        $btn .= '<a href="' . route('admin.buys.edit', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                        <span class="svg-icon svg-icon-3">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                     <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                     <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                 </svg>
                            </span>
                        </a>';
                    if (isAllowed(static::$module, "delete"))
                        $btn .= '<a href="#" data-ix="' . $row->id . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete">
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                    <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                    <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                </svg>
                            </span>
                        </a>';
                return $btn;
            })->rawColumns(['action','filter','nomor_pembelian'])->make(true);
    }

    function generateNomor() {
        $company_id = getCompanyId();
        $nomorUrut = Buys::select('id')->orderBy('id', 'desc')->where('company_id', $company_id)->withTrashed()->first();
        $nomorUrut = $nomorUrut ? $nomorUrut->id + 1 : 1;

        $bulan = date('n');
        $bulanRomawi = $this->konversiBulanKeRomawi($bulan);
        $tahun = date('Y');

        $kodeTertentu = $nomorUrut . '/BUY/' . $company_id . '/' . $bulanRomawi . '/' . $tahun;

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

    public function getUnit(Request $request)
    {
        $variant = ProductVariant::select(DB::raw('units.name, 0 as id'))
            ->where('product_variants.id', $request->id)
            ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id');

        $data = UnitConversion::select(DB::raw('unit_conversions.new_unit as name, unit_conversions.id'))
            ->leftJoin(DB::raw('units'), 'units.id', '=', 'unit_conversions.unit_id')
            ->where("unit_conversions.item_variant_id", $request->id);

        $result = $variant->union($data)->get();

        return $result;
    }

    // view halaman add
    public function create()
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }
        $company_id = getCompanyId();
        $query_supplier = Supplier::where('status',1);
        if ($company_id != 0) {
            $query_supplier->where('company_id', $company_id);
        }
        $supplier = $query_supplier->get();
        
        $query_warehouses = Warehouse::where('status',1);
        if ($company_id != 0) {
            $query_warehouses->where('company_id', $company_id);
        }
        $warehouses = $query_warehouses->get();
        
        $query_units = Unit::where('status',1);
        if ($company_id != 0) {
            $query_units->where('company_id', $company_id);
        }
        $units = $query_units->get();

        $nomor_pembelian = $this->generateNomor();
        
        return view("administrator.buys.add", compact('supplier', 'nomor_pembelian','warehouses','units'));
        
    }

    public function cekNomor(Request $request)
    {
        $data = Buys::where('nomor_pembelian', $request->nomor_pembelian)->exists() ? true : false;
        return $data;
    }

    public function generateNomorBuys(Request $request)
    {
        $nomor_pembelian = $this->generateNomor();
        return $nomor_pembelian;
    }

    // save data
    public function store(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $company_id = getCompanyId();

        $this->validate($request, [
            'tanggal' => 'required',
        ]);


        $data = [
            'tanggal'                       => date('Y-m-d', strtotime($request->tanggal)),
            'total_item'                    => $request->items,
            'supplier_id'                   => $request->supplier,
            'warehouse_id'                  => $request->gudang,
            'nomor_pembelian'               => $request->nomor_pembelian,
            'total_keseluruhan'             => str_replace([',', '.00'], '', $request->total_keseluruhan),
            'company_id'                    => $company_id
        ];
        
        $buys = Buys::create($data);
        

        if ($request->has('item')) {
            $buys_detail = $request->item;
            foreach ($buys_detail as $barang) {
                if ($barang['unit'] !== 0) {
                    $unit_conversion = UnitConversion::select(DB::raw('unit_conversions.quantity'))->find($barang['unit']);
                    $after = (str_replace([',', '.00'], '', $barang['jumlah'])) * (!empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1);
                }else{
                    $after = str_replace([',', '.00'], '', $barang['jumlah']);
                }

                $hargafloat = str_replace([',', '.00'], '', $barang['harga']);
            $data_detail = [
                'buys_id'  => $buys->id,
                'product_variant_id'            => $barang['product_variant_id'],
                'harga'                         => floatval($hargafloat),
                'jumlah'                        => str_replace([',', '.00'], '', $barang['jumlah']),
                'quantity_after_conversion'     => $after,
                'unit_id'                       => $barang['unit'],
                'total'                         => str_replace([',', '.00'], '', $barang['total']),
                'expired'                       => $barang['expired'] ? date('Y-m-d', strtotime($barang['expired'])) : null,
            ];
                BuysDetail::create($data_detail);

                $stock_warehouse = Stock::select(DB::raw('stock.*'))
                                -> where('item_variant_id',$barang['product_variant_id'])
                                -> where('warehouse_id',$request->gudang)
                                -> first();
                if ($stock_warehouse) {
                    $stock_warehouse->update([
                        'stock' => $stock_warehouse->stock + $data_detail['quantity_after_conversion'],
                    ]);
                } else {
                    $data_warehouse = [
                        'item_variant_id' => $barang['product_variant_id'],
                        'warehouse_id'    => $request->gudang,
                        'stock'           => $data_detail['quantity_after_conversion'],
                        'expired'         => $barang['expired'] ? date('Y-m-d', strtotime($barang['expired'])) : null,
                    ];
    
                    Stock::create($data_warehouse);
                }

            }
        }

        //Write log
        createLog(static::$module, __FUNCTION__, $buys->id);
        return redirect(route('admin.buys'));
    }

    // view halaman edit
    public function edit($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $edit = Buys::select(DB::raw('buys.*, suppliers.name as supplier'))
        ->leftJoin(DB::raw('suppliers'), 'suppliers.id', '=', 'buys.supplier_id')
        ->find($id);
        $detail = BuysDetail::select(DB::raw('buys_detail.*, units.name as unit_name, product_variants.name as item_variant_name, products.name as item_name'))
        ->leftJoin('product_variants', 'product_variants.id', '=', 'buys_detail.product_variant_id')
        ->leftJoin('products', 'products.id', '=', 'product_variants.product_id')
        ->leftJoin('units', 'units.id', '=', 'buys_detail.unit_id')
        ->where('buys_detail.buys_id', $id)
        ->get();
        $company_id = getCompanyId();
        $query_supplier = Supplier::where('status',1);
        if ($company_id != 0) {
            $query_supplier->where('company_id', $company_id);
        }
        $supplier = $query_supplier->get();
        
        $query_warehouses = Warehouse::where('status',1);
        if ($company_id != 0) {
            $query_warehouses->where('company_id', $company_id);
        }
        $warehouses = $query_warehouses->get();

        return view("administrator.buys.edit", compact('edit', 'detail', 'supplier','warehouses'));
    }

    // update data
    public function update(Request $request)
{
    // Check permission
    if (!isAllowed(static::$module, "edit")) {
        abort(403);
    }

    $this->validate($request, [
        'tanggal' => 'required',
    ]);

    $data = [
        'tanggal'           => date('Y-m-d', strtotime($request->tanggal)),
        'total_item'        => $request->items,
        'supplier_id'       => $request->supplier,
        'warehouse_id'      => $request->gudang,
        'nomor_pembelian'   => $request->nomor_pembelian,
        'total_keseluruhan' => str_replace([',', '.00'], '', $request->total_keseluruhan),
    ];

    $id = $request->id;
    $buys = Buys::where('id', $id)->update($data);

    if ($request->has('item')) {
        $buys_detail = $request->item;
        $buys_detail_id = collect($request->item)->pluck('id');
        $updatedBuysDetails = [];
        foreach ($buys_detail as $barang) {
            if ($barang['unit'] !== 0) {
                $unit_conversion = UnitConversion::select(DB::raw('unit_conversions.quantity'))->find($barang['unit']);
                $after = (str_replace([',', '.00'], '', $barang['jumlah'])) * (!empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1);
            }else{
                $after = str_replace([',', '.00'], '', $barang['jumlah']);
            }
            $detail_id = isset($barang['id']) ? $barang['id'] : null;

            $hargafloat = str_replace([',', '.00'], '', $barang['harga']);
            $data_detail = [
                'buys_id'                       => $id,
                'product_variant_id'            => $barang['product_variant_id'],
                'harga'                         => floatval($hargafloat),
                'jumlah'                        => str_replace([',', '.00'], '', $barang['jumlah']),
                'quantity_after_conversion'     => $after,
                'unit_id'                       => $barang['unit'],
                'total'                         => str_replace([',', '.00'], '', $barang['total']),
                'expired'                       => $barang['expired'] ? date('Y-m-d', strtotime($barang['expired'])) : null,
            ];

            
            if ($detail_id == null) {
                BuysDetail::create($data_detail);
                $stock_warehouse = Stock::select(DB::raw('stock.*'))
                ->where('item_variant_id', $barang['product_variant_id'])
                ->where('warehouse_id', $request->gudang)
                ->where('expired',date('Y-m-d', strtotime($barang['expired'])))
                ->first();
            
            if ($stock_warehouse) {
                $stock_warehouse->update([
                    'stock' => $stock_warehouse->stock + $data_detail['quantity_after_conversion'],
                ]);
            }
            if(!$stock_warehouse) {
                $data_warehouse = [
                    'item_variant_id' => $barang['product_variant_id'],
                    'warehouse_id'    => $request->gudang,
                    'stock'           => $data_detail['quantity_after_conversion'],
                    'expired'         => $barang['expired'] ? date('Y-m-d', strtotime($barang['expired'])) : null,
                ];

                Stock::create($data_warehouse);
            }
            } else {
                $previousData = BuysDetail::select(DB::raw('buys_detail.*, buys.warehouse_id as warehouse_id'))
                ->leftJoin(DB::raw('buys'), 'buys.id', '=', 'buys_detail.buys_id')
                ->where('buys_detail.id', $detail_id)->get()->first();
                
            
                BuysDetail::where(["id" => $detail_id])->update($data_detail);
            
                $updatedDetailInstance = BuysDetail::select(DB::raw('buys_detail.*, buys.warehouse_id as warehouse_id'))
                ->leftJoin(DB::raw('buys'), 'buys.id', '=', 'buys_detail.buys_id')->find($detail_id);
                $updatedData = $updatedDetailInstance ? $updatedDetailInstance->toArray() : [];
                
            
                $hasChanges = false;
            
                if ($previousData) {
                    foreach ($previousData as $key => $value) {
                        if (!array_key_exists($key, $updatedData) || $value != $updatedData[$key]) {
                            $hasChanges = true;
                            break;
                        }
                    }
                }
                
                if ($hasChanges) {
                    $updatedBuysDetails[] = [
                        'previousData' => $previousData ? $previousData->toArray() : [],
                        'updatedData' => $updatedData,
                    ];
                }
            }
            $deletedBy = auth()->user() ? auth()->user()->id : '';
            $deleted_buys_detail = BuysDetail::whereNotIn('id', $buys_detail_id)
                ->where('buys_id', $id)
                ->get();

            if ($deleted_buys_detail->isNotEmpty()) {
                foreach ($deleted_buys_detail as $buysDetail) {
                    $buys = Buys::find($buysDetail->buys_id);

                    $stockWarehouse = Stock::where('item_variant_id', $buysDetail->product_variant_id)
                        ->where('warehouse_id', $buys->warehouse_id)
                        ->first();
                    

                    if ($stockWarehouse && $stockWarehouse->stock > $buysDetail->quantity_after_conversion) {
                        $stockWarehouse->update([
                            'stock' => $stockWarehouse->stock - $buysDetail->quantity_after_conversion,
                        ]);
                    } elseif ($stockWarehouse && $stockWarehouse->stock == $buysDetail->quantity_after_conversion) {
                        $stockWarehouse->deleted_by = $deletedBy;
                        $stockWarehouse->update();
                        $stockWarehouse->delete();
                    } elseif ($stockWarehouse && $stockWarehouse->stock < $buysDetail->quantity_after_conversion) {
                        return back()->with('alert_error', 'Stock less than purchase');
                    }
                }
                $deletedBy = auth()->user() ? auth()->user()->id : '';
                $DelBuysDetail = BuysDetail::whereNotIn('id', $buys_detail_id)->where('buys_id', $id)->get();
                foreach ($DelBuysDetail as $detail) {
                    $detail->deleted_by = $deletedBy;
                    $detail->update();
                    $detail->delete();
                }
            }

            
        }

       $jumlahData = [];

       
       foreach ($updatedBuysDetails as $up_detail) {
           $sebelum = $up_detail['previousData']['jumlah'];
           $sesudah = $up_detail['updatedData']['jumlah'];
           $product_variant_id = $up_detail['updatedData']['product_variant_id'];
           $expired = $up_detail['updatedData']['expired'];
           $warehouse_id = $up_detail['updatedData']['warehouse_id'];
           $id = $up_detail['updatedData']['id'];
       
           $jumlahData[$id] = [
               'sebelum' => $sebelum,
               'sesudah' => $sesudah,
               'product_variant_id' => $product_variant_id,
               'warehouse_id' => $warehouse_id,
               'expired' => $expired,
           ];
       }

       $hasExpired = array_reduce($jumlahData, function ($carry, $item) {
        return $carry || !is_null($item['expired']);
        }, false);
        
        if ($hasExpired) {
            $stock_warehouse_edits = Stock::whereIn('item_variant_id', array_column($jumlahData, 'product_variant_id'))
                ->whereIn('warehouse_id', array_column($jumlahData, 'warehouse_id'))
                ->whereIn('expired', array_column($jumlahData, 'expired'))
                ->get();
        } else {
            $stock_warehouse_edits = Stock::whereIn('item_variant_id', array_column($jumlahData, 'product_variant_id'))
                ->whereIn('warehouse_id', array_column($jumlahData, 'warehouse_id'))
                ->whereNull('expired')
                ->get();
        }

        // dd(array_column($jumlahData, 'expired'));


       foreach ($stock_warehouse_edits as $stock_warehouse_edit) {
           $product_variant_id = $stock_warehouse_edit->item_variant_id;
           $warehouse_id = $stock_warehouse_edit->warehouse_id;
           $expired = $stock_warehouse_edit->expired;
       
           $matchingData = collect($jumlahData)->first(function ($data) use ($product_variant_id, $warehouse_id, $expired) {
               return $data['product_variant_id'] == $product_variant_id && $data['warehouse_id'] == $warehouse_id && $data['expired'] == $expired;
           });
       
           if ($matchingData) {
               $sebelum = $matchingData['sebelum'];
               $sesudah = $matchingData['sesudah'];
       
               if (($sebelum - $sesudah) > $stock_warehouse_edit->stock) {
                return back()->with('alert_error', 'Stock less than purchase');
            }

               if ($sebelum > $sesudah) {
                   $stock_warehouse_edit->update([
                       'stock' => max(0,$stock_warehouse_edit->stock - ($sebelum - $sesudah)),
                   ]);
               } elseif ($sebelum < $sesudah) {
                   $stock_warehouse_edit->update([
                       'stock' => $stock_warehouse_edit->stock + ($sesudah - $sebelum),
                   ]);
               } 
           }
       }
       

    }


    createLog(static::$module, __FUNCTION__, $id);
        return redirect(route('admin.buys'));
}

 

    public function show($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }
       
        $detail = Buys::select(DB::raw('buys.*, suppliers.name as supplier, warehouses.name as warehouse '))
        ->leftJoin(DB::raw('suppliers'), 'suppliers.id', '=', 'buys.supplier_id')
        ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'buys.warehouse_id')
        ->find($id);
        
        $items = BuysDetail::select(DB::raw('buys_detail.*, units.name as unit, product_variants.name as item_variant_name, products.name as item_name'))
        ->leftJoin(DB::raw('units'), 'units.id', '=', 'buys_detail.unit_id')
        ->leftJoin('product_variants', 'product_variants.id', '=', 'buys_detail.product_variant_id')
        ->leftJoin('products', 'products.id', '=', 'product_variants.product_id')
        ->where('buys_detail.buys_id', $id)
        ->get();

        if (!$detail) {
            return abort(404);
        }
        return view("administrator.buys.detail", compact("detail","items"));
    }

    public function destroy(Request $request)
{
    //Check permission
    if (!isAllowed(static::$module, "delete")) {
        abort(403);
    }
    $deletedBy = auth()->user() ? auth()->user()->id : '';
    $buysIds = is_array($request->ix) ? $request->ix : [$request->ix];

    try {
        // Start a database transaction
        DB::beginTransaction();

        foreach ($buysIds as $buysId) {
            $buys = Buys::with('buysDetail')->find($buysId);

            foreach ($buys->buysDetail as $buysDetail) {
                $stockWarehouse = Stock::where('item_variant_id', $buysDetail->product_variant_id)
                    ->where('warehouse_id', $buys->warehouse_id)
                    ->where('expired', $buysDetail->expired)
                    ->first();

                if ($stockWarehouse && $stockWarehouse->stock > $buysDetail->jumlah) {
                    $stockWarehouse->update([
                        'stock' => $stockWarehouse->stock - $buysDetail->jumlah,
                    ]);
                } elseif ($stockWarehouse && $stockWarehouse->stock == $buysDetail->jumlah) {
                    $stockWarehouse->deleted_by = $deletedBy;
                    $stockWarehouse->update();
                    $stockWarehouse->delete();
                } elseif ($stockWarehouse && $stockWarehouse->stock < $buysDetail->jumlah) {
                    DB::rollback();
                    return response()->json([
                        'error'   => true,
                    ], 500);
                }

                $buysDetail->deleted_by = $deletedBy;
                $buysDetail->update();
                $buysDetail->delete();
            }

            $buys->deleted_by = $deletedBy;
            $buys->update();
            $buys->delete();
        }

        DB::commit();

        // Write log
        createLog(static::$module, __FUNCTION__, $request->ix);
        return response()->json([
            'success' => true
        ]);
    } catch (\Exception $e) {
        DB::rollback();

        return response()->json([
            'error'   => true,
            'message' => $e->getMessage(),
        ], 500);
    }
}


    public function exportDetailExcel(Request $request,$id){
        // Check permission
        if (!isAllowed(static::$module, "export")) {
            abort(403);
        }

        $detail = Buys::select(DB::raw('buys.*, suppliers.name as supplier, warehouses.name as warehouse '))
                                ->leftJoin(DB::raw('suppliers'), 'suppliers.id', '=', 'buys.supplier_id')
                                ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'buys.warehouse_id')
                                ->find($request->id);
        $detail_item = BuysDetail::select(DB::raw('buys_detail.*, units.name as unit_name, product_variants.name as item_variant_name, products.name as item_name'))
                                ->leftJoin('product_variants', 'product_variants.id', '=', 'buys_detail.product_variant_id')
                                ->leftJoin('products', 'products.id', '=', 'product_variants.product_id')
                                ->leftJoin('units', 'units.id', '=', 'buys_detail.unit_id')
                                ->where('buys_detail.buys_id', $request->id)
                                ->get();

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ]
        ];


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('0.00%');

        $textCenter = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];

        $textRight = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
        ];


        $sheet->mergeCells('A1:G1')->getStyle('A1:G1')->getFont()->setBold(true)->setSize(16);
        $sheet->mergeCells('A1:G1')->getStyle('A1:G1')->applyFromArray($textCenter);
        $sheet->setCellValue('A1', 'List Of Purchase Detail');
        $sheet->setCellValue('A2', 'Purchase Number : ')->getStyle('A2')->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('A3', 'Date : ')->getStyle('A3')->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('A4', 'Wrehouse : ')->getStyle('A4')->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('A5', 'Supplier : ')->getStyle('A5')->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('B2', $detail->nomor_pembelian)->getStyle('B2')->getFont()->setSize(12);
        $sheet->setCellValue('B3', date('d F Y', strtotime($detail->tanggal)))->getStyle('B3')->getFont()->setSize(12);
        $sheet->setCellValue('B4', $detail->warehouse)->getStyle('B4')->getFont()->setSize(12);
        $sheet->setCellValue('B5', $detail->supplier)->getStyle('B5')->getFont()->setSize(12);
        $no = 1;
        $row_tujuan = 4;

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getRowDimension('1')->setRowHeight(30);
        $rows = $row_tujuan+5;

        $sheet->setCellValue('A'. ($row_tujuan+3), 'Purchase Detail : ')->getStyle('A'. ($row_tujuan+3))->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('A'. ($row_tujuan+4), 'Product')->getStyle('A'. ($row_tujuan+4))->applyFromArray($textCenter)->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('B'. ($row_tujuan+4), 'Variant')->getStyle('B'. ($row_tujuan+4))->applyFromArray($textCenter)->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('C'. ($row_tujuan+4), 'Item Price')->getStyle('C'. ($row_tujuan+4))->applyFromArray($textCenter)->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('D'. ($row_tujuan+4), 'Quantity')->getStyle('D'. ($row_tujuan+4))->applyFromArray($textCenter)->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('E'. ($row_tujuan+4), 'Unit')->getStyle('E'. ($row_tujuan+4))->applyFromArray($textCenter)->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('F'. ($row_tujuan+4), 'Price')->getStyle('F'. ($row_tujuan+4))->applyFromArray($textCenter)->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('G'. ($row_tujuan+4), 'Expired')->getStyle('G'. ($row_tujuan+4))->applyFromArray($textCenter)->getFont()->setBold(true)->setSize(12);

         
        foreach ($detail_item as $data){
            $sheet->setCellValue('A'. $rows, $data['item_name'])->getStyle('A'. $rows);
            $sheet->setCellValue('B'. $rows, $data['item_variant_name'])->getStyle('B'. $rows);
            $sheet->setCellValue('C'. $rows, $data['harga'])->getStyle('C'. $rows)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('D'. $rows, $data['jumlah'])->getStyle('D'. $rows)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('E'. $rows, $data['unit_name'])->getStyle('E'. $rows);
            $sheet->setCellValue('F'. $rows, $data['total'])->getStyle('F'. $rows)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('G'. $rows, $data['expired'])->getStyle('G'. $rows);
            $rows++;
        }

        $sheet->setCellValue('A'. $rows, 'Total Price')->getStyle('A'. $rows)->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A'.$rows.':F'.$rows)->getStyle('A'.$rows.':F'.$rows)->applyFromArray($textCenter);
        $sheet->setCellValue('G'. $rows, $detail->total_keseluruhan)->getStyle('G'. $rows)->getNumberFormat()->setFormatCode('#,##0');

        $sheet->getStyle('A'.($row_tujuan+4).':G'.$rows)->applyFromArray($styleArray);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="List Of Purchase Detail ' . $detail->nomor_pembelian . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function exportExcel(Request $request){
        if (!isAllowed(static::$module, "export")) {
            abort(403);
        }
        
        $params = [];
        $whereClauses = [];
        $start_date="";
        $end_date="";
        $suppliers = "";
        $warehouses = "";
        $whereSearch = ''; 

        if($request->search != null){
            $search = explode("|", $request->search);
            foreach ($search as $value){
                $nilai = explode(":", $value);
                
                if ($nilai[0] == "tanggal" && $nilai[1] != '') {
                    $tanggal = explode("-", $nilai[1]);
                    $start_date = date('Y-m-d', strtotime($tanggal[0]));
                    $end_date = date('Y-m-d', strtotime($tanggal[1]));
                    $params[] = [DB::raw("TO_CHAR(buys.tanggal, 'YYYY-MM-DD')"), ">=", $start_date];
                    $params[] = [DB::raw("TO_CHAR(buys.tanggal, 'YYYY-MM-DD')"), "<=", $end_date];
                }
                
                if($nilai[0] == "warehouse" && $nilai[1]!=''){
                        $params[] = ["buys.warehouse_id", "=", $nilai[1]];
                        $warehouses = ($nilai[1]);
                }

                if ($nilai[0] == "supplier" && $nilai[1] != '') {
                    $params[] = ["buys.supplier_id", "=", $nilai[1]];
                    $suppliers = $nilai[1];
                }

                if ($nilai[0] == "txt" && $nilai[1] != "") {
                    $whereClauses[] = [
                        'column' => 'buys.nomor_pembelian',
                        'operator' => 'LIKE',
                        'value' => '%' . strtolower($nilai[1]) . '%'
                    ];
                    $whereClauses[] = [
                        'column' => 'suppliers.name',
                        'operator' => 'LIKE',
                        'value' => '%' . strtolower($nilai[1]) . '%'
                    ];
                    $whereClauses[] = [
                        'column' => 'warehouses.name',
                        'operator' => 'LIKE',
                        'value' => '%' . strtolower($nilai[1]) . '%'
                    ];
                    $whereClauses[] = [
                        'column' => 'buys.total_item',
                        'operator' => 'LIKE',
                        'value' => '%' . strtolower($nilai[1]) . '%'
                    ];
                    $whereClauses[] = [
                        'column' => 'buys.total_keseluruhan',
                        'operator' => 'LIKE',
                        'value' => '%' . strtolower($nilai[1]) . '%'
                    ];
                
                    $whereSearch = strtolower($nilai[1]);
                }
            }
        }
        $company_id = getCompanyId();
        $query = Buys::select(DB::raw('buys.*, suppliers.name as supplier, warehouses.name as warehouse'))
                        ->leftJoin('buys_detail', 'buys.id', '=', 'buys_detail.buys_id')
                        ->leftJoin('suppliers', 'suppliers.id', '=', 'buys.supplier_id')
                        ->leftJoin('warehouses', 'warehouses.id', '=', 'buys.warehouse_id')
                        ->groupBy('buys.id', 'suppliers.name', 'warehouses.name')
                        ->where($params);
                        if ($company_id != 0) {
                            $query->where('buys.company_id', $company_id);
                        }

                        foreach ($whereClauses as $clause) {
                            $query->orWhere($clause['column'], $clause['operator'], $clause['value']);
                        }
        $buys = $query->get();
        // dd($start_date.'/'.$end_date);

        if(empty($whereSearch)){
            $whereSearch = '';
        }
        $warehouse = null;
        $supplier = null;

        if ($warehouses) {
            $warehouse = Buys::select(DB::raw('buys.*, warehouses.name as warehouse_name'))
                ->leftJoin('warehouses', 'warehouses.id', '=', 'buys.warehouse_id')
                ->where('warehouses.id', $warehouses)
                ->first();
        }

        if ($suppliers) {
            $supplier = Buys::select(DB::raw('buys.*, suppliers.name as supplier_name'))
                ->leftJoin('suppliers', 'suppliers.id', '=', 'buys.supplier_id')
                ->where('suppliers.id', $suppliers)
                ->first();
        }


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
        $sheet->mergeCells('A2:G2')->getStyle('A2:G2')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A3:G3')->getStyle('A3:G3')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A4:G4')->getStyle('A4:G4')->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('A1', 'List Of Purchase');
        $sheet->setCellValue('A2', 'Period : '.($start_date ? $start_date.'/'.$end_date : '-'))->getStyle('A2')->applyFromArray($textLeft);
        $sheet->setCellValue('A3', 'Warehouse : ' . ($warehouse ? $warehouse->warehouse_name : '-'))->getStyle('A3')->applyFromArray($textLeft);
        $sheet->setCellValue('A4', 'Supplier : '. ($supplier ? $supplier->supplier_name : '-'))->getStyle('A4')->applyFromArray($textLeft);
        $sheet->setCellValue('A5', 'No')->getStyle('A5')->getFont()->setBold(true);
        $sheet->setCellValue('B5', 'Date')->getStyle('B5')->getFont()->setBold(true);
        $sheet->setCellValue('C5', 'Purchase Number')->getStyle('C5')->getFont()->setBold(true);
        $sheet->setCellValue('D5', 'Supplier')->getStyle('D5')->getFont()->setBold(true);
        $sheet->setCellValue('E5', 'Warehouse')->getStyle('E5')->getFont()->setBold(true);
        $sheet->setCellValue('F5', 'Qty')->getStyle('F5')->getFont()->setBold(true);
        $sheet->setCellValue('G5', 'Total Price')->getStyle('G5')->getFont()->setBold(true);
        $sheet->setCellValue('G5', 'Total Price')->getStyle('G5')->applyFromArray($textCenter);
        

        $rows = 6;
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

        $sheet->getStyle('A5:G'.(count($buys)+5))->applyFromArray($styleArray);
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(30);

        foreach ($buys as $data){
            $sheet->setCellValue('A' . $rows, $no)->getStyle('A')->getAlignment();
            $sheet->setCellValue('B' . $rows, date('d F Y', strtotime($data['tanggal'])))->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('C' . $rows, $data['nomor_pembelian'])->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('D' . $rows, $data['supplier'])->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('E' . $rows, $data['warehouse'])->getStyle('E')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('F' . $rows, $data['total_item'])->getStyle('F')->getAlignment();
            $sheet->setCellValue('G' . $rows, $data['total_keseluruhan'])->getStyle('G');
            $rows++;
            $no++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="List Of Purchase ' . $start_date.'/'.$end_date . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function exportPdf(Request $request){
        // Check permission
        if (!isAllowed(static::$module, "export")) {
            abort(403);
        }

        $id = $request->id;

        $detail = Buys::select(DB::raw('buys.*, suppliers.name as supplier, warehouses.name as warehouse '))
        ->leftJoin(DB::raw('suppliers'), 'suppliers.id', '=', 'buys.supplier_id')
        ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'buys.warehouse_id')
        ->find($id);

        $detail_item = BuysDetail::select(DB::raw('buys_detail.*, units.name as unit_name, product_variants.name as item_variant_name, products.name as item_name'))
        ->leftJoin('product_variants', 'product_variants.id', '=', 'buys_detail.product_variant_id')
        ->leftJoin('products', 'products.id', '=', 'product_variants.product_id')
        ->leftJoin('units', 'units.id', '=', 'buys_detail.unit_id')
        ->where('buys_detail.buys_id', $id)
        ->get();

        if (!$detail) {
            return abort(404);
        }

        $navbar = Layout::getLayout();
        if ($navbar['settings']['logo'] != "") {
            $logoPath = 'administrator/assets/media/settings/' . $navbar['settings']['logo'];
        } else {
            $logoPath = "";
        }

        $pdf = PDF::loadView("administrator.buys.export_detail_pdf", compact('detail', 'detail_item', 'logoPath'));
        return $pdf->stream('Detail Pembelian - ' . $detail->nomor_pembelian . '.pdf');
    }

}
