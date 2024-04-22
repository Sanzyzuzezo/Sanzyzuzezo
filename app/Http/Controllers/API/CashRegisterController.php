<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashRegister;
use App\Models\Orders;
use App\Models\PaymentMethod;
use Validator;
use Carbon\Carbon;
use DB;

class CashRegisterController extends Controller
{
    public function open_register(Request $request){
        $validator = Validator::make($request->all(),[
            'cash_in_hand' => 'required|numeric|min:1',
        ]);
        if($validator->fails()){
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => $validator->errors()], 400);       
        }
        $user = auth()->user();

        $cash_register = CashRegister::where('user_id', $user->id)
        ->where('status', 'Open')
        ->first();
        
        if ($cash_register) {
            return response()->json(['status'=> 400, 'message' => 'There is already an open register'], 400); 
        }
        $cash_register = CashRegister::create([
            'user_id' => auth()->user()->id,
            'cash_in_hand' => $request->cash_in_hand,
            'status' => 'Open'
        ]);
        
        $cash_register->open_date = date('d-m-Y', strtotime($cash_register->created_at));

        return response()->json([
            "status" => 200,
            "message" => "Cash Register Open Successfully", 
            "data" => $cash_register]);
        
    }

    public function close_register($id, Request $request){
        $validator = Validator::make($request->all(),[
            'total_tunai' => 'required|numeric|min:1',
        ]);

        if($validator->fails()){
            return response()->json(['status'=> 400,'errors' => $validator->errors()], 400);       
        }
        $mytime = Carbon::now();
        $cash_register = CashRegister::where('id', $id)->first();
        if (!$cash_register) {
            return response()->json(['status'=> 404, 'message' => 'Register not found'], 404);  
        }

        // dd(auth()->user()->id);
        if(auth()->user()->id != $cash_register->user_id){
            return response()->json(['status'=> 404, 'message' => 'You have no acces to close'], 404);  
        }else{
            $cash_register->Update([
                'status' =>'Close',
                'total_tunai' => $request->total_tunai,
                'note' => $request->note,
                'closed_at'=> $mytime->toDateTimeString(),
            ]);
        }
        
        
        return response()->json([
        "status" => 200, 
        "message" =>"Cash Register Close Successfully", "data" => $cash_register]);
    }

    public function cash_register($id, Request $request) {
        $validator = Validator::make($request->all(),[
            'limit' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['status'=> 400,'errors' => $validator->errors()], 400);       
        }
        $cash_register = CashRegister::where('id', $id)->first();
        // dd(auth()->user());
        if (!$cash_register) {
            return response()->json(['status'=> 404, 'message' => 'Register not found'], 404);  
        }
        $payment_method = PaymentMethod::select(DB::raw("payment_methods.*, sum(order_billings.total_bayar - order_billings.change) as total_cash"))
        ->where([
            ['transaction_date', '>=',$cash_register->created_at],
            ['transaction_date', '>=', date('Y-m-d H:i:s')]
        ])->leftJoin('order_billings', 'payment_methods.id','=','order_billings.payment_method_id')
        ->leftJoin('orders', 'orders.id','=','order_billings.order_id')
        ->where('orders.cash_register_id', $cash_register->id)
        ->groupBy('payment_methods.id')->with(['PaymentMethodDetails' => function ($query) use ($cash_register){
            $query->select('payment_method_details.*', DB::raw('sum(order_billings.total_bayar - order_billings.change) as total_cash'))
            ->where([
            ['transaction_date', '>=',$cash_register->created_at],
            ['transaction_date', '>=', date('Y-m-d H:i:s')]
            ])->leftJoin('order_billings', 'payment_method_details.id','=','order_billings.payment_method_details_id')
            ->leftJoin('orders', 'orders.id','=','order_billings.order_id')
            ->where('cash_register_id', $cash_register->id)
            ->groupBy('payment_method_details.id');
        }])->get();

        $total_open_bill = Orders::select(DB::raw('sum(total) as total_open_bill'))
        ->where('orders.status','waiting_for_payment')
        ->where('store_id' ,auth()->user()->cashier)
        ->where([
            ['transaction_date', '>=',$cash_register->created_at],
            ['transaction_date', '>=', date('Y-m-d H:i:s')]
        ])
        ->first();
        $total_close_bill = Orders::select(DB::raw('sum(total) as total_close_bill'))
        ->where('orders.status','paid')
        ->where('store_id' ,auth()->user()->cashier)
        ->where([
            ['transaction_date', '>=',$cash_register->created_at],
            ['transaction_date', '>=', date('Y-m-d H:i:s')]
        ])
        ->first();
        
        // $total_cash = Orders::select(DB::raw('sum(order_billings.total_bayar - order_billings.change) as total_cash'))->where([
        //     ['orders.transaction_date', '>=',$cash_register->created_at],
        //     ['orders.transaction_date', '<=', date('Y-m-d H:i:s')],
        //     ['order_billings.payment_method_id', '=', '1']
        // ])->leftJoin('order_billings', 'orders.id','=','order_billings.order_id')->first();
        // 'total_cash' => $total_cash->total_cash ? $total_cash->total_cash : 0,

        // dd($payment_method);
        $join = [
            'cash_in_hand' => $cash_register ? $cash_register->cash_in_hand : 0,
            'pembayaran' => $payment_method,
            'total_open_bill'=> $total_open_bill->total_open_bill ? $total_open_bill->total_open_bill : 0,
            'total_close_bill'=> $total_close_bill->total_close_bill ? $total_close_bill->total_close_bill : 0,
            'total_penjualan'=> $total_open_bill->total_open_bill+=$total_close_bill->total_close_bill,
            'open_at' => $cash_register ? date('d-m-Y H:i:s', strtotime($cash_register->created_at)) : date('d-m-Y H:i:s'), 
            'closed_at' => $cash_register ? ( $cash_register->closed_at ? date('d-m-Y H:i:s', strtotime($cash_register->closed_at)) : date('d-m-Y H:i:s')) : date('d-m-Y H:i:s'), 
        ];
    
        // dd(auth()->user()->cashier);
        $open_bill = Orders::select('orders.id','orders.customer_id','orders.invoice_number','customers.name','orders.status','orders.transaction_date','orders.total')
        ->leftJoin('customers', 'customers.id', '=', 'orders.customer_id')
        ->where('orders.status','waiting_for_payment')->where('store_id', auth()->user()->cashier)->paginate($request->limit);
        return response()->json([
            "status" => 200,
            "message" => "You successfully completed loaded",
            "data" => $join, 
            "open_bill" => $open_bill,]);
    }
}

    

    

