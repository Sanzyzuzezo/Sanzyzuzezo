<?php

namespace App\Http\Controllers\Administrator;

use DataTables;
use App\Models\Sales;
use App\Models\Courier;
use App\Models\Customers;
use App\Models\Warehouse;
use App\Models\SalesDetail;
use App\Models\DeliveryNote;
use App\Models\InvoiceSales;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\UnitConversion;
use App\Models\DeliveryNoteDetail;
use App\Models\InvoiceSalesDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class SalesController extends Controller
{
    private static $module = "sales";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view("administrator.sales.index");
    }

    public function getData(Request $request)
    {   
        $company_id = getCompanyId();

        $query = Sales::select(DB::raw('sales.*, customers.name as customer_name'))
                        ->leftJoin(DB::raw('sales_detail'), 'sales.id', '=', 'sales_detail.sales_id')
                        ->leftJoin(DB::raw('customers'), 'customers.id', '=', 'sales.customer_id')
                        ->orderBy('sales.created_at', 'DESC')
                        ->groupBy('sales.id', 'customers.name');

        if ($company_id != 0) {
            $query->where('sales.company_id', $company_id);
        }

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
        
          
        $data = $query->get();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn = "";
                if(isAllowed(static::$module, "detail"))://Check permission
                    $btn .= '<a href="' . route('admin.sales.detail', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                    <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/>
                            <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/>
                        </svg>
                        </span>
                </a>';
                endif;
                if(isAllowed(static::$module, "edit"))://Check permission
                    $btn .= '<a href="' . route('admin.sales.edit', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
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
    
    public function add()
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }
        
        return view("administrator.sales.add");
        
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
            'sales_number' => 'required',
            'detail' => 'required',
            'customer_name' => 'required',
            'courier_title' => 'required',
        ]);
        
        $sales = Sales::create([
            'date'                              => date('Y-m-d', strtotime($request->date)),
            'sales_number'                      => $request->sales_number,
            'information'                       => $request->information,
            'total_sales_amount'                => $request->total_sales_amount,
            'customer_id'                       => $request->customer_id,
            'courier_id'                        => $request->courier_id,
            'status'                            => 1,
            'company_id'                        => $company_id
        ]);
        
        // dd($sales);

        if ($request->has('detail')) {
            $sales_detail = $request->detail;
            foreach ($sales_detail as $detail) {
                if ($detail['unit_id'] !== 0) {
                    $unit_conversion = UnitConversion::select(DB::raw('unit_conversions.quantity'))->find($detail['unit_id']);
                    $after = (str_replace([','], '', $detail['quantity'])) * (!empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1);
                }else{
                    $after = str_replace([','], '', $detail['quantity']);
                }
                SalesDetail::create([
                    'sales_id'                  => $sales->id,
                    'unit_id'                   => $detail['unit_id'],
                    'quantity_after_conversion' => $after,
                    'item_variant_id'           => $detail['item_variant_id'],
                    'quantity'                  => str_replace([','], '', $detail['quantity']),
                    'total'                     => str_replace(['Rp ', '.'], '', $detail['total']),
                ]);
            }
        }

        //Write log
        createLog(static::$module, __FUNCTION__, $sales->id);
        return redirect(route('admin.sales'));
    }

    public function edit($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data = Sales::select(DB::raw('sales.*, customers.id as customer_id, customers.name as customer_name, couriers.title as courier_title'))
                    ->leftJoin(DB::raw('customers'), 'customers.id', '=', 'sales.customer_id')
                    ->leftJoin(DB::raw('couriers'), 'couriers.id', '=', 'sales.courier_id')
                    ->find($id);

        $data_detail = SalesDetail::select(DB::raw('sales_detail.*, product_variants.name as nama_item_variant, product_variants.price, products.name as nama_item, units.name as nama_unit, MIN(product_medias.data_file) as data_file'))
        ->leftJoin('sales', 'sales.id', '=', 'sales_detail.sales_id')
        ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'sales_detail.item_variant_id')
        ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
        ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
        ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
        ->where('sales_detail.sales_id', $id)
        ->groupBy('sales_detail.id', 'product_variants.name', 'product_variants.price', 'products.name', 'units.name')
        ->get();
                
                

        if (!$data) {
            return abort(404);
        }

        return view("administrator.sales.edit", compact('data', 'data_detail'));
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
            'sales_number' => 'required',
            'detail' => 'required',
            'customer_name' => 'required',
        ]);

        $id = $request->id;
        
        $data = Sales::where('id', $id)->first();
        $data->update([
            'date'                              => date('Y-m-d', strtotime($request->date)),
            'sales_number'                      => $request->sales_number,
            'information'                       => $request->information,
            'total_sales_amount'                => $request->total_sales_amount,
            'customer_id'                       => $request->customer_id,
            'courier_id'                        => $request->courier_id,
            'status'                            => 1,
        ]);
        

        if ($request->has('detail')) {
            $sales_detail = $request->detail;
            foreach ($sales_detail as $detail) {
                if ($detail['unit_id'] !== 0) {
                    $unit_conversion = UnitConversion::select(DB::raw('unit_conversions.quantity'))->find($detail['unit_id']);
                    $after = (str_replace([','], '', $detail['quantity'])) * (!empty($unit_conversion) ? str_replace(',', '', $unit_conversion['quantity']) : 1);
                }else{
                    $after = str_replace([','], '', $detail['quantity']);
                }
                if (!empty($detail['sales_detail_id'])) {
                    $data_detail = SalesDetail::where('id', $detail['sales_detail_id'])->first();
                    $data_detail->update([
                        'sales_id'                  => $id,
                        'item_variant_id'           => $detail['item_variant_id'],
                        'unit_id'                   => $detail['unit_id'],
                        'quantity_after_conversion' => $after,
                        'quantity'                  => str_replace([','], '', $detail['quantity']),
                        'total'                     => str_replace(['Rp ', '.'], '', $detail['total']),
                    ]);
                } else {
                    SalesDetail::create([
                        'sales_id'                  => $id,
                        'item_variant_id'           => $detail['item_variant_id'],
                        'unit_id'                   => $detail['unit_id'],
                        'quantity_after_conversion' => $after,
                        'quantity'                  => str_replace([','], '', $detail['quantity']),
                        'total'                     => str_replace(['Rp ', '.'], '', $detail['total']),
                    ]);
                }
                
            }
        }

        createLog(static::$module, __FUNCTION__, $id);
        return redirect(route('admin.sales'));
    }

 

    public function detail($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $data = Sales::select(DB::raw('sales.*, customers.id as customer_id, customers.name as customer_name, couriers.title as courier_title'))
                    ->leftJoin(DB::raw('customers'), 'customers.id', '=', 'sales.customer_id')
                    ->leftJoin(DB::raw('couriers'), 'couriers.id', '=', 'sales.courier_id')
                    ->find($id);

            $data_detail = SalesDetail::select(DB::raw(
                'sales_detail.*, 
                product_variants.name as nama_item_variant, 
                product_variants.price, 
                products.name as nama_item, 
                units.name as nama_unit, 
                MIN(product_medias.data_file) as data_file
                '))
            ->leftJoin('sales', 'sales.id', '=', 'sales_detail.sales_id')
            ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'sales_detail.item_variant_id')
            ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
            ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
            ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
            ->where('sales_detail.sales_id', $id)
            ->groupBy('sales_detail.id', 'product_variants.name', 'product_variants.price', 'products.name', 'units.name')
            ->get();
            

        if (!$data) {
            return back();
        }

        return view("administrator.sales.detail", compact('data', 'data_detail'));
    }

    public function delete(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $id = $request->ix;
        $deletedBy = auth()->user() ? auth()->user()->id : '';

        $company_id = getCompanyId();

        $delivery_note = DeliveryNote::where('company_id', $company_id)->where('sales_id', $id)->count();
        if ($delivery_note > 0) {
            return response()->json([
                'code' => 409,
                'status' => 'error',
                'message' => 'Data has been used in the delivery note',
            ], 409);
        }

        $invoice = InvoiceSales::where('company_id', $company_id)->where('sales_id', $id)->count();
        if ($invoice > 0) {
            return response()->json([
                'code' => 409,
                'status' => 'error',
                'message' => 'Data has been used in the invoice sales'
            ], 409);
        }

        $data = Sales::find($id);
        $data->deleted_by = $deletedBy;
        $data->update();
        
        $data_detail = SalesDetail::where('sales_id',$id)->get();
        
        foreach ($data_detail as $detail) {
            $detail->deleted_by = $deletedBy;
            $detail->update();
            
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

        $id = $request->id;
        $deletedBy = auth()->user() ? auth()->user()->id : '';

        $company_id = getCompanyId();
        $data_detail = SalesDetail::find($id);

        $delivery_note = DeliveryNoteDetail::where('item_variant_id', $data_detail->item_variant_id)
                        ->leftJoin(DB::raw('delivery_note'), 'delivery_note.id', '=', 'delivery_note_detail.delivery_note_id')
                        ->where('delivery_note.company_id', $company_id)
                        ->where('delivery_note.sales_id', $data_detail->sales_id)
                        ->count();
        if ($delivery_note > 0) {
            return response()->json([
                'code' => 409,
                'status' => 'error',
                'message' => 'Data has been used in the delivery note',
            ], 409);
        }

        $invoice = InvoiceSalesDetail::where('item_variant_id', $data_detail->item_variant_id)
                                    ->leftJoin(DB::raw('invoice_sales'), 'invoice_sales.id', '=', 'invoice_sales_detail.invoice_sales_id')
                                    ->where('invoice_sales.company_id', $company_id)
                                    ->where('invoice_sales.sales_id', $data_detail->sales_id)
                                    ->count();
        if ($invoice > 0) {
            return response()->json([
                'code' => 409,
                'status' => 'error',
                'message' => 'Data has been used in the invoice sales'
            ], 409);
        }

        if ($data_detail) {
            // // Simpan ID pengguna yang menghapus sebelum menghapus
            $data_detail->deleted_by = $deletedBy;
            $data_detail->update();

            // Hapus detail setelah update
            $data_detail->delete();

            // // Write log
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
    
    public function updateTotalSalesAmount(Request $request)
    {
        $data_detail = SalesDetail::where('id', $request->id)->withTrashed()->first();
        // dd($data_detail);
        
        if ($data_detail) {
            $data = Sales::where('id',$data_detail->sales_id)->first();
            // Simpan ID pengguna yang menghapus sebelum menghapus
            $data->update(['total_sales_amount' => $request->total_sales_amount]);

            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }
    }
    
    function generateSalesNumber() {
        $today = date('Y-m-d');

        $company_id = getCompanyId();
        // Mencari jumlah penjualan pada tanggal yang sama
        $nomorUrut = Sales::whereDate('created_at', $today)->where('company_id', $company_id)->withTrashed()->count() + 1;

        $tanggal = date('j');
        $bulan = date('n');
        $bulanRomawi = $this->konversiBulanKeRomawi($bulan);
        $tahun = date('Y');

        $kodeTertentu = $nomorUrut . '/SALES/'. $company_id . '/' . $tanggal . '/' . $bulanRomawi . '/' . $tahun;

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

    public function export(Request $request){
        $params = [];
        $whereClauses = [];
        $start_date="";
        $end_date="";
        $suppliers = "";
        $warehouses = "";
        $whereSearch = ''; 

        if($request->date || $request->customer_id || $request->search_datatable){
            if (!empty($request->date)) {
                $tanggal = explode("-", $request->date);
                $start_date = date('Y-m-d', strtotime($tanggal[0]));
                $end_date = date('Y-m-d', strtotime($tanggal[1]));
                $params[] = [DB::raw("TO_CHAR(sales.date, 'YYYY-MM-DD')"), ">=", $start_date];
                $params[] = [DB::raw("TO_CHAR(sales.date, 'YYYY-MM-DD')"), "<=", $end_date];
            }

            if (!empty($request->customer_id)){
                $params[] = ["sales.customer_id", "=", $request->customer_id];
            }

            if (!empty($request->search_datatable)) {
                $whereClauses[] = [
                    'column' => 'sales.date',
                    'value' => '%' . strtolower($request->search_datatable) . '%'
                ];
                $whereClauses[] = [
                    'column' => 'sales.sales_number',
                    'value' => '%' . strtolower($request->search_datatable) . '%'
                ];
                $whereClauses[] = [
                    'column' => 'sales.total_sales_amount',
                    'value' => '%' . strtolower($request->search_datatable) . '%'
                ];
                $whereClauses[] = [
                    'column' => 'sales.information',
                    'value' => '%' . strtolower($request->search_datatable) . '%'
                ];
                $whereClauses[] = [
                    'column' => 'customers.name',
                    'value' => '%' . strtolower($request->search_datatable) . '%'
                ];
            }
        }
        $company_id = getCompanyId();
        $query = Sales::select(DB::raw('sales.*, customers.name as customer_name'))
                        ->leftJoin(DB::raw('sales_detail'), 'sales.id', '=', 'sales_detail.sales_id')
                        ->leftJoin(DB::raw('customers'), 'sales.customer_id', '=', 'customers.id')                      
                        ->orderBy('sales.created_at', 'DESC')
                        ->groupBy('sales.id','customers.name')
                        ->where($params);
        
                        if ($company_id != 0) {
                            $query->where('sales.company_id', $company_id);
                        }

                        foreach ($whereClauses as $clause) {
                            $query->orWhere($clause['column'], 'LIKE', $clause['value']);
                        }

        $sales = $query->get();

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
        $sheet->setCellValue('A1', 'Daftar Penjualan');
        $sheet->setCellValue('A2', 'No')->getStyle('A2')->getFont()->setBold(true);
        $sheet->setCellValue('B2', 'Nomor Sales')->getStyle('B2')->getFont()->setBold(true);
        $sheet->setCellValue('C2', 'Tanggal')->getStyle('C2')->getFont()->setBold(true);
        $sheet->setCellValue('D2', 'Customer')->getStyle('D2')->getFont()->setBold(true);
        $sheet->setCellValue('E2', 'Jumlah Total Penjualan')->getStyle('E2')->getFont()->setBold(true);
        $sheet->setCellValue('F2', 'Informasi')->getStyle('F2')->getFont()->setBold(true);
        

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

        $sheet->getStyle('A2:F'.(count($sales)+2))->applyFromArray($styleArray);
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);

        foreach ($sales as $data){
            $sheet->setCellValue('A' . $rows, $no)->getStyle('A')->getAlignment();
            $sheet->setCellValue('B' . $rows, $data['sales_number'])->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('C' . $rows, date('d F Y', strtotime($data['date'])))->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('D' . $rows, $data['customer_name'])->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('E' . $rows, $data['total_sales_amount'])->getStyle('E')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('F' . $rows, $data['information'])->getStyle('E')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $rows++;
            $no++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Daftar Penjualan.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function exportDetail(Request $request){
        $suppliers = "";
        $warehouses = "";
        $whereSearch = '';
        $id = $request->id;
        $query = Sales::select(DB::raw('sales.*, customers.name as customer_name, couriers.title as courier_title'))
                    ->leftJoin(DB::raw('customers'), 'sales.customer_id', '=', 'customers.id')
                    ->leftJoin(DB::raw('couriers'), 'couriers.id', '=', 'sales.courier_id')
                    ->where('sales.id', $id);
        $sales = $query->first();
        $sales_detail = SalesDetail::select(DB::raw('sales_detail.*, product_variants.name as nama_item_variant, product_variants.price, products.name as nama_item, units.name as nama_unit,  MIN(product_medias.data_file) as data_file'))
                                    ->leftJoin('sales', 'sales.id', '=', 'sales_detail.sales_id')
                                    ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'sales_detail.item_variant_id')
                                    ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                                    ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
                                    // ->leftJoin(DB::raw('stock'), 'stock.item_variant_id', '=', 'product_variants.id')
                                    // ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'stock.warehouse_id')
                                    ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
                                    ->where('sales_detail.sales_id', $id)
                                    ->groupBy('sales_detail.id','product_variants.name','product_variants.price','products.name','units.name')
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
        $textRight = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
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
        $sheet->setCellValue('A1', 'Detail Penjualan');
        $sheet->setCellValue('A2', 'Nomor Sales : '.($sales->sales_number ? $sales->sales_number : '-'))->getStyle('A2')->applyFromArray($textLeft);
        $sheet->setCellValue('A3', 'Tanggal : ' . ($sales->date ? $sales->date : '-'))->getStyle('A3')->applyFromArray($textLeft);
        $sheet->setCellValue('A4', 'Customer : '. ($sales->customer_name ? $sales->customer_name : '-'))->getStyle('A4')->applyFromArray($textLeft);
        $sheet->setCellValue('A5', 'Courier : '. ($sales->courier_title ? $sales->courier_title : '-'))->getStyle('A5')->applyFromArray($textLeft);
        $sheet->setCellValue('A6', 'Jumlah Total Penjualan : '. ($sales->total_sales_amount ? $sales->total_sales_amount : '-'))->getStyle('A6')->applyFromArray($textLeft);
        $sheet->setCellValue('A7', 'Informasi : '. ($sales->information ? $sales->information : '-'))->getStyle('A7')->applyFromArray($textLeft);
        $sheet->setCellValue('A8', 'No')->getStyle('A8')->getFont()->setBold(true);
        $sheet->setCellValue('B8', 'Item')->getStyle('B8')->getFont()->setBold(true);
        $sheet->setCellValue('C8', 'Item Variant')->getStyle('C8')->getFont()->setBold(true);
        $sheet->setCellValue('D8', 'Price')->getStyle('D8')->getFont()->setBold(true);
        $sheet->setCellValue('E8', 'Qty')->getStyle('E8')->getFont()->setBold(true);
        $sheet->setCellValue('F8', 'Total')->getStyle('F8')->getFont()->setBold(true);
        $rows = 9;
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
        $sheet->getStyle('A8:F'.(count($sales_detail)+7))->applyFromArray($styleArray);
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(15);
        foreach ($sales_detail as $data){
            $sheet->setCellValue('A' . $rows, $no)->getStyle('A')->getAlignment();
            $sheet->setCellValue('B' . $rows, $data['nama_item'])->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('C' . $rows, $data['nama_item_variant'])->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('D' . $rows, $data['price'])->getStyle('D')->getAlignment()->applyFromArray($textRight);
            $sheet->setCellValue('E' . $rows, $data['quantity'])->getStyle('E')->getAlignment()->applyFromArray($textRight);
            $sheet->setCellValue('F' . $rows, $data['total'])->getStyle('F')->getAlignment()->applyFromArray($textRight);
            $rows++;
            $no++;
        }
        $sheet->mergeCells('A'. $rows .':E'. $rows .'')->getStyle('A'. $rows .':E'. $rows .'')->applyFromArray($styleArray);
        $sheet->setCellValue('A' . $rows, 'Jumlah')->getStyle('A')->getAlignment()->applyFromArray($textCenter);
        $sheet->mergeCells('F'. $rows )->getStyle('F'. $rows )->applyFromArray($styleArray);
        $sheet->setCellValue('F' . $rows, ($sales->total_sales_amount ? $sales->total_sales_amount : '-'))->getStyle('F')->getAlignment()->applyFromArray($textRight);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Detail Penjualan.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function getUnit(Request $request)
{
    $variant = ProductVariant::select(
        DB::raw('units.name as name'),
        DB::raw('CAST(0 AS INTEGER) as id'),
        DB::raw('CAST(1 AS INTEGER) as quantity_after_conversion')
    )
        ->where('product_variants.id', $request->id)
        ->leftJoin('units', 'units.id', '=', 'product_variants.unit_id');

    $data = UnitConversion::select(
        DB::raw('unit_conversions.new_unit as name'),
        DB::raw('CAST(unit_conversions.id AS INTEGER) as id'),
        DB::raw('unit_conversions.quantity as quantity_after_conversion')
    )
        ->leftJoin('units', 'units.id', '=', 'unit_conversions.unit_id')
        ->where("unit_conversions.item_variant_id", $request->id);

    $result = $variant->union($data)->get();
    // dd($result);

    return $result;
}


    public function getDataItemVariant(Request $request)
    {
        // dd($request);
        $query = ProductVariant::select(DB::raw('
        product_variants.id, 
        product_variants.name as nama_item_variant, 
        product_variants.price, 
        products.name as nama_item, 
        (SELECT SUM(stock) 
                    FROM stock
                    WHERE stock.item_variant_id = product_variants.id 
                    AND stock.deleted_at IS NULL
                ) as stock,
        units.name as nama_unit, 
        MIN(product_medias.data_file) as data_file
        '))
                    ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
                    ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
                    ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
                    ->where("product_variants.status", 1)
                    ->where("product_variants.sale", 1)
                    ->groupBy('product_variants.id', 'product_variants.name', 'product_variants.price', 'products.name', 'units.name')
                    ->orderBy("products.name", "asc");
        $company_id = getCompanyId();
        if ($company_id != 0) {
            $query->where('products.company_id', $company_id);
        }
        $data = $query->get();

        if (!empty($request->id)) {
            $data = $data->where('id',$request->id)->first();
        }

        return $data;
    }
    
    public function getDataCustomer(Request $request)
    {
        // dd($request);
        $query = Customers::select(DB::raw('customers.*, customer_groups.name as customer_group_name'))
                    ->leftJoin(DB::raw('customer_groups'), 'customer_groups.id', '=', 'customers.customer_group_id')
                    ->where("customers.status", "t")
                    ->orderBy("customers.id", "asc");

        $company_id = getCompanyId();
        if ($company_id != 0) {
            $query->where('customers.company_id', $company_id);
        }
        $data = $query->get();

        if (!empty($request->id)) {
            $data = $data->where('id',$request->id)->first();
        }

        return $data;
    }

    public function getDataCourier(Request $request)
    {
            $data = Courier::select('couriers.*')          
                ->orderBy('id')
                ->get();

            if (!empty($request->id)) {
                $data = $data->where('id',$request->id)->first();
            }
        return $data;
    }

    public function isExistSalesNumber(Request $request){
        if($request->ajax()){
            $sales = Sales::select('*');
            if(isset($request->sales_number)){
                $sales->where('sales_number', $request->sales_number);
            }
            if(isset($request->id)){
                $sales->where('id', '<>', $request->id);
            }
            $data = [ 'valid' => ( $sales->count() == 0)  ];
            if(!empty($sales)){
                return $data;
            }else{
                return $data;
            }
        }
    }
}
