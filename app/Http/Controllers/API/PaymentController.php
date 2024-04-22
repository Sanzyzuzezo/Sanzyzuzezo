<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\CashRegister;
use Illuminate\Http\Request;
use App\Models\OrderBillings;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function create_payment(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'order_billings.total_bayar'        => 'required',
            'order_billings.change'             => 'required',
            'order_billings.payment_method_id'  => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => $validator->errors()], 400);       
        }

        $orders = Orders::where('id', $id)->first();
        if (!$orders) {
            return response()->json(['status'=> 404, 'message' => 'Order Transaction not found'], 404);  
        }
        $cash_register = CashRegister::where('user_id', auth()->user()->id)->where('status', 'Open')->first();
        if (!$cash_register) {
            return response()->json(['status'=> 404, 'message' => 'Cash Register is close'], 404);  
        }
        $orders->status = 'paid';
        $orders->cash_register_id = $cash_register->id;
        $orders->save();
        // $orders->total = $request->input('total');
        // $orders->tax = $request->input('tax');
        // $orders->note = $request->input('note');
        // $orders->user_id = $request->input('user_id');
        // $orders->customer_id = $request->input('customer_id');
        // $orders->sub_total = $request->input('sub_total');
        // $orders->discount_order = $request->input('discount_order');
        // $orders->total_item = $request->input('total_item');

        $order_billings_data = $request->input('order_billings');
        $order_billings = OrderBillings::create([
            'order_id'                      => $orders->id,
            'status'                        => 'paid',
            'total_bayar'                   => $order_billings_data['total_bayar'],
            'change'                        => $order_billings_data['change'],
            'payment_method_id'             => $order_billings_data['payment_method_id'],
            'payment_method_details_id'     => $order_billings_data['payment_method_details_id'],
        ]);

        $orders->order_billings = $order_billings;

        return response()->json([
            'status' => 200, 
            'message' => 'Payment save successfully',
            'data' => $orders
        ], 200);
    }

    public function update_payment(Request $request, $id){
        $order_billing = OrderBillings::where('order_id', $id)->first();

        if (!$order_billing) {
            return response()->json(['status'=> 404, 'message' => 'Order billing not found'], 404);  
        }

        $orders = Orders::with('OrderBillings')->where('id', $id)->first();
        $orders->status = 'paid';
        // $orders->total = $request->input('total');
        // $orders->tax = $request->input('tax');
        // $orders->note = $request->input('note');
        // $orders->user_id = $request->input('user_id');
        // $orders->customer_id = $request->input('customer_id');
        // $orders->sub_total = $request->input('sub_total');
        // $orders->discount_order = $request->input('discount_order');
        // $orders->total_item = $request->input('total_item');
        $orders->OrderBillings->order_id = $id;
        $orders->OrderBillings->total_bayar = $request->input('order_billings.total_bayar');
        $orders->OrderBillings->change = $request->input('order_billings.change');
        $orders->OrderBillings->payment_method_id = $request->input('order_billings.payment_method_id');
        $orders->OrderBillings->payment_method_details_id = $request->input('order_billings.payment_method_details_id');
        $orders->save();
        $orders->OrderBillings->save();
        

        return response()->json([
            'status' => 200, 
            'message' => 'Payment update successfully',
            'data' => $orders
        ], 200);
    }

    public function create_payment_marketplace(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'order_billings.*.total_bayar'        => 'required',
            'order_billings.*.change'             => 'required',
            'order_billings.*.payment_method_id'  => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => $validator->errors()], 400);       
        }

        $orders = Orders::where('id', $id)->first();
        if (!$orders) {
            return response()->json(['status'=> 404, 'message' => 'Order Transaction not found'], 404);  
        }
      
        $orders->status = 'paid';
        $orders->$id;
        $orders->save();
      
        $order_billings_data = $request->input('order_billings')[0];
        $order_billings = OrderBillings::create([
            'order_id'                      => $orders->id,
            'status'                        => 'paid',
            'total_bayar'                   => $order_billings_data['total_bayar'],
            'data'                          => $order_billings_data['data'],
            'change'                        => $order_billings_data['change'],
            'payment_method'                => $order_billings_data['payment_method'],
            'payment_method_id'             => $order_billings_data['payment_method_id'],
            'payment_method_details_id'     => $order_billings_data['payment_method_details_id'],
        ]);

        $orders->order_billings = $order_billings;

        return response()->json([
            'status' => 200, 
            'message' => 'Payment save successfully',
            'data' => $orders
        ], 200);
    }

    public function update_payment_marketplace(Request $request, $id){
        $order_billing = OrderBillings::where('order_id', $id)->first();

        if (!$order_billing) {
            return response()->json(['status'=> 404, 'message' => 'Order billing not found'], 404);  
        }

        $orders = Orders::with('OrderBillings')->where('id', $id)->first();
        $orders->status = 'paid';
        $order_billings_data = $request->input('order_billings')[0];

        // Perbarui nilai pada objek OrderBillings
        $order_billing->total_bayar = $order_billings_data['total_bayar'];
        $order_billing->data = $order_billings_data['data'];
        $order_billing->change = $order_billings_data['change'];
        $order_billing->payment_method = $order_billings_data['payment_method'];
        $order_billing->payment_method_id = $order_billings_data['payment_method_id'];
        $order_billing->payment_method_details_id = $order_billings_data['payment_method_details_id'];
    
        // Simpan perubahan pada objek OrderBillings
        $order_billing->save();
    
        // Simpan perubahan pada objek Orders
        $orders->save();
        

        return response()->json([
            'status' => 200, 
            'message' => 'Payment update successfully',
            'data' => $orders
        ], 200);
    }

}
