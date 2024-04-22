<?php

namespace App\Http\Controllers\API;

use Auth;
use Validator;
use App\Models\User;
use App\Models\Stock;
use App\Models\Orders;
use App\Models\Warehouse;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderTransactionController extends Controller
{
    public function order_detail($id){
        $order = Orders::select('orders.id', 
        'users.name AS user_name',
        'customers.name AS customer_orders_name',
        'orders.invoice_number',
        'orders.transaction_date',
        'orders.jenis_discount',
        'orders.discount_price',
        'orders.discount_order',
        'orders.status',
        'orders.tax',
        'orders.total',
        'orders.sub_total',
        'orders.total_item',
        'orders.note')
        ->leftJoin('customers', 'customers.id', '=', 'orders.customer_id')
        ->leftJoin('users', 'users.id', '=', 'orders.user_id')
        ->with(['OrderItems' => function ($query){
            $query->select('order_items.id','order_items.order_id', 'products.id', 'order_items.product_variant_id','products.name AS product_name', 'product_variants.name AS product_variant_name', 'order_items.quantity', 'order_items.price', 'order_items.jenis_discount' ,'order_items.discount_product', 'order_items.discount_price','order_items.grand_total')
            ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('product_variants', 'product_variants.id', '=', 'order_items.product_variant_id')
            ->with('Variants');
        }])
        ->with(['OrderBillings' => function ($query){
            $query->select('order_billings.id', 'order_billings.order_id', 'order_billings.status', 'order_billings.total_bayar', 'order_billings.change', 'payment_methods.name AS payment_method', 'payment_method_details.name AS payment_method_detail')
            ->leftJoin('payment_methods', 'payment_methods.id', '=', 'order_billings.payment_method_id')
            ->leftJoin('payment_method_details', 'payment_method_details.id', '=', 'order_billings.payment_method_details_id');
        }])
        ->where('orders.id', $id)->first();

        if (!$order) {
            return response()->json(['status'=> 404, 'message' => 'Order transaction not found'], 404); 
        }

        return response()->json([
            'status' => 200, 
            'message' => 'Orders successfully',
            'data' => $order
        ]);
    }

    public function order_list(Request $request){
        $validator = Validator::make($request->all(),[
            'limit' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $query = Orders::select('orders.id','orders.customer_id','customers.name','orders.invoice_number','orders.status','orders.transaction_date','orders.total')->where('flag_pos',1)->where('store_id' ,auth()->user()->cashier)
        // $query = Orders::select('orders.id','orders.customer_order_id','customer_orders.name','orders.invoice_number','orders.status','orders.transaction_date','orders.total')->where('flag_pos',1)
        ->leftJoin('customers', 'customers.id', '=', 'orders.customer_id');
        
    	if (!empty($request->search)) {
    		$query->where('invoice_number', 'LIKE', '%'.$request->search.'%');
    	}
        if (!empty($request->customer)) {
    		$query->where('customers.name', 'LIKE', '%'.$request->customer.'%');
    	}

        if(!empty($request->total == "")){
            $query->orderBy('orders.id', 'desc');
        }else if(!empty($request->total == "asc")){
            $query->orderBy('orders.total', 'asc');
        }else if (!empty($request->total == "desc")){
            $query->orderBy('orders.total', 'desc');
        }  
        
        if (!empty($request->start_date != "" && $request->end_date != "")){
            $query->whereDate('orders.transaction_date', '>=', date("Y-m-d", strtotime($request->start_date)))
            ->whereDate('orders.transaction_date', '<=', date("Y-m-d", strtotime($request->end_date)));
        }
        $order_total = $query->count();        
        $order = $query->paginate($request->limit);
        
        if (empty($order_total)) {
            return response()->json(['status'=> 404, 'message' => 'Order not found'], 404);
        }
        return response()->json([
            'status'=> 200,
            'message' => 'You successfully completed loaded.',
            'data' => $order,
            
        ]);
    }

    public function order_update(Request $request, $id){
        $user = auth()->user();

        $orders = Orders::where('id', $id)->first();
        if (!$orders) {
            return response()->json(['status'=> 500, 'message' => 'Order Transaction not found'], 500);  
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

        $orders->customer_id = $request->input('customer_id');
        $orders->jenis_discount = $jenis_discount;
        $orders->discount_order = $discount_order;
        $orders->discount_price = $discount_price;
        $orders->sub_total = $request->input('sub_total');
        $orders->total = $request->input('total');
        $orders->tax = $request->input('tax');
        $orders->total_item = $request->input('total_item');
        $orders->note = $request->input('note');
        $orders->updated_by = $user->id;
        $orders->save();

        $order_items = $request->input('order_items');
        $dont_delete_item = [];
        $items = [];
        foreach ($order_items as $order_item) {
            if (isset($order_item['id'])) {
                $item = OrderItems::where('order_id', $id)->where('id', $order_item['id'])->first();
                // dd($item);
                if (!$item) {
                    return response()->json(['status'=> 404, 'message' => 'Order items not found'], 404);  
                }
            }else{
                $item = new OrderItems();
                $item->order_id = $id;
            }

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
            
            $user = auth()->user();
            $warehouse = User::select('users.*', 'stores.code AS code_cashier', 'store_detail.warehouse_id')
            ->leftJoin('stores', 'stores.id', '=', 'users.cashier')
            ->leftJoin('store_detail', 'store_detail.store_id', '=', 'stores.id')
            ->where('users.cashier', $user->cashier)->first();

            $jumlah_stock = $item->quantity;
            $item->product_id = $order_item['product_id'];
            $item->product_variant_id = $order_item['product_variant_id'];
            $item->quantity = $order_item['quantity'];
            $item->price = $order_item['price'];
            $item->jenis_discount = $order_item['jenis_discount'];
            $item->discount_product = $order_item['discount_product'];
            $item->discount_price = $order_item['discount_price'];
            $item->grand_total = $order_item['grand_total'];
            $item->save();

            if(!empty($item->id)){
                $update_stock = Stock::where('warehouse_id', $warehouse->warehouse_id)
                ->where('item_variant_id', $order_item['product_variant_id'])->first();

                if(empty($update_stock->stock)){
                    $stock_warehouse = 0;
                }else{
                    $stock_warehouse = $update_stock->stock;
                }

                if(((float)$stock_warehouse + (float)$jumlah_stock) < ((float)$order_item['quantity'])){
                    return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Empty Stock Product'], 400); 
                }

                $update_stock->update([
                    "stock" => ((float)isset($update_stock->stock)) - ((float)$order_item['quantity']) + ((float)$jumlah_stock),
                ]);
            }else{
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

            $items[] = $item;
            $dont_delete_item[] = $item['id'];
        }
        
        $deleted_item = OrderItems::where('order_id', $id)->whereNotIn('id', $dont_delete_item)->get();

        foreach($deleted_item as $data){
            $update_stock = Stock::where('warehouse_id', $warehouse->warehouse_id)
            ->where('item_variant_id', $data->product_variant_id)->first();

            $update_stock->update([
                "stock" => ((float)$update_stock->stock) + ((float)$data->quantity),
            ]);

            $data->delete();
        }
        $orders->order_items = $items;

        return response()->json([
            'status' => 200, 
            'message' => 'Orders update successfully',
            'data' => $orders
        ]);
    }

    public function order_void(Request $request, $id){
        $orders = Orders::where('id', $id)->first();
        $user = auth()->user();

        if (!$orders) {
            return response()->json(['status'=> 500, 'message' => 'Order Transaction not found'], 500);  
        }

        $orders->status = "void";
        $orders->updated_by = $user->id;
        $orders->save();

        return response()->json([
            'status' => 200, 
            'message' => 'Orders update void successfully',
            'data' => $orders
        ]);
    }

    public function order_detail_marketplace($id){
        $order = Orders::select('orders.id', 
        // 'users.name AS user_name',
        'customers.name AS customer_orders_name',
        'orders.invoice_number',
        'orders.transaction_date',
        'orders.jenis_discount',
        'orders.discount_price',
        'orders.discount_order',
        'orders.status',
        'orders.tax',
        'orders.total',
        'orders.sub_total',
        'orders.total_item',
        'orders.note')
        ->leftJoin('customers', 'customers.id', '=', 'orders.customer_id')
        // ->leftJoin('users', 'users.id', '=', 'orders.user_id')
        ->with(['OrderItems' => function ($query){
            $query->select('order_items.id','order_items.order_id', 'products.id', 'order_items.product_variant_id','products.name AS product_name', 'product_variants.name AS product_variant_name', 'order_items.quantity', 'order_items.price', 'order_items.jenis_discount' ,'order_items.discount_product', 'order_items.discount_price','order_items.grand_total')
            ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('product_variants', 'product_variants.id', '=', 'order_items.product_variant_id')
            ->with('Variants');
        }])
        ->with(['OrderBillings' => function ($query){
            $query->select('order_billings.id', 'order_billings.order_id', 'order_billings.status', 'order_billings.total_bayar', 'order_billings.change', 'payment_methods.name AS payment_method', 'payment_method_details.name AS payment_method_detail')
            ->leftJoin('payment_methods', 'payment_methods.id', '=', 'order_billings.payment_method_id')
            ->leftJoin('payment_method_details', 'payment_method_details.id', '=', 'order_billings.payment_method_details_id');
        }])
        ->where('orders.id', $id)->first();

        if (!$order) {
            return response()->json(['status'=> 404, 'message' => 'Order transaction not found'], 404); 
        }

        return response()->json([
            'status' => 200, 
            'message' => 'Orders successfully',
            'data' => $order
        ]);
    }

    public function order_list_marketplace(Request $request){
        $validator = Validator::make($request->all(),[
            'limit' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $warehouse_id = $request->input('warehouse_id');
        $warehouse = Warehouse::select('warehouses.*', 'stores.code AS code_cashier', 'stores.id AS store_id')
        ->leftJoin('store_detail', 'store_detail.warehouse_id', '=', 'warehouses.id')
        ->leftJoin('stores', 'stores.id', '=', 'store_detail.store_id')
        ->where('warehouses.id', $warehouse_id)->first();

        $query = Orders::select('orders.id','orders.customer_id','customers.name','orders.invoice_number','orders.status','orders.transaction_date','orders.total')->where('flag_pos',0)->where('store_id' ,$warehouse->store_id)
        ->leftJoin('customers', 'customers.id', '=', 'orders.customer_id');
        
    	if (!empty($request->search)) {
    		$query->where('invoice_number', 'LIKE', '%'.$request->search.'%');
    	}
        if (!empty($request->customer)) {
    		$query->where('customers.name', 'LIKE', '%'.$request->customer.'%');
    	}

        if(!empty($request->total == "")){
            $query->orderBy('orders.id', 'desc');
        }else if(!empty($request->total == "asc")){
            $query->orderBy('orders.total', 'asc');
        }else if (!empty($request->total == "desc")){
            $query->orderBy('orders.total', 'desc');
        }  
        
        if (!empty($request->start_date != "" && $request->end_date != "")){
            $query->whereDate('orders.transaction_date', '>=', date("Y-m-d", strtotime($request->start_date)))
            ->whereDate('orders.transaction_date', '<=', date("Y-m-d", strtotime($request->end_date)));
        }
        $order_total = $query->count();        
        $order = $query->paginate($request->limit);
        
        if (empty($order_total)) {
            return response()->json(['status'=> 404, 'message' => 'Order not found'], 404);
        }
        return response()->json([
            'status'=> 200,
            'message' => 'You successfully completed loaded.',
            'data' => $order,
            
        ]);
    }

    public function order_update_marketplace(Request $request, $id) {
        $user = auth()->user();

        $orders = Orders::where('id', $id)->first();
        if (!$orders) {
            return response()->json(['status'=> 500, 'message' => 'Order Transaction not found'], 500);  
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

        // $orders->customer_id = $request->input('customer_id');
        $orders->jenis_discount = $jenis_discount;
        $orders->discount_order = $discount_order;
        $orders->discount_price = $discount_price;
        $orders->sub_total = $request->input('sub_total');
        $orders->total = $request->input('total');
        $orders->old_total = $request->input('old_total');
        $orders->tax = $request->input('tax');
        $orders->total_item = $request->input('total_item');
        $orders->note = $request->input('note');
        $orders->updated_by = $user->id;
        $orders->save();

        $order_items = $request->input('order_items');
        $dont_delete_item = [];
        $items = [];
        foreach ($order_items as $order_item) {
            if (isset($order_item['id'])) {
                $item = OrderItems::where('order_id', $id)->where('id', $order_item['id'])->first();
                // dd($item);
                if (!$item) {
                    return response()->json(['status'=> 404, 'message' => 'Order items not found'], 404);  
                }
            }else{
                $item = new OrderItems();
                $item->order_id = $id;
            }

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
            
            $warehouse_id = $request->input('warehouse_id');
            // dd($warehouse_id);
    
            $warehouse = Warehouse::select('warehouses.*', 'stores.code AS code_cashier', 'stores.id AS store_id')
            ->leftJoin('store_detail', 'store_detail.warehouse_id', '=', 'warehouses.id')
            ->leftJoin('stores', 'stores.id', '=', 'store_detail.store_id')
            ->where('warehouses.id', $warehouse_id)->first();

            $jumlah_stock = $item->quantity;
            $item->product_id = $order_item['product_id'];
            $item->product_variant_id = $order_item['product_variant_id'];
            $item->quantity = $order_item['quantity'];
            $item->price = $order_item['price'];
            $item->jenis_discount = $order_item['jenis_discount'];
            $item->discount_product = $order_item['discount_product'];
            $item->discount_price = $order_item['discount_price'];
            $item->grand_total = $order_item['grand_total'];
            

            if(!empty($item->id)){
                $update_stock = Stock::where('warehouse_id', $warehouse_id)
                ->where('item_variant_id', $order_item['product_variant_id'])->first();

                if(empty($update_stock->stock)){
                    $stock_warehouse = 0;
                }else{
                    $stock_warehouse = $update_stock->stock;
                }
                
                // dd(((float)$stock_warehouse + (float)$jumlah_stock) - (float)$order_item['quantity']);
                if(((float)$stock_warehouse + (float)$jumlah_stock) < ((float)$order_item['quantity'])){
                    return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Empty Stock Product'], 400); 
                }
                
                if (((float)$stock_warehouse - (float)$order_item['quantity'] < 0)) {
                    return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => 'Empty Stock Product'], 400);
                }

                $update_stock->update([
                    "stock" => ((float)($stock_warehouse)) + ((float)$jumlah_stock) - ((float)$order_item['quantity']),
                ]);
                // dd($update_stock);
            }else{
                $update_stock = Stock::where('warehouse_id', $warehouse_id)
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

            $item->save();
            $items[] = $item;
            $dont_delete_item[] = $item['id'];
        }
        
        $deleted_item = OrderItems::where('order_id', $id)->whereNotIn('id', $dont_delete_item)->get();

        foreach($deleted_item as $data){
            $update_stock = Stock::where('warehouse_id', $warehouse_id)
            ->where('item_variant_id', $data->product_variant_id)->first();

            $update_stock->update([
                "stock" => ((float)$update_stock->stock) + ((float)$data->quantity),
            ]);

            $data->delete();
        }
        $orders->order_items = $items;

        return response()->json([
            'status' => 200, 
            'message' => 'Orders update successfully',
            'data' => $orders
        ]);
    } 

}