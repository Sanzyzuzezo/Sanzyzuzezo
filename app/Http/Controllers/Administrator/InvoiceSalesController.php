<?php

namespace App\Http\Controllers\Administrator;

use DB;
use File;
use DataTables;
use App\Models\Sales;
use PDF;
use App\Models\Customers;
use App\Models\SalesDetail;
use Illuminate\Support\Str;
use App\Models\DeliveryNote;
use App\Models\InvoiceSales;
use Illuminate\Http\Request;
use App\Models\SettingCompany;
use App\Models\DeliveryNoteDetail;
use App\Models\InvoiceSalesDetail;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class InvoiceSalesController extends Controller
{
    private static $module = "invoice_sales";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view("administrator.invoice_sales.index");
    }

    public function getData(Request $request)
    {   
        $company_id = getCompanyId();

        $query = InvoiceSales::select(DB::raw('invoice_sales.*, customers.name as customer_name'))
                        ->leftJoin(DB::raw('invoice_sales_detail'), 'invoice_sales.id', '=', 'invoice_sales_detail.invoice_sales_id')
                        ->leftJoin(DB::raw('customers'), 'customers.id', '=', 'invoice_sales.customer_id')
                        ->orderBy('invoice_sales.created_at', 'DESC')
                        ->groupBy('invoice_sales.id', 'customers.name');

        if ($company_id != 0) {
            $query->where('invoice_sales.company_id', $company_id);
        }

        if ($request->date || $request->customer_id || $request->typeInvoice) {
            $query = $query->where(function ($data_search) use ($request) {
                if($request->date != "") {
                    $start_date = '';
                    $tanggal = explode("-", $request->date);
                    $start_date = date('Y-m-d', strtotime($tanggal[0]));
                    $end_date = date('Y-m-d', strtotime($tanggal[1]));
                    $data_search = $data_search->whereBetween('invoice_sales.date', [$start_date, $end_date]);
                }
                if ($request->customer_id != "") {
                    $data_search->where("invoice_sales.customer_id", $request->customer_id);
                }
                if ($request->typeInvoice != "") {
                    if ($request->typeInvoice === 'sales') {
                        $data_search->where("invoice_sales.sales_id", '!=', 0);
                    }else{
                        $data_search->where("invoice_sales.delivery_note_id", '!=', 0);
                    }
                }
            });
        }
        
          
        $data = $query->get();

        return DataTables::of($data)
            ->addColumn('payment_status', function ($row) {
                $btn = "";
                if(isAllowed(static::$module, "validasi"))://Check permission
                    if ($row->payment_status === 0) {
                        $btn .= '<span class="text-danger">UnPaid</span>
                        <a href="javascript:void(0)" class="btn btn-icon btn-active-color-primary btn-sm me-1 triggerProofPayment" data-ix="'.$row->id.'" title="Proof of payment">
                            <span class="svg-icon svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/keen/releases/2021-04-21-040700/theme/demo2/dist/../src/media/svg/icons/General/Clip.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="16" height="16"/>
                                <path d="M14,16 L12,16 L12,12.5 C12,11.6715729 11.3284271,11 10.5,11 C9.67157288,11 9,11.6715729 9,12.5 L9,17.5 C9,19.4329966 10.5670034,21 12.5,21 C14.4329966,21 16,19.4329966 16,17.5 L16,7.5 C16,5.56700338 14.4329966,4 12.5,4 L12,4 C10.3431458,4 9,5.34314575 9,7 L7,7 C7,4.23857625 9.23857625,2 12,2 L12.5,2 C15.5375661,2 18,4.46243388 18,7.5 L18,17.5 C18,20.5375661 15.5375661,23 12.5,23 C9.46243388,23 7,20.5375661 7,17.5 L7,12.5 C7,10.5670034 8.56700338,9 10.5,9 C12.4329966,9 14,10.5670034 14,12.5 L14,16 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.500000, 12.500000) rotate(-315.000000) translate(-12.500000, -12.500000) "/>
                            </g>
                        </svg><!--end::Svg Icon--></span>    
                        </a>';
                    } else {
                        $btn .= '<span class="text-success">Paid</span>
                        <a href="javascript:void(0)" class="btn btn-icon btn-active-color-primary btn-sm me-1 triggerProofPayment" data-ix="'.$row->id.'" title="Proof of payment">
                            <span class="svg-icon svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/keen/releases/2021-04-21-040700/theme/demo2/dist/../src/media/svg/icons/General/Clip.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="16" height="16"/>
                                <path d="M14,16 L12,16 L12,12.5 C12,11.6715729 11.3284271,11 10.5,11 C9.67157288,11 9,11.6715729 9,12.5 L9,17.5 C9,19.4329966 10.5670034,21 12.5,21 C14.4329966,21 16,19.4329966 16,17.5 L16,7.5 C16,5.56700338 14.4329966,4 12.5,4 L12,4 C10.3431458,4 9,5.34314575 9,7 L7,7 C7,4.23857625 9.23857625,2 12,2 L12.5,2 C15.5375661,2 18,4.46243388 18,7.5 L18,17.5 C18,20.5375661 15.5375661,23 12.5,23 C9.46243388,23 7,20.5375661 7,17.5 L7,12.5 C7,10.5670034 8.56700338,9 10.5,9 C12.4329966,9 14,10.5670034 14,12.5 L14,16 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.500000, 12.500000) rotate(-315.000000) translate(-12.500000, -12.500000) "/>
                            </g>
                        </svg><!--end::Svg Icon--></span>    
                        </a>';
                    }
                endif;
                return $btn;
            })
            ->addColumn('action', function ($row) {
                $btn = "";
                if(isAllowed(static::$module, "detail"))://Check permission
                    $btn .= '<a href="' . route('admin.invoice_sales.detail', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                    <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/>
                            <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/>
                        </svg>
                        </span>
                </a>';
                endif;
                if(isAllowed(static::$module, "edit"))://Check permission
                    $btn .= '<a href="' . route('admin.invoice_sales.edit', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
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
            })->rawColumns(['action','payment_status'])
            ->make(true);
    }
    
    public function add()
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }
        
        return view("administrator.invoice_sales.add");
        
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
            'invoice_sales_number' => 'required',
            'detail' => 'required',
            'customer_name' => 'required',
            'invoice_type' => 'required',
        ]);

        $invoice_sales = InvoiceSales::create([
            'customer_id'                       => $request->customer_id,
            'sales_id'                          => $request->sales_id ? $request->sales_id : 0,
            'delivery_note_id'                  => $request->delivery_note_id ? $request->delivery_note_id : 0,
            'date'                              => date('Y-m-d', strtotime($request->date)),
            'invoice_sales_number'              => $request->invoice_sales_number,
            'information'                       => $request->information,
            'total_payment_amount'              => $request->total_payment_amount,
            'company_id'                        => $company_id
        ]);
        

        if ($request->has('detail')) {
            $invoice_sales_detail = $request->detail;
            foreach ($invoice_sales_detail as $detail) {
                InvoiceSalesDetail::create([
                    'invoice_sales_id'                  => $invoice_sales->id,
                    'item_variant_id'           => $detail['item_variant_id'],
                    'quantity'                  => str_replace([','], '', $detail['quantity']),
                    'total_payment'                     => str_replace(['Rp ', '.'], '', $detail['total']),
                ]);
            }
        }

        //Write log
        createLog(static::$module, __FUNCTION__, $invoice_sales->id);
        return redirect(route('admin.invoice_sales'));
    }

    public function edit($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data = InvoiceSales::select(
            DB::raw('invoice_sales.*, customers.id as customer_id, customers.name as customer_name, sales.sales_number,
            delivery_note.delivery_note_number')
        )
        ->leftJoin('customers', 'customers.id', '=', 'invoice_sales.customer_id')
        ->leftJoin('sales', 'sales.id', '=', 'invoice_sales.sales_id')
        ->leftJoin('delivery_note', 'delivery_note.id', '=', 'invoice_sales.delivery_note_id')
        ->where('invoice_sales.id', $id)
        ->first();

        if (!$data) {
            return abort(404);
        }

        $data_detail = InvoiceSalesDetail::select(DB::raw('
        invoice_sales_detail.*, 
        invoice_sales_detail.id as id, 
        product_variants.name as nama_item_variant, 
        product_variants.price, 
        products.name as nama_item, 
        units.name as nama_unit, 
        MIN(product_medias.data_file) as data_file,
        (
            ' . ($data->sales_id == 0 ? 
            "SELECT SUM(delivery_note_detail.quantity) 
            FROM delivery_note_detail 
            JOIN delivery_note ON delivery_note.id = delivery_note_detail.delivery_note_id
            WHERE delivery_note_detail.delivery_note_id = ".$data->delivery_note_id." 
            AND delivery_note_detail.deleted_at IS NULL
            AND invoice_sales_detail.item_variant_id = delivery_note_detail.item_variant_id "
            : 
            "SELECT SUM(sales_detail.quantity) 
            FROM sales_detail 
            JOIN sales ON sales.id = sales_detail.sales_id
            WHERE sales_detail.sales_id = ".$data->sales_id." 
            AND sales_detail.deleted_at IS NULL
            AND invoice_sales_detail.item_variant_id = sales_detail.item_variant_id "
           ) . '
        ) as quantity_total
        
            '))//quantity total adalah sum quantity dari headnya misalnya dari sales_detail.quantity 
            //dan quantity sum adalah jumlah quantity yang sudah digunakan di invoice
            
            ->leftJoin('invoice_sales', 'invoice_sales.id', '=', 'invoice_sales_detail.invoice_sales_id')
            ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'invoice_sales_detail.item_variant_id')
            ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
            ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
            ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
            ->where('invoice_sales_detail.invoice_sales_id', $id)
            ->groupBy('invoice_sales_detail.id','product_variants.name','product_variants.price','products.name','units.name')
            ->get();

            $invoices = InvoiceSales::where('sales_id', $data->sales_id)->get();
            $sumqty = [];

            foreach ($invoices as $invoice) {
                foreach ($invoice->detail as $row) {
                    $itemVariantId = $row->item_variant_id;

                    // Check if the item variant ID already exists in $sumqty
                    if (array_key_exists($itemVariantId, $sumqty)) {
                        // If it exists, add the quantity
                        $sumqty[$itemVariantId] += $row->quantity;
                    } else {
                        // If it doesn't exist, create a new entry
                        $sumqty[$itemVariantId] = $row->quantity;
                    }
                }
            }

        return view("administrator.invoice_sales.edit", compact('data', 'data_detail', 'sumqty'));
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
            'invoice_sales_number' => 'required',
            'detail' => 'required',
            'customer_name' => 'required',
        ]);


        $id = $request->id;
        // dd($request);
        
        $data = InvoiceSales::where('id', $id)->first();
        $data->update([
            'date'                              => date('Y-m-d', strtotime($request->date)),
            'information'                       => $request->information,
            'total_payment_amount'              => $request->total_payment_amount,
        ]);

        if ($request->has('detail')) {
            $invoice_sales_detail = $request->detail;
            foreach ($invoice_sales_detail as $detail) {
                if (!empty($detail['detail_id'])) {
                    $data_detail = InvoiceSalesDetail::where('id', $detail['detail_id'])->first();
                    $data_detail->update([
                        'invoice_sales_id'                  => $id,
                        'item_variant_id'                   => $detail['item_variant_id'],
                        'quantity'                          => str_replace([','], '', $detail['quantity']),
                        'total_payment'                     => str_replace(['Rp ', '.'], '', $detail['total']),
                    ]);
                }
            }
        }

        createLog(static::$module, __FUNCTION__, $id);
        return redirect(route('admin.invoice_sales'));
    }

    public function uploadProofofPayment(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "validasi")) {
            abort(403);
        }

        $this->validate($request, [
            'information' => 'required',
        ]);

        $id = $request->id;
        
        $data = InvoiceSales::where('id', $id)->first();
        $data->update([
            'payment_information'         => $request->information,
            'payment_status'              => 1,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if (!empty($data->proof_of_payment)) {
                $image_path = "./administrator/assets/media/invoice_sales/" . $data->proof_of_payment;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }

            $fileName  = Str::slug(strtolower($data->invoice_sales_number)) . "_" . time() . '.' . $image->getClientOriginalExtension();//str_replace('/', '',$data->invoice_sales_number)
            $path = upload_path('invoice_sales') . $fileName;
            Image::make($image->getRealPath())->save($path, 100);
            $data->update(['proof_of_payment' => $fileName]);
        } 
        if(!$request->image) {
            return response()->json([
                'status' => 400,
                'message' => 'File not found'
            ], 400);
        }


        createLog(static::$module, __FUNCTION__, $id);
        return response()->json([
            'status' => 200,
            'message' => 'Proof has been uploaded'
        ], 200);
    }

    public function cancelProofofPayment(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "validasi")) {
            abort(403);
        }

        $id = $request->id;
        
        $data = InvoiceSales::where('id', $id)->first();
        $data->update([
            'payment_information'         => null,
            'payment_status'              => 0,
        ]);
        if (!empty($data->proof_of_payment)) {
            $image_path = "./administrator/assets/media/invoice_sales/" . $data->proof_of_payment;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $data->update(['proof_of_payment' => null]);
        }

        createLog(static::$module, __FUNCTION__, $id);
        return response()->json([
            'status' => 200,
            'message' => 'Proof has been canceled'
        ], 200);
    }

 

    public function detail($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $data = InvoiceSales::select(
            DB::raw('invoice_sales.*, customers.id as customer_id, customers.name as customer_name,  customers.address as customer_address,  customers.phone as customer_phone, sales.sales_number,
            delivery_note.delivery_note_number')
        )
        ->leftJoin('customers', 'customers.id', '=', 'invoice_sales.customer_id')
        ->leftJoin('sales', 'sales.id', '=', 'invoice_sales.sales_id')
        ->leftJoin('delivery_note', 'delivery_note.id', '=', 'invoice_sales.delivery_note_id')
        ->where('invoice_sales.id', $id)
        ->first();

        if (!$data) {
            return abort(404);
        }

        $data_detail = InvoiceSalesDetail::select(DB::raw('
        invoice_sales_detail.*, 
        invoice_sales_detail.id as id, 
        product_variants.name as nama_item_variant, 
        product_variants.price, 
        products.name as nama_item, 
        units.name as nama_unit, 
        MIN(product_medias.data_file) as data_file,
        (
            ' . ($data->sales_id == 0 ? 
            "SELECT SUM(delivery_note_detail.quantity) 
            FROM delivery_note_detail 
            JOIN delivery_note ON delivery_note.id = delivery_note_detail.delivery_note_id
            WHERE delivery_note_detail.delivery_note_id = ".$data->delivery_note_id." 
            AND delivery_note_detail.deleted_at IS NULL
            AND invoice_sales_detail.item_variant_id = delivery_note_detail.item_variant_id "
            : 
            "SELECT SUM(sales_detail.quantity) 
            FROM sales_detail 
            JOIN sales ON sales.id = sales_detail.sales_id
            WHERE sales_detail.sales_id = ".$data->sales_id." 
            AND sales_detail.deleted_at IS NULL
            AND invoice_sales_detail.item_variant_id = sales_detail.item_variant_id "
           ) . '
        ) as quantity_total
        
            '))//quantity total adalah sum quantity dari headnya misalnya dari sales_detail.quantity 
            //dan quantity sum adalah jumlah quantity yang sudah digunakan di invoice
            
            ->leftJoin('invoice_sales', 'invoice_sales.id', '=', 'invoice_sales_detail.invoice_sales_id')
            ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'invoice_sales_detail.item_variant_id')
            ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
            ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
            ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
            ->where('invoice_sales_detail.invoice_sales_id', $id)
            ->groupBy('invoice_sales_detail.id','product_variants.name','product_variants.price','products.name','units.name')
            ->get();

            $invoices = InvoiceSales::where('sales_id', $data->sales_id)->get();
            $sumqty = [];

            foreach ($invoices as $invoice) {
                foreach ($invoice->detail as $row) {
                    $itemVariantId = $row->item_variant_id;

                    // Check if the item variant ID already exists in $sumqty
                    if (array_key_exists($itemVariantId, $sumqty)) {
                        // If it exists, add the quantity
                        $sumqty[$itemVariantId] += $row->quantity;
                    } else {
                        // If it doesn't exist, create a new entry
                        $sumqty[$itemVariantId] = $row->quantity;
                    }
                }
            }

            $company_id = getCompanyId();

            $settings = SettingCompany::where('company_id', $company_id)->get()->toArray();
            $settings = array_column($settings, 'value', 'name');

        return view("administrator.invoice_sales.detail", compact('data', 'data_detail', 'sumqty', 'settings'));
    }

    public function delete(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $id = $request->ix;
        $deletedBy = auth()->user() ? auth()->user()->id : '';

        $data = InvoiceSales::find($id);
        $data->deleted_by = $deletedBy;
        $data->update();
        
        $data_detail = InvoiceSalesDetail::where('invoice_sales_id',$id)->get();
        
        foreach ($data_detail as $detail) {
            $detail->deleted_by = $deletedBy;
            $detail->update();
            
            $detail->delete();
        }
        $data->delete();

        //Write log
        createLog(static::$module, __FUNCTION__, $request->ix);
        return response()->json([
            'success' => true
        ]);
    }
    
    public function deleteDetail(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data_detail = InvoiceSalesDetail::find($request->id);

        if ($data_detail) {
            // Simpan ID pengguna yang menghapus sebelum menghapus
            $deletedBy = auth()->user() ? auth()->user()->id : '';
            $data_detail->deleted_by = $deletedBy;
            $data_detail->update();

            // Hapus detail setelah update
            $data_detail->delete();

            // Write log
            createLog(static::$module, __FUNCTION__, $request->id);

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
    
    public function updateTotalPaymentAmount(Request $request)
    {
        $data_detail = InvoiceSalesDetail::where('id', $request->id)->withTrashed()->first();
        // dd($data_detail);
        
        if ($data_detail) {
            $data = InvoiceSales::where('id',$data_detail->invoice_sales_id)->first();
            // Simpan ID pengguna yang menghapus sebelum menghapus
            $data->update(['total_payment_amount' => $request->total_payment_amount]);

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
    
    function generateInvoiceSalesNumber() {
        $tahun = date('Y');
        $company_id = getCompanyId();
    
        // Mencari jumlah penjualan dalam satu tahun
        $nomorUrut = InvoiceSales::withTrashed()->whereYear('created_at', $tahun)->where('company_id', $company_id)->count() + 1;
    
        $kodeTertentu = 'INV/' . $company_id . '/' . $tahun . '/' . $nomorUrut;
    
        return $kodeTertentu;
    }


    public function getDataItemVariant(Request $request)
    {
        // dd($request);
        $query = ProductVariant::select(DB::raw('
        product_variants.id,
        product_variants.name as nama_item_variant,
        product_variants.price,
        products.name as nama_item,
        stock.stock,
        units.name as nama_unit,
        MIN(product_medias.data_file) as data_file
    '))
    ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
    ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
    ->leftJoin(DB::raw('stock'), 'stock.item_variant_id', '=', 'product_variants.id')
    ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'stock.warehouse_id')
    ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
    ->where("product_variants.status", 1)
    ->orderBy("stock.stock", "asc")
    ->groupByRaw('product_variants.id, product_variants.name, product_variants.price, products.name, stock.stock, units.name');

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
    
    public function getDataInvoiceSales(Request $request)
    {
        // dd($request);
        $query = InvoiceSales::select(DB::raw('invoice_sales.*'))
                    ->orderBy("invoice_sales.id", "asc");

        $company_id = getCompanyId();
        if ($company_id != 0) {
            $query->where('invoice_sales.company_id', $company_id);
        }
    
        $data = $query->get();

        if (!empty($request->id)) {
            $data = $data->where('id',$request->id)->first();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Data successfully',
            'data' => $data
        ]);
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
    
    public function getDataSales(Request $request)
    {
        $que = Sales::select(DB::raw('sales.*'))
            ->where("sales.customer_id", $request->customer_id)
            ->whereNotIn('sales.id', function ($query) {
                $query->select('sales_id')
                    ->from('delivery_note')
                    ->whereIn('id', function ($subquery) {
                        $subquery->select('delivery_note_id')
                            ->whereNull('deleted_at')
                            ->from('invoice_sales');
                    });
            })
            ->orderBy("sales.id", "asc");
            $company_id = getCompanyId();
            if ($company_id != 0) {
                $que->where('sales.company_id', $company_id);
            }
            $data = $que->get();

        // Filter out sales records where quantity is fulfilled
        $filteredData = $data->filter(function ($salesRecord) {
            return !$this->isQuantityFulfilled($salesRecord->id);
        });

        if (!empty($request->id)) {
            $filteredData = $filteredData->where('id', $request->id)->first();
        }

        return $filteredData;
    }

    function isQuantityFulfilled($sales_id){
        $deliveryNotes = InvoiceSales::where('sales_id', $sales_id)->with('detail')->get();
        $sales_detail = SalesDetail::with('master')->where('sales_id', $sales_id)->get();
        
        foreach ($sales_detail as $salesDetail) {
            $quantity_sales = $salesDetail->quantity;
            $item_variant_id = $salesDetail->item_variant_id;
            $quantity_delivery = 0;
    
            foreach ($deliveryNotes as $deliveryNote) {
                $deliveryNoteDetails = $deliveryNote->detail->where('item_variant_id', $item_variant_id)->first();
                if ($deliveryNoteDetails) {
                    $quantity_delivery += $deliveryNoteDetails->quantity;
                }
            }
    
            if ($quantity_sales !== $quantity_delivery) {
                return false;
            }
        }
    
        return true;
    }

    public function getDataSalesDetail(Request $request)
    {
        $data = SalesDetail::select(
            DB::raw('
                sales_detail.quantity, 
                sales_detail.total, 
                product_variants.id as item_variant_id, 
                product_variants.name as nama_item_variant, 
                product_variants.price, 
                products.name as nama_item, 
                units.name as nama_unit, 
                MIN(product_medias.data_file) as data_file,
                (SELECT SUM(quantity) 
                    FROM invoice_sales_detail 
                    JOIN invoice_sales ON invoice_sales.id = invoice_sales_detail.invoice_sales_id
                    WHERE invoice_sales_detail.item_variant_id = sales_detail.item_variant_id 
                    AND invoice_sales_detail.deleted_at IS NULL
                    AND invoice_sales.sales_id = ' . $request->sales_id . '
                ) as quantity_sum
            ')
        )
        ->leftJoin('product_variants', 'product_variants.id', '=', 'sales_detail.item_variant_id')
        ->leftJoin('products', 'products.id', '=', 'product_variants.product_id')
        ->leftJoin('product_medias', 'products.id', '=', 'product_medias.product_id')
        ->leftJoin('units', 'units.id', '=', 'product_variants.unit_id')
        ->where('sales_detail.sales_id', $request->sales_id)
        ->orderBy('sales_detail.id', 'asc')
        ->groupBy(
            'sales_detail.quantity',
            'sales_detail.total',
            'sales_detail.item_variant_id', // Add this line
            'sales_detail.id', // Add this line
            'product_variants.id',
            'product_variants.name',
            'product_variants.price',
            'products.name',
            'units.name'
        )
        ->get();    

        return $data;
    }

    
    public function getDataDeliveryNote(Request $request)
    {
        $que = DeliveryNote::select(DB::raw('delivery_note.*, sales.sales_number'))
            ->leftJoin('sales', 'sales.id', '=', 'delivery_note.sales_id')
            ->where('sales.customer_id', $request->customer_id)
            ->whereNotIn('delivery_note.sales_id', function ($query) {
                $query->select('sales_id')
                    ->whereNull('deleted_at')
                    ->from('invoice_sales');
            })
            ->orderBy('delivery_note.id', 'asc');
            
            $company_id = getCompanyId();
            if ($company_id != 0) {
                $que->where('delivery_note.company_id', $company_id);
            }
            $data = $que->get();

        // Filter out delivery notes where quantity is fulfilled
        $filteredData = $data->filter(function ($deliveryNote) {
            return !$this->isDelNoteQuantityFulfilled($deliveryNote->id);
        });

        if (!empty($request->id)) {
            $filteredData = $filteredData->where('id', $request->id)->first();
        }

        return $filteredData;
    }


    function isDelNoteQuantityFulfilled($delivery_note_id){
        $deliveryNotes = InvoiceSales::where('delivery_note_id', $delivery_note_id)->with('detail')->get();
        $delivery_note_detail = DeliveryNoteDetail::with('master')->where('delivery_note_id', $delivery_note_id)->get();
        
        foreach ($delivery_note_detail as $deliveryNoteDetail) {
            $quantity_delivery_note = $deliveryNoteDetail->quantity;
            $item_variant_id = $deliveryNoteDetail->item_variant_id;
            $quantity_delivery = 0;
    
            foreach ($deliveryNotes as $deliveryNote) {
                $deliveryNoteDetails = $deliveryNote->detail->where('item_variant_id', $item_variant_id)->first();
                if ($deliveryNoteDetails) {
                    $quantity_delivery += $deliveryNoteDetails->quantity;
                }
            }
    
            if ($quantity_delivery_note !== $quantity_delivery) {
                return false;
            }
        }
    
        return true;
    }


    public function getDataDeliveryNoteDetail(Request $request)
    {
        // dd($request);
        $data = DeliveryNoteDetail::select(DB::raw('
        delivery_note_detail.quantity, 
        product_variants.id as item_variant_id, 
        product_variants.name as nama_item_variant, 
        product_variants.price, 
        products.name as nama_item, 
        units.name as nama_unit, 
        MIN(product_medias.data_file) as data_file,
        (SELECT SUM(quantity) 
            FROM invoice_sales_detail 
            JOIN invoice_sales ON invoice_sales.id = invoice_sales_detail.invoice_sales_id
            WHERE invoice_sales_detail.item_variant_id = delivery_note_detail.item_variant_id 
            AND invoice_sales_detail.deleted_at IS NULL
            AND invoice_sales.delivery_note_id = ' . $request->delivery_note_id . '
        ) as quantity_sum
    '))
    ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'delivery_note_detail.item_variant_id')
    ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
    ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
    ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
    ->where("delivery_note_detail.delivery_note_id", $request->delivery_note_id)
    ->orderBy("delivery_note_detail.id", "asc")
    ->groupBy(
        'delivery_note_detail.item_variant_id',
        'delivery_note_detail.id',
        'delivery_note_detail.quantity',
        'product_variants.id',
        'product_variants.name',
        'product_variants.price',
        'products.name',
        'units.name'
    )
    ->get();


        return $data;
    }

    public function isExistInvoiceSalesNumber(Request $request){
        if($request->ajax()){
            $invoice_sales = InvoiceSales::select('*');
            if(isset($request->invoice_sales_number)){
                $invoice_sales->where('invoice_sales_number', $request->invoice_sales_number);
            }
            if(isset($request->id)){
                $invoice_sales->where('id', '<>', $request->id);
            }
            $data = [ 'valid' => ( $invoice_sales->count() == 0)  ];
            if(!empty($invoice_sales)){
                return $data;
            }else{
                return $data;
            }
        }
    }

    public function export(Request $request){
        // Check permission
        if (!isAllowed(static::$module, "export")) {
            abort(403);
        }
        
        $company_id = getCompanyId();
        $query = InvoiceSales::select(
            DB::raw('invoice_sales.*, customers.id as customer_id, customers.name as customer_name,  customers.address as customer_address,  customers.phone as customer_phone, sales.sales_number,
            delivery_note.delivery_note_number')
        )
        ->leftJoin('customers', 'customers.id', '=', 'invoice_sales.customer_id')
        ->leftJoin('sales', 'sales.id', '=', 'invoice_sales.sales_id')
        ->leftJoin('delivery_note', 'delivery_note.id', '=', 'invoice_sales.delivery_note_id');

        if ($company_id != 0) {
            $query->where('invoice_sales.company_id', $company_id);
        }

        if ($request->date || $request->customer_id || $request->typeInvoice) {
            $query = $query->where(function ($data_search) use ($request) {
                if($request->date != "") {
                    $start_date = '';
                    $tanggal = explode("-", $request->date);
                    $start_date = date('Y-m-d', strtotime($tanggal[0]));
                    $end_date = date('Y-m-d', strtotime($tanggal[1]));
                    $data_search = $data_search->whereBetween('invoice_sales.date', [$start_date, $end_date]);
                }
                if ($request->customer_id != "") {
                    $data_search->where("invoice_sales.customer_id", $request->customer_id);
                }
                if ($request->typeInvoice != "") {
                    if ($request->typeInvoice === 'sales') {
                        $data_search->where("invoice_sales.sales_id", '!=', 0);
                    }else{
                        $data_search->where("invoice_sales.delivery_note_id", '!=', 0);
                    }
                }
            });
        }

        $data = $query->get();


        $settings = SettingCompany::where('company_id', $company_id)->get()->toArray();
        $settings = array_column($settings, 'value', 'name');


        $pdf = PDF::loadView("administrator.invoice_sales.pdf.index", compact('data', 'settings'));
        return $pdf->stream('Recap of sales invoices - ' . now() . '.pdf');
    }
    
    public function exportDetail(Request $request){
        // Check permission
        ini_set('max_execution_time', 120);

        if (!isAllowed(static::$module, "export")) {
            abort(403);
        }

        $id = $request->id;

        $data = InvoiceSales::select(
            DB::raw('invoice_sales.*, customers.id as customer_id, customers.name as customer_name,  customers.address as customer_address,  customers.phone as customer_phone, sales.sales_number,
            delivery_note.delivery_note_number')
        )
        ->leftJoin('customers', 'customers.id', '=', 'invoice_sales.customer_id')
        ->leftJoin('sales', 'sales.id', '=', 'invoice_sales.sales_id')
        ->leftJoin('delivery_note', 'delivery_note.id', '=', 'invoice_sales.delivery_note_id')
        ->where('invoice_sales.id', $id)
        ->first();

        if (!$data) {
            return abort(404);
        }

        $data_detail = InvoiceSalesDetail::select(DB::raw('
        invoice_sales_detail.*, 
        invoice_sales_detail.id as id, 
        product_variants.name as nama_item_variant, 
        product_variants.price, 
        products.name as nama_item, 
        units.name as nama_unit, 
        MIN(product_medias.data_file) as data_file
    '))
    ->leftJoin('invoice_sales', 'invoice_sales.id', '=', 'invoice_sales_detail.invoice_sales_id')
    ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'invoice_sales_detail.item_variant_id')
    ->leftJoin(DB::raw('products'), 'products.id', '=', 'product_variants.product_id')
    ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
    ->leftJoin(DB::raw('units'), 'units.id', '=', 'product_variants.unit_id')
    ->where('invoice_sales_detail.invoice_sales_id', $id)
    ->groupBy('invoice_sales_detail.id', 'product_variants.name', 'products.name', 'units.name', 'product_variants.price') // Include product_variants.price in the GROUP BY clause
    ->get();


            $company_id = getCompanyId();

            $settings = SettingCompany::where('company_id', $company_id)->get()->toArray();
            $settings = array_column($settings, 'value', 'name');

        $pdf = PDF::loadView("administrator.invoice_sales.pdf.detail", compact('data', 'data_detail', 'settings'));
        return $pdf->stream('Detail Invoice Sales - ' . $data->invoice_sales_number . '.pdf');
    }
}
