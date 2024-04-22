<?php

namespace App\Http\Controllers\Frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Orders;
use App\Models\OrderBillings;
use App\Models\OrderShippings;
use App\Models\OrderItems;
use App\Models\Customers;
use Image;
use File;
use DB;

class CustomerController extends Controller
{

    public function orders(Request $request)
    {
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
            $orders = $query->paginate(10);

            if ($request->ajax()) {
                return view('frontpage-schoko.customers.order_list', compact("orders"))->render();
            }

            return view("frontpage-schoko.customers.order_history", compact("orders"));
        } else {
            abort(403);
        }
    }

    public function orderDetail(Request $request)
    {
        $customer_id = false;
        if (isset(auth()->user()->id)) {
            $customer_id = auth()->user()->id;
        }

        $order = Orders::select(DB::raw('orders.*, customers.name as customer_name, customers.phone as customer_phone'))
            ->leftJoin(DB::raw('customers'), 'customers.id', '=', 'orders.customer_id')
            ->where('orders.invoice_number', '=', $request->invoice_number);

        if ($customer_id) {
            $order->where("orders.customer_id", $customer_id);
        }

        $order = $order->first();

        if (!$order) {
            return abort(404);
        }

        $order_billing = OrderBillings::select(DB::raw('*'))
            ->where('order_id', '=', $order->id)
            ->first();

        $order_shipping = OrderShippings::select(DB::raw('*'))
            ->where('order_id', '=', $order->id)
            ->first();

        $shipping = json_decode($order_shipping->address);

        $store_name = $shipping[0]->store_name;

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

        return view("frontpage-schoko.customers.order_history_detail", compact("order", "order_billing", "order_shipping", "order_items", "store_name", "discount_customer"));
    }

    public function paymentConfirmation(Request $request)
    {
        $this->validate($request, [
            'file_attachment' => 'required'
        ]);

        $id = $request->id;

        $order = Orders::select(DB::raw('orders.*, customers.name as customer_name'))
            ->leftJoin(DB::raw('customers'), 'customers.id', '=', 'orders.customer_id')
            ->where('orders.id', '=', $id);

        $order = $order->first();

        $order_billing = OrderBillings::select(DB::raw('order_billings.*'))
            ->where('order_id', '=', $id)
            ->first();

        $billing = (array) json_decode($order_billing->data);

        if (!is_array($billing)) {
            $billing = array();
        }
        //dd($order);

        if ($request->hasFile('file_attachment')) {
            $image = $request->file('file_attachment');
            $fileName  = $order->invoice_number . '.' . $image->getClientOriginalExtension();
            $path = upload_path('payment_confirmation') . $fileName;
            Image::make($image->getRealPath())->save($path, 100);
            $billing['file_attachment'] = $fileName;
        }

        $data["data"] = json_encode($billing);

        $order_billing = OrderBillings::where("order_id", $order->id)->update($data);

        //Update order status to waiting for confirmation
        $data_order = array("status" => "waiting_for_confirmation");
        Orders::where("id", $order->id)->update($data_order);

        return redirect()->route('order_history_detail', $order->invoice_number);
    }
}
