<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Store;
use App\Models\Orders;
use App\Models\OrderItems;

class APIBiteShipController extends Controller
{
    private $url;
    private $token;

    public function __construct() {

        $this->url = 'https://api.biteship.com/v1';
        // $this->token = 'biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiU2Nob2tvLmlkIiwidXNlcklkIjoiNjMzMmRiZTI3YzA5ZDUxMzJiNGNkMzVlIiwiaWF0IjoxNjY0Mjc4NzcxfQ.HtHSgwCJLBdOM-PFsYrAZnnyjQXBlWSNOtunIWi-1xo';
        $this->token = 'biteship_test.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiVGVzdGluZyIsInVzZXJJZCI6IjYzN2RiZTI2NjI3Mzk3NzI4MWEyYTdkNiIsImlhdCI6MTY2OTE4NTI4NH0.tr-2Jq8LJViCBed7hUywwtovHfaTK0N3VARbcXCxCxY';
    }

    public function getCities(Request $request) {

        $data = City::where('province_id', $request->province_id)->get();
        return response()->json($data, 200);
    }

    public function getDistricts(Request $request) {

        $data = Kecamatan::where('city_id', $request->city_id)->get();
        return response()->json($data, 200);
    }

    public function couriers() {

        try {
            $url = $this->url."/couriers";

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
            curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);

            $headers = array(
                "authorization: ".$this->token,
                "content-type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);

            return $response;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }

    }

    public function getDestinations(Request $request) {

        // return $request;

        try {
            $url = $this->url."/maps/areas?countries=ID&input=".str_replace(' ', '+', $request->destination)."&type=double";

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
            curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);

            $headers = array(
                "authorization: ".$this->token,
                "content-type: application/json",
                'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
                'Connection: keep-alive',
                'Keep-Alive: 300',
                'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                'Accept-Language: en-us,en;q=0.5',
            );

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);

            return $response;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }

    }

    public function firstDestination(Request $request) {

        try {
            $url = $this->url."/maps/areas/".$request->id;

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
            curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);

            $headers = array(
                "authorization: ".$this->token,
                "content-type: application/json",
                'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
                'Connection: keep-alive',
                'Keep-Alive: 300',
                'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                'Accept-Language: en-us,en;q=0.5',
            );

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);

            return $response;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }

    }

    public function shippingCost(Request $request) {

        try {
            $url = $this->url."/rates/couriers";
            // return $request;
            $fields = (object) array(
                'origin_postal_code' => $request->origin_post_code,
                'destination_postal_code' => $request->destination_post_code,
                'couriers' => 'anteraja,jne,sicepat,grab,tiki,paxel,gojek',
                'items' => $request->items
            );

            $fields = json_encode($fields);

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);

            curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
            curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);

            $headers = array(
                "authorization: ".$this->token,
                "content-type: application/json",
                'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
                'Connection: keep-alive',
                'Keep-Alive: 300',
                'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                'Accept-Language: en-us,en;q=0.5',
            );

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);

            return $response;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function getOrigins(Request $request) {

        try {
            $url = $this->url."/locations";

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
            curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);

            $headers = array(
                "authorization: ".$this->token,
                "content-type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);

            return $response;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function detailOrigins($id) {

        try {
            $url = $this->url."/locations/".$id;

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
            curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);

            $headers = array(
                "authorization: ".$this->token,
                "content-type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);

            return $response;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    // HARUSNYA PAKE AUTHENTIKASI
    public function storeOrigins(Request $request) {

        try {
            $url = $this->url."/locations";

            $fields = (object) array (
                "name" => $request->name,
                "contact_name" => $request->contact_name,
                "contact_phone" => $request->contact_phone,
                "address" => $request->address,
                "note" => $request->subdistrict.'-'.$request->city.'-'.$request->province,
                "postal_code" => $request->postal_code
            );

            $fields = json_encode($fields);

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);

            curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
            curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);

            $headers = array(
                "authorization: ".$this->token,
                "content-type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);

            return $response;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

     // HARUSNYA PAKE AUTHENTIKASI
    public function updateOrigin(Request $request, $id) {

        try {
            $url = $this->url."/locations/".$request->id;

            $fields = (object) array (
                "id" => $request->id,
                "name" => $request->name,
                "contact_name" => $request->contact_name,
                "contact_phone" => $request->contact_phone,
                "address" => $request->address,
                "note" => $request->subdistrict.'-'.$request->city.'-'.$request->province,
                "postal_code" => $request->postal_code
            );

            $fields = json_encode($fields);

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);

            curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
            curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);

            $headers = array(
                "authorization: ".$this->token,
                "content-type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);

            return $response;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    // HARUSNYA PAKE AUTHENTIKASI
    public function deleteOrigin(Request $request) {

        // return Auth::user()->id;
        try {
            $url = $this->url."/locations/".$request->id;

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");

            curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
            curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);

            $headers = array(
                "authorization: ".$this->token,
                "content-type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);

            return $response;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function trackings(Request $request) {
        try {
            $url = $this->url."/trackings/$request->resi/couriers/$request->courier";

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
            curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);

            $headers = array(
                "authorization: ".$this->token,
                "content-type: application/json",
                'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
                'Connection: keep-alive',
                'Keep-Alive: 300',
                'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                'Accept-Language: en-us,en;q=0.5',
            );

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);

            return $response;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function createOrder($order_id) {

        try {
            $url = $this->url."/orders";

            $order_data = DB::table('orders')
                            ->select(
                                'orders.phone',
                                'orders.email',
                                'orders.customer_id',
                                'orders.invoice_number',
                                'orders.status',
                                'orders.name',
                                'orders.total',
                                'orders.note',
                                'orders.transaction_date',
                                'order_shippings.address as address',
                                'order_shippings.cost as cost',
                                'order_shippings.courier as courier',
                                'order_shippings.resi as resi',
                                'order_shippings.weight',
                                'order_shippings.service',
                                'order_shippings.dimensions',
                                'order_shippings.address',
                                'order_shippings.origin_address',
                            )
                            ->leftjoin('customers', 'customers.id', '=', 'orders.customer_id')
                            ->leftjoin('order_shippings', 'order_shippings.order_id', '=', 'orders.id')
                            ->leftjoin('order_billings', 'order_billings.order_id', '=', 'orders.id')
                            ->where('orders.id', '=', $order_id)
                            ->first();

            $shipping = json_decode($order_data->address);

            $order = Orders::with('items.product', 'items.variant')->where('id', $order_id)->first();

            $order_detail = array();
            foreach($order->items as $row){
                $dimensions = (array) json_decode($row->variant->dimensions);
                if(!empty($dimensions)){
                    $length = $dimensions["length"];
                    $width = $dimensions["width"];
                    $height = $dimensions["height"];
                }

                $item[] = [
                    "id" => $row->variant->sku,
                    "name" => $row->product->name,
                    "image" => "",
                    "description" => $row->variant->name,
                    "value" => $row->discount_price != null ? $row->discount_price : $row->price,
                    "quantity" => $row->quantity,
                    "height" => $height,
                    "length" => $length,
                    "weight" => $row->variant->weight,
                    "width" => $width
                ];
            }

            $origin_address = json_decode($order_data->origin_address, true);

            $fields = (object) array (
                "shipper_contact_phone" => $origin_address["origin_contact_phone"],
                "shipper_contact_email" => "chocolate@schoko.id",
                "shipper_organization" => $origin_address["name"],
                "origin_contact_name" => $origin_address["origin_contact_name"],
                "origin_contact_phone" => $origin_address["origin_contact_phone"],
                "origin_address" => $origin_address["origin_address"],
                "origin_note" => $origin_address["origin_note"],
                "origin_postal_code" => $origin_address["origin_postal_code"],
                "destination_contact_name" => $shipping[0]->reveived_name,
                "destination_contact_phone" => $order_data->phone,
                "destination_contact_email" => $order_data->email,
                "destination_address" => $shipping[0]->address,
                "destination_postal_code" => $shipping[0]->postalcode,
                "destination_note" => "-",
                "destination_cash_proof_of_delivery" => false,
                "courier_company" => $order_data->courier,
                "courier_type" => $order_data->service,
                "courier_service_type" => $order_data->service,
                "courier_insurance" => $order_data->cost,
                "delivery_type" => "now",
                "delivery_date" => date("Y-m-d"),
                "delivery_time" => date("h:i"),
                "order_note" => $order->note,
                "items" => $item
            );
            // return $fields;

            $fields = json_encode($fields);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);

            $headers = array(
                "authorization: ".$this->token,
                "content-type: application/json",
                'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
                'Connection: keep-alive',
                'Keep-Alive: 300',
                'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                'Accept-Language: en-us,en;q=0.5',
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);

            return $response;
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function orderHandler() {
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result);

        $order = OrderShippings::where('data', 'like', '%' . $result->order_id . '%')->first();
        $order_shipping_id = $order->id;

        if($result->event == "order.status" && $order_shipping_id != null){
            OrderShippings::where('id', $order_shipping_id)->update(['status' => $result->status, 'data_status' => $json_result]);
        }else if($result->event == "order.price" && $order_shipping_id != null){
            OrderShippings::where('id', $order_shipping_id)->update(['status' => $result->status, 'new_cost' => $result->price, 'data_price' => $json_result]);
        }else if($result->event == "order.waybill_id" && $order_shipping_id != null){
            OrderShippings::where('id', $order_shipping_id)->update(['new_resi' => $result->courier_waybill_id, 'data_waybill' => $json_result]);
        }
    }
}
