<?php

namespace App\Http\Controllers\API;

use DB;
use Validator;
use App\Models\Orders;
use App\Models\Customers;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use App\Models\CustomerGroup;
use App\Models\OrderBillings;
use App\Models\CustomerOrders;
use App\Models\OrderShippings;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function customer(Request $request){
        $validator = Validator::make($request->all(),[
            'limit' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => $validator->errors()], 400);       
        }

        $query = Customers::select('customers.id','customers.name', 'customer_groups.name as customer_group_name')
        ->leftJoin(('customer_groups'), 'customer_groups.id', '=', 'customers.customer_group_id')
        ->orderBy('id', 'DESC');

        if (!empty($request->search)) {
    		$query->where('customers.name', 'LIKE', '%'.$request->search.'%')
            ->orWhere('customer_groups.name', 'LIKE', '%'.$request->search.'%');
    	}

        $customer = $query->paginate($request->limit);

        return response()->json([
            'status' => 200, 
            'message' => 'Data successfully',
            'data' => $customer,
        ], 200);
    }

    public function create_customer(Request $request){
        $customer_group = $request->input('customer_group_id');
        $name = $request->input('name');
        $email = $request->input('email');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $status = $request->input('status');
        $password = $request->input('password');

        $validator = Validator::make($request->all(),[
            'customer_group_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'status' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => $validator->errors()], 400);       
        }

        $customer = Customers::create([
            'customer_group_id' => $customer_group,
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'password' => Hash::make($password),
            'status' => $status,
        ]);

        return response()->json([
            'status' => 200, 
            'message' => 'Customer created successfully',
            'data' => $customer
        ]);
    }

    public function orders(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'limit' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => $validator->errors()], 400);       
        }

        $customer_id = false;
        if (isset(auth()->user()->id)) {
            $customer_id = auth()->user()->id;
            $query = Orders::select(DB::raw('orders.*, customers.name as customer_name, order_shippings.courier as courier, order_shippings.resi as resi, order_billings.payment_method as payment_method, order_billings.data as payment_data'))
                ->leftJoin(DB::raw('customers'), 'customers.id', '=', 'orders.customer_id')
                ->leftJoin(DB::raw('order_shippings'), 'order_shippings.order_id', '=', 'orders.id')
                ->leftJoin(DB::raw('order_billings'), 'order_billings.order_id', '=', 'orders.id');
            $query->orderBy('orders.created_at', 'DESC');
            if ($customer_id) {
                $query->where("orders.customer_id", $customer_id);
            }
            $orders = $query->paginate($request->limit);

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully',
                'data' => $orders,
            ], 200);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ], 401);
        }
    }

    public function orderDetail(Request $request, $invoice_number)
    {
        $customer_id = false;
        if (isset(auth()->user()->id)) {
            $customer_id = auth()->user()->id;
        }

        $order = Orders::select(DB::raw('orders.*, customers.name as customer_name, customers.phone as customer_phone'))
            ->leftJoin(DB::raw('customers'), 'customers.id', '=', 'orders.customer_id')
            ->where('orders.invoice_number', '=', $invoice_number);

        if ($customer_id) {
            $order->where("orders.customer_id", $customer_id);
        }

        $order = $order->first();

        if (!$order) {
            return response()->json([
                'status' => 404,
                'message' => 'Data not found',
            ], 404);
        }

        $order_billing = OrderBillings::select(DB::raw('*'))
            ->where('order_id', '=', $order->id)
            ->first();

        $order_shipping = OrderShippings::select(DB::raw('*'))
            ->where('order_id', '=', $order->id)
            ->first();

        $shipping = json_decode($order_shipping->address);

        if (isset($shipping)) {
            $store_name = $shipping[0]->store_name;
        } else {
            $store_name = null;
        }

        $order_items = OrderItems::select(DB::raw('order_items.*, products.name as product_name, products.brand_id as brand_id, product_variants.name as variant_name, product_variants.sku as sku, product_variants.price as price, product_variants.discount_price as discount_price'))
            ->leftJoin(DB::raw('products'), 'products.id', '=', 'order_items.product_id')
            ->leftJoin(DB::raw('product_variants'), 'product_variants.id', '=', 'order_items.product_variant_id')
            ->where('order_items.order_id', '=', $order->id)
            ->get();

        $discount_customer = [];
        if (isset(auth()->user()->id)) {
            $discount_customer = DB::table('customer_group_categories')
                ->where('customer_group_categories.customer_group_id', auth()->user()->customer_group_id)
                ->get()->toArray();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Data successfully',
            'data' => [
                'order' => $order,
                'order_billing' => $order_billing,
                'order_shipping' => $order_shipping,
                'order_items' => $order_items,
                'store_name' => $store_name,
                'discount_customer' => $discount_customer,
            ],
        ], 200);
    }

    public function orderTotal(Request $request)
    {
        $customer_id = auth()->user()->id;
        
        $query = Orders::select(DB::raw('orders.*, customers.name as customer_name, order_shippings.courier as courier, order_shippings.resi as resi, order_billings.payment_method as payment_method, order_billings.data as payment_data'))
            ->leftJoin(DB::raw('customers'), 'customers.id', '=', 'orders.customer_id')
            ->leftJoin(DB::raw('order_shippings'), 'order_shippings.order_id', '=', 'orders.id')
            ->leftJoin(DB::raw('order_billings'), 'order_billings.order_id', '=', 'orders.id');
        
        $query->orderBy('orders.created_at', 'DESC')
            ->where("orders.customer_id", $customer_id);

        if ($request->status) {
            $validStatuses = ['all', 'waiting_for_payment', 'processed', 'shipping', 'finished', 'complain'];

            if ($request->status === 'all') {
                // Do nothing, all statuses are included
            } elseif (in_array($request->status, $validStatuses)) {
                $query->where("orders.status", $request->status);
            } else {
                return response()->json(['status' => 404, 'message' => 'Bad request', 'errors' => 'Invalid status'], 404);
            }
        } else {
            return response()->json(['status' => 400, 'message' => 'Bad request', 'errors' => 'No status provided'], 400);
        }

        $total = $query->count(); 

        return response()->json([
            'status' => 200,
            'message' => 'Data successfully',
            'data' => $total,
        ], 200);
    }

}
