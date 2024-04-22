<?php

namespace App\Http\Controllers\Administrator;

use DB;
use PDF;
use DataTables;
use App\Http\Layout;
use App\Models\Sales;
use App\Models\Stock;
use App\Models\SalesDetail;
use App\Models\DeliveryNote;
use App\Models\InvoiceSales;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\UnitConversion;
use App\Models\DeliveryNoteDetail;
use App\Models\InvoiceSalesDetail;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class DeliveryNoteController extends Controller
{
    private static $module = "delivery_note";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view("administrator.delivery_note.index");
    }

    public function getData(Request $request)
    {   
        $company_id = getCompanyId();

        $query = DeliveryNote::select(DB::raw('delivery_note.*, sales.sales_number'))
            ->leftJoin(DB::raw('delivery_note_detail'), 'delivery_note.id', '=', 'delivery_note_detail.delivery_note_id')
            ->leftJoin(DB::raw('sales'), 'sales.id', '=', 'delivery_note.sales_id')
            ->orderBy('delivery_note.created_at', 'DESC')
            ->groupBy('delivery_note.id', 'sales.sales_number', 'sales.date');

        if ($company_id != 0) {
            $query->where('delivery_note.company_id', $company_id);
        }

        if ($request->date || $request->sales_number) {
            $query = $query->where(function ($data_search) use ($request) {
                if ($request->date != "") {
                    $start_date = '';
                    $tanggal = explode("-", $request->date);
                    $start_date = date('Y-m-d', strtotime($tanggal[0]));
                    $end_date = date('Y-m-d', strtotime($tanggal[1]));
                    // Reference the sales_date column from the sales table
                    $data_search = $data_search->whereBetween('delivery_note.date', [$start_date, $end_date]);
                }
                if ($request->sales_number != "") {
                    // Reference the sales_id column from the sales table
                    $data_search->where("delivery_note.sales_number", $request->sales_number);
                }
            });
        }

        // Continue with the rest of your code...

        
          
        $data = $query->get();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn = "";
                if(isAllowed(static::$module, "detail"))://Check permission
                    $btn .= '<a href="' . route('admin.delivery_note.detail', $row->id). '?sales_number=' . $row->sales_number. '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                    <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/>
                            <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/>
                        </svg>
                        </span>
                </a>';
                endif;
                if(isAllowed(static::$module, "edit"))://Check permission
                    $btn .= '<a href="' . route('admin.delivery_note.edit', $row->id). '?sales_number=' . $row->sales_number. '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
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
            })->rawColumns(['action'])
            ->make(true);
    }
    
    public function sales()
    {
        //Check permission
        if (!isAllowed(static::$module, "sales")) {
            abort(403);
        }
        
        return view("administrator.delivery_note.sales.index");
    }

    public function sales_detail($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "sales")) {
            abort(403);
        }

        $data = Sales::select(DB::raw('sales.*, customers.id as customer_id, customers.name as customer_name'))
                    ->leftJoin(DB::raw('customers'), 'customers.id', '=', 'sales.customer_id')
                    ->groupBy('sales.id', 'customers.id')
                    ->find($id);

        $data_detail = SalesDetail::select(DB::raw('sales_detail.*, product_variants.name as nama_item_variant, product_variants.price, products.name as nama_item, units.name as nama_unit, MIN(product_medias.data_file) as data_file'))
        ->leftJoin('sales', 'sales.id', '=', 'sales_detail.sales_id')
        ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'sales_detail.item_variant_id')
        ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
        ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
        ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
        ->where('sales_detail.sales_id', $id)
        ->groupBy(
            'sales_detail.id',
            'product_variants.name',
            'product_variants.price',
            'products.name',
            'units.name'
            // Add other columns you've selected in the query
        )
        ->get();

        if (!$data) {
            return abort(404);
        }

        return view("administrator.delivery_note.sales.detail", compact('data', 'data_detail'));
    }

    public function getDataSales(Request $request)
    {
        $company_id = getCompanyId();
        $query = Sales::select(DB::raw('sales.*, customers.name as customer_name'))
        ->leftJoin(DB::raw('sales_detail'), 'sales.id', '=', 'sales_detail.sales_id')
                        ->leftJoin(DB::raw('customers'), 'customers.id', '=', 'sales.customer_id')
                        ->orderBy('sales.created_at', 'DESC')
                        ->groupBy('sales.id', 'customers.name');

        if ($request->date || $request->customer_id) {
            $query = $query->where(function ($data_search) use ($request) {
                if($request->date != "") {
                    $start_date = '';
                    $tanggal = explode("-", $request->date);
                    $start_date = date('Y-m-d', strtotime($tanggal[0]));
                    $end_date = date('Y-m-d', strtotime($tanggal[1]));
                    $data_search = $data_search->whereBetween('sales.date', [$start_date, $end_date]);
                }
                if ($request->customer_id != "") {
                    $data_search->where("sales.customer_id", $request->customer_id);
                }
            });
        }
        if ($company_id != 0) {
            $query->where('sales.company_id', $company_id);
        }
        
          
        $data = $query->get();

        
        return DataTables::of($data)
        ->addColumn('action', function ($row) {
            $cek = $this->isQuantityFulfilled($row->id);
            $btn = "";
            if(isAllowed(static::$module, "detail"))://Check permission
                    $btn .= '<a href="' . route('admin.delivery_note.sales.detail', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                    <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/>
                            <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/>
                        </svg>
                        </span>
                </a>';
                endif;
                if ($cek == false) {
                    if(isAllowed(static::$module, "add"))://Check permission
                        $btn .= '<a href="' . route('admin.delivery_note.add', ('sales_number='.$row->sales_number)) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                        <span class="svg-icon svg-icon-3"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo8/dist/../src/media/svg/icons/Communication/Clipboard-check.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"/>
                                <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000"/>
                                <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
                            </g>
                        </svg><!--end::Svg Icon--></span>
                    </a>';
                    endif;
                }
                return $btn;
            })->rawColumns(['action'])
            ->make(true);
    }

    public function getSales(Request $request)
    {
        $query = Sales::select(DB::raw('sales.*, customers.name as customer_name'))
            ->leftJoin(DB::raw('sales_detail'), 'sales.id', '=', 'sales_detail.sales_id')
            ->leftJoin(DB::raw('customers'), 'customers.id', '=', 'sales.customer_id')
            ->orderBy('sales.created_at', 'DESC')
            ->groupBy('sales.id', 'customers.name');

        $company_id = getCompanyId();
        if ($company_id != 0) {
            $query->where('sales.company_id', $company_id);
        }
        $data = $query->get();

        if (!empty($request->id)) {
            $data = $data->where('sales_id', $request->id)->first();
        }

        return $data;
    }

    public function getUnit(Request $request)
    {
        $variant = ProductVariant::select(DB::raw('units.name, 0 as id, 1 as quantity_after_conversion'))
            ->where('product_variants.id', $request->id)
            ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id');

        $data = UnitConversion::select(DB::raw('unit_conversions.new_unit as name, unit_conversions.id, unit_conversions.quantity as quantity_after_conversion'))
            ->leftJoin(DB::raw('units'), 'units.id', '=', 'unit_conversions.unit_id')
            ->where("unit_conversions.item_variant_id", $request->id);

        $result = $variant->union($data)->get();

        return $result;
    }


    public function add(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        if (!$request || empty($request->sales_number)) {
            abort(404);
        }
        
        return view("administrator.delivery_note.add");
        
    }

    function data_sales($sales_number){
        $data = Sales::where('sales_number',$sales_number)->first();

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
            'date' => 'required',
            'delivery_note_number' => 'required',
            'detail' => 'required',
            'license_plate_number' => 'required',
            'sales_number' => 'required',
        ]);

        $sales = $this->data_sales($request->sales_number);
        
        try {
            $delivery_note = DeliveryNote::create([
                'sales_id'                          => $sales->id,
                'date'                              => date('Y-m-d', strtotime($request->date)),
                'delivery_note_number'              => $request->delivery_note_number,
                'license_plate_number'              => $request->license_plate_number,
                'information'                       => $request->information,
                'weather'                           => $request->weather,
                'company_id'                        => $company_id
            ]);
    
            if ($request->has('detail')) {
                $delivery_note_detail = $request->detail;
                foreach ($delivery_note_detail as $detail) {
                    if ($detail['unit_id'] !== 0) {
                        $unit_conversion = UnitConversion::select(DB::raw('unit_conversions.quantity'))->find($detail['unit_id']);
                        $after = (str_replace([','], '', $detail['quantity'])) * (!empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1);
                    }else{
                        $after = str_replace([','], '', $detail['quantity']);
                    }
                    DeliveryNoteDetail::create([
                        'delivery_note_id'                  => $delivery_note->id,
                        'item_variant_id'                   => $detail['item_variant_id'],
                        'warehouses_id'                      => $detail['warehouse_id'],
                        'stock_id'                          => $detail['stock_id'],
                        'quantity'                          => $detail['quantity'],
                        'unit_id'                          => $detail['unit_id'],
                        'quantity_after_conversion'        => $after,
                    ]);
    
                    $data_stock = Stock::where('item_variant_id', $detail['item_variant_id'])->where('warehouse_id', $detail['warehouse_id'])->first();
                    $data_stock->stock = $data_stock->stock - $after;
                    $data_stock->update();
                }
            }
    
            //Write log
            createLog(static::$module, __FUNCTION__, $delivery_note->id);
            return redirect(route('admin.delivery_note'));
        } catch (\Throwable $th) {
            return redirect(route('admin.delivery_note'))->with('error', 'Ada kesalahan');
        }
    }

    public function edit($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data = DeliveryNote::select(DB::raw('delivery_note.*'))
                    ->leftJoin(DB::raw('sales'), 'sales.id', '=', 'delivery_note.sales_id')
                    ->find($id);

                    $data_detail = DeliverynoteDetail::select(DB::raw('delivery_note_detail.*,
                    stock.id as stock_id,
                    product_variants.id as item_variant_id,
                    product_variants.name as nama_item_variant,
                    product_variants.price,
                    products.name as nama_item,
                    stock.stock,
                    MIN(product_medias.data_file) as data_file,
                    sales_detail.quantity as quantity_sales,
                    sales_detail.unit_id,
                    warehouses.name as nama_warehouse,
                    warehouses.id as warehouse_id'))
                    ->leftJoin('delivery_note', 'delivery_note.id', '=', 'delivery_note_detail.delivery_note_id')
                    ->leftJoin('sales', 'sales.id', '=', 'delivery_note.sales_id')
                    ->leftJoin('sales_detail', function($join) {
                        $join->on('sales_detail.sales_id', '=', 'sales.id')
                             ->on('sales_detail.item_variant_id', '=', 'delivery_note_detail.item_variant_id');
                    })
                    ->leftJoin('product_variants', 'product_variants.id', '=', 'delivery_note_detail.item_variant_id')
                    ->leftJoin('products', 'products.id', '=', 'product_variants.product_id')
                    ->leftJoin('product_medias', 'products.id', '=', 'product_medias.product_id')
                    ->leftJoin('stock', 'stock.id', '=', 'delivery_note_detail.stock_id')
                    ->leftJoin('warehouses', 'warehouses.id', '=', 'delivery_note_detail.warehouses_id')
                    ->where('delivery_note_detail.delivery_note_id', $id)
                    ->groupBy(
                        'sales_detail.quantity',
                        'sales_detail.unit_id',
                        'delivery_note_detail.id',
                        'stock.id',
                        'product_variants.id',
                        'products.id',
                        'warehouses.id'
                    )
                    ->get();

                    // dd($data_detail);
            

        if (!$data) {
            return abort(404);
        }

        return view("administrator.delivery_note.edit", compact('data', 'data_detail'));
    }

    // update data
    public function update(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $this->validate($request, [
            'date' => 'required',
            'delivery_note_number' => 'required',
            'detail' => 'required',
            'license_plate_number' => 'required',
            'sales_number' => 'required',
        ]);

        $id = $request->id;
        $sales = $this->data_sales($request->sales_number);
        
        $data = DeliveryNote::where('id', $id)->first();
        $data->update([
            'sales_id'                          => $sales->id,
            'date'                              => date('Y-m-d', strtotime($request->date)),
            'delivery_note_number'              => $request->delivery_note_number,
            'license_plate_number'              => $request->license_plate_number,
            'information'                       => $request->information,
            'weather'                           => $request->weather,
        ]);
        

        if ($request->has('detail')) {
            $sales_detail = $request->detail;
            foreach ($sales_detail as $detail) {
                if (!empty($detail['delivery_note_detail_id'])) {
                    $data_detail = DeliveryNoteDetail::where('id', $detail['delivery_note_detail_id'])->first();

                    if (intval($detail['quantity']) > floatVal($data_detail->quantity)) {
                        $jumlah =  intval($detail['quantity']) - floatVal($data_detail->quantity);
                        $data_stock = Stock::where('item_variant_id', $detail['item_variant_id'])->where('warehouse_id', $detail['warehouse_id'])->first();
                        $data_stock->stock = $data_stock->stock - $jumlah;
                        $data_stock->update();
                    } else if (intval($detail['quantity']) < floatVal($data_detail->quantity)) {
                        $jumlah =  floatVal($data_detail->quantity) - intval($detail['quantity']);
                        $data_stock = Stock::where('item_variant_id', $detail['item_variant_id'])->where('warehouse_id', $detail['warehouse_id'])->first();
                        $data_stock->stock = $data_stock->stock + $jumlah;
                        $data_stock->update();
                    }
                    

                    $data_detail->update([
                        'delivery_note_id'                  => $data->id,
                        'item_variant_id'                   => $detail['item_variant_id'],
                        'warehouses_id'                      => $detail['warehouse_id'],
                        'stock_id'                          => $detail['stock_id'],
                        'quantity'                          => $detail['quantity'],
                    ]);
                } else {
                    $detail = DeliveryNoteDetail::create([
                        'delivery_note_id'                  => $data->id,
                        'item_variant_id'                   => $detail['item_variant_id'],
                        'warehouses_id'                      => $detail['warehouse_id'],
                        'stock_id'                          => $detail['stock_id'],
                        'quantity'                          => $detail['quantity'],
                    ]);

                    $data_stock = Stock::where('item_variant_id', $detail['item_variant_id'])->where('warehouse_id', $detail['warehouse_id'])->first();
                    $data_stock->stock = $data_stock->stock - intval($detail['quantity']);
                    $data_stock->update();
                }
                
            }
        }

        createLog(static::$module, __FUNCTION__, $id);
        return redirect(route('admin.delivery_note'));
    }

 

    public function detail($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $data = DeliveryNote::select(DB::raw('delivery_note.*,customers.name as customer_name, sales.sales_number'))
                    ->leftJoin(DB::raw('sales'), 'sales.id', '=', 'delivery_note.sales_id')
                    ->leftJoin(DB::raw('customers'), 'customers.id', '=', 'sales.customer_id')
                    ->find($id);

        $data_detail = DeliverynoteDetail::select(DB::raw('delivery_note_detail.*,
        stock.id as stock_id,
        product_variants.id as item_variant_id,
        product_variants.name as nama_item_variant,
        product_variants.price,
        products.name as nama_item,
        stock.stock,
        MIN(product_medias.data_file) as data_file,
        sales_detail.quantity as quantity_sales,
        warehouses.name as nama_warehouse,
        warehouses.id as warehouse_id'))
        ->leftJoin(DB::raw('delivery_note'), 'delivery_note.id', '=', 'delivery_note_detail.delivery_note_id')
        ->leftJoin(DB::raw('sales'), 'sales.id', '=', 'delivery_note.sales_id')
        ->leftJoin('sales_detail', function($join) {
            $join->on('sales_detail.sales_id', '=', 'sales.id')
                 ->on('sales_detail.item_variant_id', '=', 'delivery_note_detail.item_variant_id');
        })
        ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'delivery_note_detail.item_variant_id')
        ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
        ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
        ->leftJoin(DB::raw('stock'), 'stock.id', '=', 'delivery_note_detail.stock_id')
        ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'delivery_note_detail.warehouses_id')
        ->where('delivery_note_detail.delivery_note_id', $id)
        ->groupBy(
            'sales_detail.quantity',
            'delivery_note_detail.id',
            'stock.id',
            'product_variants.id',
            'products.id',
            'warehouses.id'
        )
        ->get();

        if (!$data) {
            return abort(404);
        }

        return view("administrator.delivery_note.detail", compact('data', 'data_detail'));
    }

    public function delete(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $company_id = getCompanyId();
        $id = $request->ix;
        $deletedBy = auth()->user() ? auth()->user()->id : '';

        $invoice = InvoiceSales::where('company_id', $company_id)->where('delivery_note_id', $id)->count();
        if ($invoice > 0) {
            return response()->json([
                'code' => 409,
                'status' => 'error',
                'message' => 'Data has been used in the invoice sales'
            ], 409);
        }

        $data = DeliveryNote::find($id);
        $data->deleted_by = $deletedBy;
        $data->update();
        
        $data_detail = DeliveryNoteDetail::where('delivery_note_id',$id)->get();
        
        foreach ($data_detail as $detail) {
            $detail->deleted_by = $deletedBy;
            $detail->update();

            $data_stock = Stock::where('item_variant_id', $detail['item_variant_id'])->where('warehouse_id', $detail['warehouses_id'])->first();
            // dd($data_stock);
            $data_stock->stock = $data_stock->stock + intval($detail['quantity']);
            $data_stock->update();
            
            $detail->delete();
        }
        $data->delete();

        //Write log
        createLog(static::$module, __FUNCTION__, $request->ix);
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Data deleted successfully'
        ], 200);
    }
    
    public function deleteDetail(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $company_id = getCompanyId();
        $data_detail = DeliveryNoteDetail::find($request->id);

        $invoice = InvoiceSalesDetail::where('item_variant_id', $data_detail->item_variant_id)
                            ->leftJoin(DB::raw('invoice_sales'), 'invoice_sales.id', '=', 'invoice_sales_detail.invoice_sales_id')
                            ->where('invoice_sales.company_id', $company_id)
                            ->where('invoice_sales.delivery_note_id', $data_detail->delivery_note_id)
                            ->count();
        if ($invoice > 0) {
            return response()->json([
                'code' => 409,
                'status' => 'error',
                'message' => 'Data has been used in the invoice sales'
            ], 409);
        }

        if ($data_detail) {
            // Simpan ID pengguna yang menghapus sebelum menghapus
            $deletedBy = auth()->user() ? auth()->user()->id : '';
            $data_detail->deleted_by = $deletedBy;
            $data_detail->update();

            $data_stock = Stock::where('item_variant_id', $data_detail['item_variant_id'])->where('warehouse_id', $data_detail['warehouses_id'])->first();
            $data_stock->stock = $data_stock->stock + intval($data_detail['quantity']);
            $data_stock->update();

            // Hapus detail setelah update
            $data_detail->delete();

            // Write log
            createLog(static::$module, __FUNCTION__, $request->id);

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Data deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'Data not found'
            ], 404);
        }
    }
    
    function generateDeliveryNoteNumber() {
        $today = date('Y-m-d');
        $company_id = getCompanyId();

        // Mencari jumlah penjualan pada tanggal yang sama
        $nomorUrut = DeliveryNote::whereDate('created_at', $today)->where('company_id', $company_id)->withTrashed()->count() + 1;

        $tanggal = date('j');
        $bulan = date('n');
        $bulanRomawi = $this->konversiBulanKeRomawi($bulan);
        $tahun = date('Y');

        $kodeTertentu = $nomorUrut . '/DELIVERYNOTE/' . $company_id . '/' . $tanggal . '/' . $bulanRomawi . '/' . $tahun;

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

    public function exportExcel(Request $request){
        // Check permission
        if (!isAllowed(static::$module, "export")) {
            abort(403);
        }

        $whereSearch = '';

        $id = $request->id;

        $data = DeliveryNote::select(DB::raw('delivery_note.*,customers.name as customer_name, sales.sales_number'))
                    ->leftJoin(DB::raw('sales'), 'sales.id', '=', 'delivery_note.sales_id')
                    ->leftJoin(DB::raw('customers'), 'customers.id', '=', 'sales.customer_id')
                    ->find($id);

        $data_detail = DeliverynoteDetail::select(DB::raw('delivery_note_detail.*,
        stock.id as stock_id,
        product_variants.id as item_variant_id,
        product_variants.name as nama_item_variant,
        product_variants.price,
        products.name as nama_item,
        stock.stock,
        MIN(product_medias.data_file) as data_file,
        sales_detail.quantity as quantity_sales,
        warehouses.name as nama_warehouse,
        warehouses.id as warehouse_id'))
        ->leftJoin(DB::raw('delivery_note'), 'delivery_note.id', '=', 'delivery_note_detail.delivery_note_id')
        ->leftJoin(DB::raw('sales'), 'sales.id', '=', 'delivery_note.sales_id')
        ->leftJoin('sales_detail', function($join) {
            $join->on('sales_detail.sales_id', '=', 'sales.id')
                 ->on('sales_detail.item_variant_id', '=', 'delivery_note_detail.item_variant_id');
        })
        ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'delivery_note_detail.item_variant_id')
        ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
        ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
        ->leftJoin(DB::raw('stock'), 'stock.id', '=', 'delivery_note_detail.stock_id')
        ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'delivery_note_detail.warehouses_id')
        ->where('delivery_note_detail.delivery_note_id', $id)
        ->get();

        if (!$data) {
            return abort(404);
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
        
        $textRight = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
        ];

        $sheet->mergeCells('A1:G1')->getStyle('A1:G1')->getFont()->setBold(true)->setSize(16);
        $sheet->mergeCells('A1:G1')->getStyle('A1:G1')->applyFromArray($textCenter);
        $sheet->mergeCells('A2:G2')->getStyle('A2:G2')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A3:G3')->getStyle('A3:G3')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A4:G4')->getStyle('A4:G4')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A5:G5')->getStyle('A5:G5')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A6:G6')->getStyle('A6:G6')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A7:G7')->getStyle('A7:G7')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A8:G8')->getStyle('A8:G8')->getFont()->setBold(true)->setSize(12);
        $sheet->mergeCells('A9:G9')->getStyle('A9:G9')->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('A1', 'Detail Surat Jalan Penjualan');
        $sheet->setCellValue('A2', 'Tanggal : '.($data->date ? date('d-m-Y', strtotime($data->date)) : '-'))->getStyle('A2')->applyFromArray($textLeft);
        $sheet->setCellValue('A3', 'Customer : ' . ($data->customer_name ? $data->customer_name : '-'))->getStyle('A3')->applyFromArray($textLeft);
        $sheet->setCellValue('A4', 'Sales Number : '. ($data->sales_number ? $data->sales_number : '-'))->getStyle('A4')->applyFromArray($textLeft);
        $sheet->setCellValue('A5', 'Delivery Note Number : '. ($data->delivery_note_number ? $data->delivery_note_number : '-'))->getStyle('A5')->applyFromArray($textLeft);
        $sheet->setCellValue('A6', 'License Plate Number : '. ($data->license_plate_number ? $data->license_plate_number : '-'))->getStyle('A6')->applyFromArray($textLeft);
        $sheet->setCellValue('A7', 'Weather : '. ($data->weather ? $data->weather : '-'))->getStyle('A7')->applyFromArray($textLeft);
        $sheet->setCellValue('A8', 'Informasi : '. ($data->information ? $data->information : '-'))->getStyle('A8')->applyFromArray($textLeft);
        $sheet->setCellValue('A10', 'No')->getStyle('A10')->getFont()->setBold(true);
        $sheet->setCellValue('B10', 'Warehouse')->getStyle('B10')->getFont()->setBold(true);
        $sheet->setCellValue('C10', 'Item')->getStyle('C10')->getFont()->setBold(true);
        $sheet->setCellValue('D10', 'Item Variant')->getStyle('D10')->getFont()->setBold(true);
        $sheet->setCellValue('E10', 'Stock')->getStyle('E10')->getFont()->setBold(true);
        $sheet->setCellValue('F10', 'Quantity Sales')->getStyle('F10')->getFont()->setBold(true);
        $sheet->setCellValue('G10', 'Quantity')->getStyle('G10')->getFont()->setBold(true);
        

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
        

        $sheet->getStyle('A10:G'.(count($data_detail)+10))->applyFromArray($styleArray);
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);

        foreach ($data_detail as $detail){
            $sheet->setCellValue('A' . $rows, $no)->getStyle('A')->getAlignment();
            $sheet->setCellValue('B' . $rows, $detail['nama_warehouse'])->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('C' . $rows, $detail['nama_item'])->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('D' . $rows, $detail['nama_item_variant'])->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->setCellValue('E' . $rows, ($detail['stock'] + $detail['quantity']))->getStyle('E')->getAlignment()->applyFromArray($textRight);
            $sheet->setCellValue('F' . $rows, $detail['quantity_sales'])->getStyle('F')->getAlignment()->applyFromArray($textRight);
            $sheet->setCellValue('G' . $rows, $detail['quantity'])->getStyle('G')->getAlignment()->applyFromArray($textRight);
            $rows++;
            $no++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Detail Surat Jalan Penjualan - ' . $data->delivery_note_number . '.xlsx"');
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

        $data = DeliveryNote::select(DB::raw('delivery_note.*,customers.name as customer_name, sales.sales_number'))
                    ->leftJoin(DB::raw('sales'), 'sales.id', '=', 'delivery_note.sales_id')
                    ->leftJoin(DB::raw('customers'), 'customers.id', '=', 'sales.customer_id')
                    ->find($id);

        $data_detail = DeliverynoteDetail::select(DB::raw('delivery_note_detail.*,
        stock.id as stock_id,
        product_variants.id as item_variant_id,
        product_variants.name as nama_item_variant,
        product_variants.price,
        products.name as nama_item,
        stock.stock,
        MIN(product_medias.data_file) as data_file,
        sales_detail.quantity as quantity_sales,
        warehouses.name as nama_warehouse,
        warehouses.id as warehouse_id'))
        ->leftJoin(DB::raw('delivery_note'), 'delivery_note.id', '=', 'delivery_note_detail.delivery_note_id')
        ->leftJoin(DB::raw('sales'), 'sales.id', '=', 'delivery_note.sales_id')
        ->leftJoin('sales_detail', function($join) {
            $join->on('sales_detail.sales_id', '=', 'sales.id')
                 ->on('sales_detail.item_variant_id', '=', 'delivery_note_detail.item_variant_id');
        })
        ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'delivery_note_detail.item_variant_id')
        ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
        ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
        ->leftJoin(DB::raw('stock'), 'stock.id', '=', 'delivery_note_detail.stock_id')
        ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'delivery_note_detail.warehouses_id')
        ->where('delivery_note_detail.delivery_note_id', $id)
        ->get();

        if (!$data) {
            return abort(404);
        }

        $navbar = Layout::getLayout();
        if ($navbar['settings']['logo'] != "") {
            $logoPath = 'administrator/assets/media/settings/' . $navbar['settings']['logo'];
        } else {
            $logoPath = "";
        }

        $pdf = PDF::loadView("administrator.delivery_note.pdf", compact('data', 'data_detail', 'logoPath'));
        return $pdf->stream('Detail Surat Jalan Penjualan - ' . $data->delivery_note_number . '.pdf');
    }

    public function getDataItemVariant(Request $request)
    {
        
        $data = DeliveryNoteDetail::select(DB::raw(
            'delivery_note_detail.*, 
            stock.id as stock_id, 
            product_variants.id as item_variant_id, 
            product_variants.name as nama_item_variant, 
            product_variants.price, 
            products.name as nama_item, 
            stock.stock, 
            MIN(product_medias.data_file) as data_file, 
            SUM(sales_detail.quantity) as quantity_sales, 
            warehouses.name as nama_warehouse, 
            warehouses.id as warehouse_id'
        ))->leftJoin('delivery_note', 'delivery_note.id', '=', 'delivery_note_detail.delivery_note_id')
          ->leftJoin('sales', 'sales.id', '=', 'delivery_note.sales_id')
          ->leftJoin('sales_detail', 'sales_detail.item_variant_id', '=', 'delivery_note_detail.item_variant_id')
          ->leftJoin('product_variants', 'product_variants.id', '=', 'delivery_note_detail.item_variant_id')
          ->leftJoin('products', 'products.id', '=', 'product_variants.product_id')
          ->leftJoin('product_medias', 'products.id', '=', 'product_medias.product_id')
          ->leftJoin('stock', 'stock.id', '=', 'delivery_note_detail.stock_id')
          ->leftJoin('warehouses', 'warehouses.id', '=', 'delivery_note_detail.warehouses_id')
          ->where('delivery_note_detail.delivery_note_id', 8)
          ->whereNull('delivery_note_detail.deleted_at')
          ->groupBy('delivery_note_detail.id', 'stock.stock', 'product_variants.id', 'products.id', 'warehouses.id')
          ->get();
        
        
        if (!empty($request->sales_number)) {
            $data_item_from_sales = SalesDetail::select('sales_detail.item_variant_id')
                                        ->leftjoin('sales', 'sales.id' , '=', 'sales_detail.sales_id')
                                        ->where('sales.sales_number', $request->sales_number)
                                        ->get();
    
            $itemVariantIds = $data_item_from_sales->pluck('item_variant_id')->toArray();
            $data = $data->whereIn('id', $itemVariantIds);
        }
                    

        if (!empty($request->id)) {
            $data = $data->where('id',$request->id)->first();
        }

        return $data;
    }
    
    public function getDataStock(Request $request)
    {
        $data = Stock::select(DB::raw(
            'product_variants.id,
            stock.id as stock_id,
            product_variants.name as nama_item_variant,
            product_variants.price,
            products.name as nama_item,
            stock.stock,
            MIN(product_medias.data_file) as data_file,
            sales_detail.quantity as quantity_sales,
            sales_detail.unit_id,
            warehouses.name as nama_warehouse,
            warehouses.id as warehouse_id'
        ))->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'stock.item_variant_id')
            ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
            ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
            ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'stock.warehouse_id')
            ->leftJoin(DB::raw('sales_detail'), function($join) use ($request) {
                $join->on('sales_detail.item_variant_id', '=', 'product_variants.id')
                    ->where('sales_detail.sales_id', '=', DB::raw('(SELECT id FROM sales WHERE sales.sales_number = :sales_number LIMIT 1)'))
                    ->addBinding(['sales_number' => $request->sales_number], 'select');
            })
            ->groupBy('product_variants.id', 'sales_detail.unit_id', 'stock.id', 'sales_detail.quantity', 'product_variants.name', 'product_variants.price', 'products.name', 'stock.stock', 'warehouses.name', 'warehouses.id', 'product_medias.data_file')
            ->orderBy("stock.stock", "asc")
            ->get();

        if (!empty($request->sales_number)) {
            $data_item_from_sales = SalesDetail::select(DB::raw('sales_detail.item_variant_id'))
                ->leftJoin('sales', 'sales.id', '=', 'sales_detail.sales_id')
                ->where('sales.sales_number', $request->sales_number)
                ->get();

            $itemVariantIds = $data_item_from_sales->pluck('item_variant_id')->toArray();
            $data = $data->whereIn('id', $itemVariantIds);
            
            $sales_data = $this->data_sales($request->sales_number);
            $itemVariantRjectIds = $this->checkPerVariant($sales_data->id);
            $data = $data->whereIn('id', $itemVariantRjectIds);
        }

        if (!empty($request->id)) {
            // Use first() to retrieve a single result or null
            $singleData = $data->where('stock_id', $request->id)->first();

            // Check if the result is not null before accessing properties
            if ($singleData !== null) {
                return $singleData;
            } else {
                // Handle the case where the record with the specified ID is not found
                return response()->json(['error' => 'Record not found'], 404);
            }
        }

        return $data;
    }

    public function sisaPengiriman(Request $request){
        $sales = Sales::where('sales_number', $request->sales_number)->with('detail')->first();
        $quantity_sales = 0;
        foreach ($sales->detail as $row) {
            if ($row->item_variant_id == $request->item_variant_id) {
                $quantity_sales += floatVal($row->quantity);
            }
        }

        $delivery_note = DeliveryNote::where('sales_id', $sales->id)->with('detail')->get();

        $quantity_delivery = 0;
        foreach ($delivery_note as $row) {
            foreach ($row->detail as $col) {
                if ($col->item_variant_id == $request->item_variant_id) {
                    $quantity_delivery += floatVal($col->quantity);
                }
            }
        }
        
        return $quantity_sales - $quantity_delivery;
    }


    public function isExistDeliveryNoteNumber(Request $request){
        if($request->ajax()){
            $delivery_note = DeliveryNote::select('*');
            if(isset($request->delivery_note_number)){
                $delivery_note->where('delivery_note_number', $request->delivery_note_number);
            }
            if(isset($request->id)){
                $delivery_note->where('id', '<>', $request->id);
            }
            $data = [ 'valid' => ( $delivery_note->count() == 0)  ];
            if(!empty($delivery_note)){
                return $data;
            }else{
                return $data;
            }
        }
    }
    
    function isQuantityFulfilled($sales_id){
        $deliveryNotes = DeliveryNote::where('sales_id', $sales_id)->with('detail')->get();
        $sales_detail = SalesDetail::with('master')->where('sales_id', $sales_id)->get();
        
        foreach ($sales_detail as $salesDetail) {
            $quantity_sales = floatVal($salesDetail->quantity);
            $item_variant_id = $salesDetail->item_variant_id;
            $quantity_delivery = 0;
    
            foreach ($deliveryNotes as $deliveryNote) {
                $deliveryNoteDetails = $deliveryNote->detail->where('item_variant_id', $item_variant_id)->first();
                if ($deliveryNoteDetails) {
                    $quantity_delivery += floatVal($deliveryNoteDetails->quantity);
                }
            }
    
            if ($quantity_sales !== $quantity_delivery) {
                return false;
            }
        }
    
        return true;
    }
    
    function checkPerVariant($sales_id){
        $deliveryNotes = DeliveryNote::where('sales_id', $sales_id)->with('detail')->get();
        $sales_detail = SalesDetail::with('master')->where('sales_id', $sales_id)->get();
        
        $ids = [];
        foreach ($sales_detail as $salesDetail) {
            $quantity_sales = floatVal($salesDetail->quantity);
            $item_variant_id_sales = $salesDetail->item_variant_id;
            $quantity_delivery = 0;
    
            foreach ($deliveryNotes as $deliveryNote) {
                $deliveryNoteDetails = $deliveryNote->detail->where('item_variant_id', $item_variant_id_sales)->first();
                if ($deliveryNoteDetails) {
                    $quantity_delivery += floatVal($deliveryNoteDetails->quantity);
                }
            }
    
            if ($quantity_sales !== $quantity_delivery) {
                $ids[] += $item_variant_id_sales;
            }
        }
    
        return $ids;
    }
    

}
