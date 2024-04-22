<?php

namespace App\Http\Controllers\API;

use DB;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Stock;
use App\Models\Orders;
use App\Models\Warehouse;
use App\Models\OrderItems;
use App\Events\OrderCreated;
use Illuminate\Http\Request;
use App\Models\OrderBillings;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;

class CheckOutController extends Controller
{
    public function create_order(Request $request){
        $validator = Validator::make($request->all(),[
            // 'user_id'                           => 'required',
            'sub_total'                         => 'required',
            'total'                             => 'required',
            'total_item'                        => 'required',
            'order_items'                       => 'required|array',
            'order_items.*.product_id'          => 'required',
            'order_items.*.product_variant_id'  => 'required',
            'order_items.*.quantity'            => 'required',
            'order_items.*.price'               => 'required',
            'order_items.*.grand_total'         => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => $validator->errors()], 400);       
        }

        $jenis_discount = $request->input('jenis_discount');
        $discount_order = $request->input('discount_order');
        $discount_price = $request->input('discount_price');

        if ($discount_order && !isset($jenis_discount)) {
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Jenis Discount not empty'], 400); 
        }
        if ($discount_price && !isset($discount_order)) {
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Discount Order not empty'], 400); 
        }
        if($jenis_discount && !isset($discount_order)) {
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Discount Order not empty'], 400); 
        }
        if($jenis_discount && !isset($discount_price)) {
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Discount Price not empty'], 400); 
        }

        $user = auth()->user();
        $code = User::select('users.*', 'stores.code AS code_cashier')
        ->leftJoin('stores', 'stores.id', '=', 'users.cashier')
        ->where('cashier', $user->cashier)->first();

        $prefix = "";
        $ref_no = $prefix;
        $ref_no .= ($code->code_cashier);
        $ref_no .= ("/");
        $ref_no .= date('Ymd/');

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
        $ref_no .= sprintf("%'.03d", $last_order);

        $order_item_data = $request->input('order_items');
        $transaction_date = Carbon::now('Asia/Jakarta');
        $orders = Orders::create([
            'transaction_date'          => date('Y-m-d H:i:s', strtotime($transaction_date)),
            'invoice_number'            => $ref_no,
            'status'                    => 'waiting_for_payment',
            'user_id'                   => auth()->user()->id,
            'jenis_discount'            => $jenis_discount,
            'discount_order'            => $discount_order,
            'discount_price'            => $discount_price,
            'sub_total'                 => $request->input('sub_total'),
            'total'                     => $request->input('total'),
            'tax'                       => $request->input('tax'),
            'customer_id'               => $request->input('customer_id'),
            'total_item'                => $request->input('total_item'),
            'store_id'                  => auth()->user()->cashier,
            'note'                      => $request->input('note'),
            'flag_pos'                  => true
        ]);

        $order_items = [];
        foreach($order_item_data as $order_item){
            if($order_item['discount_price'] && !isset($order_item['jenis_discount'])) {
                return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Jenis Discount not empty'], 400); 
            }
            if($order_item['discount_product'] && !isset($order_item['discount_price'])) {
                return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Discount Price not empty'], 400); 
            }
            if($order_item['jenis_discount'] && !isset($order_item['discount_price'])) {
                return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Discount Price not empty'], 400); 
            }
            if($order_item['jenis_discount'] && !isset($order_item['discount_product'])) {
                return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Discount Product not empty'], 400); 
            }

            $warehouse = User::select('users.*', 'stores.code AS code_cashier', 'store_detail.warehouse_id')
            ->leftJoin('stores', 'stores.id', '=', 'users.cashier')
            ->leftJoin('store_detail', 'store_detail.store_id', '=', 'stores.id')
            ->where('users.cashier', $user->cashier)->first();
            
            $order_items[] = OrderItems::create([
                'order_id'                  => $orders->id,
                'product_id'                => $order_item['product_id'],
                'product_variant_id'        => $order_item['product_variant_id'],
                'quantity'                  => $order_item['quantity'],
                'price'                     => $order_item['price'],
                'jenis_discount'            => $order_item['jenis_discount'],
                'discount_price'            => $order_item['discount_price'],
                'discount_product'          => $order_item['discount_product'],
                'grand_total'               => $order_item['grand_total']

            ]);

            $update_stock = Stock::where('warehouse_id', $warehouse->warehouse_id)
            ->where('item_variant_id', $order_item['product_variant_id'])->first();
            
            if(empty($update_stock->stock)){
                $stock_warehouse = 0;
            }else{
                $stock_warehouse = $update_stock->stock;
            }

            if(((float)$stock_warehouse) < ((float)$order_item['quantity'])){
                return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Empty Stock Product'], 400); 
            }
            
           

            $update_stock->update([
                "stock" => ((float)$update_stock->stock) - ((float)$order_item['quantity']),
            ]);


        }

        // $order_billings = OrderBillings::create([
        //     'order_id'                      => $orders->id,
        //     'status'                        => 'waiting_for_payment',
        //     'total_bayar'                   => '0',
        //     'change'                        => '0',
        //     'payment_method_id'             => '0',
        //     'payment_method_details_id'     => '0'
        // ]);

        $orders->order_items = $order_items;
        // $orders->order_billings = $order_billings;

        return response()->json([
            'status' => 200, 
            'message' => 'Orders created successfully',
            'data' => $orders
        ]);
    }

    //Marketplace
    public function create_order_marketplace(Request $request){
        $validator = Validator::make($request->all(),[
            // 'user_id'                           => 'required',
            'sub_total'                         => 'required',
            'total'                             => 'required',
            'total_item'                        => 'required',
            'old_total'                         => 'required',
            'company_id'                        => 'required',
            'order_items'                       => 'required|array',
            'order_items.*.product_id'          => 'required',
            'order_items.*.product_variant_id'  => 'required',
            'order_items.*.quantity'            => 'required',
            'order_items.*.price'               => 'required',
            'order_items.*.grand_total'         => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => $validator->errors()], 400);       
        }

        $jenis_discount = $request->input('jenis_discount');
        $discount_order = $request->input('discount_order');
        $discount_price = $request->input('discount_price');

        if ($discount_order && !isset($jenis_discount)) {
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Jenis Discount not empty'], 400); 
        }
        if ($discount_price && !isset($discount_order)) {
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Discount Order not empty'], 400); 
        }
        if($jenis_discount && !isset($discount_order)) {
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Discount Order not empty'], 400); 
        }
        if($jenis_discount && !isset($discount_price)) {
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Discount Price not empty'], 400); 
        }

        $warehouse_id = $request->input('warehouse_id');
        // dd($warehouse_id);

        $warehouse = Warehouse::select('warehouses.*', 'stores.code AS code_cashier', 'stores.id AS store_id')
        ->leftJoin('store_detail', 'store_detail.warehouse_id', '=', 'warehouses.id')
        ->leftJoin('stores', 'stores.id', '=', 'store_detail.store_id')
        ->where('warehouses.id', $warehouse_id)->first();

        // dd($warehouse);

        $prefix = "";
        $ref_no = $prefix;
        $ref_no .= ($warehouse->code_cashier);
        $ref_no .= ("/");
        $ref_no .= date('Ymd/');

        $yearmonth = date('Y-m-d');
        $trdate = date('Y-m-d H:i:s');
        $length = strlen($ref_no) + 1;
        $lengthEnd = $length - 1;
        $data = DB::table("orders")
        ->select(DB::raw("CAST(SUBSTRING(invoice_number FROM $length FOR LENGTH(invoice_number) - $lengthEnd) AS INTEGER) as last_order"))
        ->whereRaw("DATE_TRUNC('day', transaction_date) = '$yearmonth' AND invoice_number LIKE '$ref_no%'")
        ->orderBy(DB::raw("CAST(SUBSTRING(invoice_number FROM $length FOR LENGTH(invoice_number) - $lengthEnd) AS INTEGER)"), "DESC")
        ->first();
    
        if ($data) {
          $last = intval($data->last_order);
        } else {
          $last = 0;
        }
    
        $last_order = $last + 1;
        $ref_no .= sprintf("%'.03d", $last_order);

        $payment_due_at = Carbon::now()->addHours(24);

        $order_item_data = $request->input('order_items');
        $transaction_date = Carbon::now('Asia/Jakarta');
        $orders = Orders::create([
            'transaction_date'          => date('Y-m-d H:i:s', strtotime($transaction_date)),
            'invoice_number'            => $ref_no,
            'status'                    => 'waiting_for_payment',
            'user_id'                   => 0,
            'jenis_discount'            => $jenis_discount,
            'discount_order'            => $discount_order,
            'discount_price'            => $discount_price,
            'sub_total'                 => $request->input('sub_total'),
            'total'                     => $request->input('total'),
            'old_total'                 => $request->input('old_total'),
            'tax'                       => $request->input('tax'),
            'customer_id'               => auth()->user()->id,
            'total_item'                => $request->input('total_item'),
            'store_id'                  => $warehouse->store_id,
            'note'                      => $request->input('note'),
            'flag_pos'                  => false,
            'company_id'                => $request->input('company_id'),
            'payment_due_at'            => $payment_due_at
        ]);

        $order_items = [];
        foreach($order_item_data as $order_item){
            if($order_item['discount_price'] && !isset($order_item['jenis_discount'])) {
                return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Jenis Discount not empty'], 400); 
            }
            if($order_item['discount_product'] && !isset($order_item['discount_price'])) {
                return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Discount Price not empty'], 400); 
            }
            if($order_item['jenis_discount'] && !isset($order_item['discount_price'])) {
                return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Discount Price not empty'], 400); 
            }
            if($order_item['jenis_discount'] && !isset($order_item['discount_product'])) {
                return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Discount Product not empty'], 400); 
            }
            
            $order_items[] = OrderItems::create([
                'order_id'                  => $orders->id,
                'product_id'                => $order_item['product_id'],
                'product_variant_id'        => $order_item['product_variant_id'],
                'quantity'                  => $order_item['quantity'],
                'price'                     => $order_item['price'],
                'jenis_discount'            => $order_item['jenis_discount'],
                'discount_price'            => $order_item['discount_price'],
                'discount_product'          => $order_item['discount_product'],
                'grand_total'               => $order_item['grand_total']

            ]);

            // dd($warehouse);

            $update_stock = Stock::where('warehouse_id', $warehouse_id)
            ->where('item_variant_id', $order_item['product_variant_id'])->first();

            // dd($update_stock);
            
            if(empty($update_stock->stock)){
                $stock_warehouse = 0;
            }else{
                $stock_warehouse = $update_stock->stock;
            }

            if(((float)$stock_warehouse) < ((float)$order_item['quantity'])){
                return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Empty Stock Product'], 400); 
            }       

            $update_stock->update([
                "stock" => ((float)$update_stock->stock) - ((float)$order_item['quantity']),
            ]);


        }
        $orders->order_items = $order_items;

        return response()->json([
            'status' => 200, 
            'message' => 'Orders created successfully',
            'data' => $orders
        ]);
    }

   
}
