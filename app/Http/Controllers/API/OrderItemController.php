<?php

namespace App\Http\Controllers\API;

use App\Models\OrderItems;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Support\Facades\Validator;
use DB;

class OrderItemController extends Controller
{
    public function orderItem($id){
        // $orderItem = Orders::where('order_id', '=' , $request->order_id)
        // ->join('order_items', 'orders.id', '=', 'order_items.order_id')->with('order_id')
        // ->get(['transaction_date', 'product_id', 'product_variant_id', 'quantity', 'price', 'total', 'old_total']);

        $order = Orders::where('id', $id)->first();
        $orderItem = OrderItems::select("order_items.*", "products.name as product_name", "product_variants.name as variant_name")
            ->leftJoin("products", "products.id", "=", "order_items.product_id")
            ->leftJoin("product_variants", "product_variants.id", "=", "order_items.product_variant_id")
            ->where("order_items.order_id", $order->id)->get();

        $total = OrderItems::select(DB::raw('SUM(quantity * price) as total'))
        ->where('order_id', $order->id)
        ->groupBy('order_id')->first();

        return response()->json([
            'order' => $order,
            'items' => $orderItem,
            'total' => $total ? $total->total : 0
        ]);
    }

    public function addOrderItem(Request $request){
        $validator = Validator::make($request->all(),[
            'product_id' => 'required',
            'order_id' => 'required',
            'product_variant_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $order_items = OrderItems::firstOrNew([
            'order_id' =>  $request->order_id,
            'product_id' => $request->product_id,
            'product_variant_id' => $request->product_variant_id,
            // 'quantity' => $request->quantity,
            'price' => $request->price
        ]);

        $order_items->quantity += $request->quantity;

        $order_items->save();

        $items = OrderItems::select("order_items.*", "products.name as product_name", "product_variants.name as variant_name")
            ->leftJoin("products", "products.id", "=", "order_items.product_id")
            ->leftJoin("product_variants", "product_variants.id", "=", "order_items.product_variant_id")
            ->where("order_items.id", $order_items->id)->get();

        return response()->json([
            'order_items' => $items
        ]);

    }

    public function updateOrderItem($id, Request $request){
        $validator = Validator::make($request->all(),[
            'quantity' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }
        $orderItem=OrderItems::where('id',$id)->first();
        $orderItem->update([
            'quantity' => $request->quantity,

        ]);

        return response()->json([
            'order_items' => $orderItem
        ]);

    }

    public function deleteOrderItem($id, Request $request){
        
        $orderItem=OrderItems::where('id',$id)->first();
        $orderItem->delete();
            
        return response()->json([
            'status' => true
        ]);

    }
}
