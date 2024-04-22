<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\Setting;
use App\Models\OrderBillings;
use Validator;
use DB;



class OrderController extends Controller
{
    public function create_invoice_number(Request $request){

        $validator = Validator::make($request->all(),[
            'product_id' => 'required',
            'product_variant_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $prefix = "";
        $ref_no = $prefix;
        $ref_no .= date('Ymd');
    
        $yearmonth = date('Y-m-d');
        $trdate = date('Y-m-d H:i:s');
        $length = strlen($ref_no) + 1;
        $lengthEnd = $length - 1;
        $data = DB::table("orders")->select(DB::raw("CAST(substr(invoice_number, $length, LENGTH(invoice_number) - $lengthEnd) AS unsigned) as last_order"))
        ->whereRaw("DATE_FORMAT(transaction_date,'%Y-%m-%d')='$yearmonth' AND invoice_number LIKE '$ref_no%'")
        ->orderBy(DB::raw("CAST(substr(invoice_number, $length, LENGTH(invoice_number) - $lengthEnd) AS unsigned)"),"DESC")
        ->first();
    
        if ($data) {
          $last = intval($data->last_order);
        } else {
          $last = 0;
        }
    
        $last_order = $last + 1;
        $ref_no .= $last_order;

        $order = Orders::create([
            'invoice_number' => $ref_no,
            'transaction_date' => $trdate,
            'status' => 'waiting_for_payment',
            'total' => 0
        ]);

        if($order){
            $order_items = OrderItems::create([
                'order_id' => $order->id,
                'product_id' => $request->product_id,
                'product_variant_id' => $request->product_variant_id,
                'quantity' => $request->quantity,
                'price' => $request->price
            ]);
        }

        $items = OrderItems::select("order_items.*", "products.name as product_name", "product_variants.name as variant_name")
            ->leftJoin("products", "products.id", "=", "order_items.product_id")
            ->leftJoin("product_variants", "product_variants.id", "=", "order_items.product_variant_id")
            ->where("order_items.order_id", $order->id)->get();

        $total = OrderItems::select(DB::raw('SUM(quantity * price) as total'))
        ->where('order_id', $order->id)
        ->groupBy('order_id')->first();

        return response()->json([
            'order' => $order,
            'order_items' => $items,
            'total' => $total->total
        ]);
    }

    public function print_bill($id,Request $request){
        $validator = Validator::make($request->all(),[
            'total_bayar'       => 'required|numeric|min:1',
            'tax'               => 'required|numeric|min:1',
            'change'            => 'required|numeric|min:1',
            'total'             => 'required|numeric|min:1',
            'payment_method'    => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        
        $settings = Setting::get()->toArray();
        $settings = array_column($settings, 'value', 'name');
        $site_name=array_key_exists("site_name",$settings)?$settings["site_name"]:"" ;
        $site_alamat=array_key_exists("address",$settings)?$settings["address"]:"" ;
        $orderItem = OrderItems::where('order_id', $id)->get(['product_id', 'product_variant_id', 'quantity', 'price']);
        // $orderBillings = OrderBillings::where('order_id', $id)->first();
        
        $orders = Orders::where('id', $id)->first();
        $orders->Update([
            'tax'       => $request->tax,
            'total'     => $request->total,
            'status'    => 'finished'
        ]);
        $orderBillings = OrderBillings::updateOrCreate([
            'order_id' => $id,
            'total_bayar' => $request->total_bayar,
            'change' => $request->change,
            'payment_method' => $request->payment_method
        ]);

        $join = [
            'site_name' => $site_name,
            'site_alamat' => $site_alamat,
            'cashier' => auth()->user()->name,
            'invoice_number' => $orders->invoice_number,
            'transaction_date'=> $orders->transaction_date,
            'order_id' => $orderItem,
            'total' => $orders->total,
            'tax' => $orders->tax,
            'total_bayar' => $orderBillings->total_bayar,
            'change' => $orderBillings->change,
             
        ];

        return response()->json([
            'data' => $join
        ]);
    }
}
