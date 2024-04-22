<?php

namespace App\Http\Controllers\Frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use App\Models\Product;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\OrderShippings;
use App\Models\OrderBillings;
use App\Models\ProductVariant;
use App\Models\BankAccount;
use App\Models\Province;
use App\Models\City;
use App\Models\CustomerAddress;
use App\Service\ServiceRajaOngkir;
use App\Models\Courier;
use App\Models\ServiceCourier;
use Illuminate\Support\Facades\Cookie;
use App\Models\Setting;
use App\Models\Store;
use DB;
use App\Service\Midtrans\CreateSnapTokenService;
use Midtrans\Notification;
use Midtrans\Config;
use Mail;
use App\Mail\OrderMail;
use App\Models\Cart;

class CheckoutController extends Controller
{

  public function index()
  {
    $cookie_data = stripslashes(Cookie::get('shopping_order'));

    if ($cookie_data != null) {
      $cart_data = json_decode($cookie_data, true);
      $product_id_list = array_column($cart_data, 'variant_id');
    } else {
      $product_id_list = [];
      $cart_data = null;
    }

    $products = Product::select(DB::raw('products.*, product_medias.data_file as image, product_variants.id as variant_id, product_variants.weight as berat_produk,  product_variants.name as variant, product_variants.price as price, product_variants.weight as weight, product_variants.dimensions as dimensions, product_variants.discount_price as discount_price'))
      ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
      ->leftJoin(DB::raw('product_variants'), 'products.id', '=', 'product_variants.product_id')
      ->whereIn('product_variants.id', $product_id_list)
      ->groupBy('product_variants.id')
      ->orderBy('products.id', 'ASC')
      ->get();

    $bank_accounts = BankAccount::where("bank_accounts.status", 1)->get();
    $provinces = Province::get();
    $addresses = '';
    $couriers = Courier::get();
    $origins = Store::where('status', true)->get();

    // return $products;
    $discount_customer = [];
    if (isset(auth()->user()->id)) {
        $addresses = CustomerAddress::where('customer_addresses.customer_id', auth()->user()->id)
        ->join('provinces', 'provinces.province_id', '=', 'customer_addresses.province_id')
        ->join('cities', 'cities.city_id', '=', 'customer_addresses.city_id')
        ->join('kecamatans', 'kecamatans.subdistrict_id', '=', 'customer_addresses.subdistrict_id')
        ->join('customers', 'customers.id', '=', 'customer_addresses.customer_id')
        ->select(
            'customer_addresses.*',
            'provinces.title AS nama_provinsi',
            'provinces.province_id AS id_provinsi',
            'cities.title AS nama_kota',
            'cities.city_id AS id_kota',
            'cities.type AS type_kota',
            'kecamatans.title AS nama_kecamatan',
            'kecamatans.subdistrict_id AS id_kecamatan',
            'customers.name AS nama_customer',
            'customers.email AS email_customer')
        ->orderBy('customer_addresses.active', 'DESC')
        ->get();

        $discount_customer = DB::table('customer_group_categories')
        ->where('customer_group_categories.customer_group_id', auth()->user()->customer_group_id)
        ->get()->toArray();
    }

    return view("frontpage-schoko.checkout")->with([
        'cart_data' => $products,
        'quantity' => $cart_data,
        'bank_accounts' => $bank_accounts,
        'provinces' => $provinces,
        'addresses' => $addresses,
        'couriers' => $couriers,
        'origins' => $origins,
        'discount_customer' => $discount_customer
    ]);
  }

  public function order(Request $request) {
    if (isset(auth()->user()->id)) {
        $customer_id = auth()->user()->id;
    } else {
        $customer_id = null;
    }

    $data_order = Orders::create([
    //   'id' => $order_id,
      'customer_id' => $customer_id,
      'name' => $request->customer_name,
      'email' => $request->customer_email,
      'phone' => $request->customer_phone_number,
      'invoice_number' => $this->generate(),
      'status' => 'waiting_for_payment',
      'note' => $request->order_noted,
      'total' => $request->order_total,
      'old_total' => $request->old_subtotal,
      'transaction_date' => now()
    ]);

    $item_array = array(
      'reveived_name' => $request->customer_name,
      'address' => $request->customer_address,
      'province' => $request->shipping_province_label,
      'city' => $request->shipping_city_label,
      'distric' => $request->shipping_distric_label,
      'postalcode' => $request->postalcode,
      'store_name' => $request->store_name
    );
    $address_data[] = $item_array;

    $address = json_encode($address_data);

    $sum_weight = 0;
    $length = 0;
    $width = 0;
    $height = 0;

    foreach ($request->item as $item) {
        $weight = $item['weight']*$item['quantity'];
        $sum_weight += $weight;

        $dimensions = (array) json_decode($item['dimensions']);
        if(!empty($dimensions)){
            $length += (int)$dimensions["length"]*$item['quantity'];
            $width += (int)$dimensions["width"]*$item['quantity'];
            $height += (int)$dimensions["height"]*$item['quantity'];
        }
    }

    $shipping_service = 'internal-courier';

    if(isset($request->shipping_service) && $request->shipping_service !== ""){
        $shipping_service = $request->shipping_service;
    }

    OrderShippings::create([
      'order_id' => $data_order->id,
      'address' => $address,
      'type' => '',
      'courier' => $request->shipping_courier,
      'service' => $shipping_service,
      'weight' => $sum_weight,
      'dimensions' => json_encode(["length" => $length, "width" =>$width, "height" => $height]),
      'distance' => '',
      'cost' => $request->shipping_cost
    ]);

    if (isset(auth()->user()->id)) {  
      foreach ($request->item as $item) {
          OrderItems::create([
              'order_id' => $data_order->id,
              'product_id' => $item['product_id'],
              'product_variant_id' => $item['variant_id'],
              'quantity' => $item['quantity'],
              'price' => $item['price'],
              'noted' => $item['note'],
          ]);
  
          $variant_id = $item['variant_id'];
          $cart_id = Cart::where('product_variant_id', $variant_id)->where('customer_id', auth()->user()->id)->get('id')->first();
          Cart::destroy($cart_id->id);
      }
    }else{
      $cookie_data = stripslashes(Cookie::get('shopping_cart'));
      $cart_data = json_decode($cookie_data, true);
  
      foreach ($request->item as $item) {
          OrderItems::create([
              'order_id' => $data_order->id,
              'product_id' => $item['product_id'],
              'product_variant_id' => $item['variant_id'],
              'quantity' => $item['quantity'],
              'price' => $item['price'],
              'noted' => $item['note'],
          ]);
  
          $variant_id = $item['variant_id'];
          unset($cart_data[$variant_id]);
      }
  
      $item_data = json_encode($cart_data);
      $minutes = 60;
      Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes, "/"));  
    }

    $billing = [];
    $snapToken = "";
    if ($request->payment_method != "manual_bank_transfer") {
      $midtrans = new CreateSnapTokenService($data_order);
      $snapToken = $midtrans->getSnapToken();
      $billing['snap_token'] = $snapToken;
    } else {
      $bank_account = $request->bank_account;
      $bank_account = BankAccount::find($bank_account);
      $billing["bank_name"] = $bank_account->bank_name;
      $billing["account_number"] = $bank_account->account_number;
      $billing["account_owner"] = $bank_account->account_owner;
      $snapToken = $data_order->invoice_number;
    }

    $data_billing = json_encode($billing);


    OrderBillings::create([
      'order_id' => $data_order->id,
      'payment_method' => $request->payment_method,
      'status' => "pending",
      'information' => "Waiting for Payment",
      'data' => $data_billing,
    ]);

    if (Cookie::get('shopping_order')) {
        Cookie::queue(Cookie::forget("shopping_order"));
    }

    if ($snapToken != "") {
        $this->updateStock($request->item);
        $message = ' Pesanan dengan Order No '. $snapToken . ' Telah diterima, harap cek di bagian order untuk proses berikutnya! ';
        // $this->sendEmail($message);
        return response()->json($snapToken);
    }
  }

    private function updateStock($items) {
        foreach ($items as $item) {
            $data = [];
            $variant = ProductVariant::find($item['variant_id']);
            $data['stock'] = $variant->stock - $item['quantity'];
            $variant->update($data);
        }
    }

    private function sendEmail($message = '') {

        $list_email = Setting::where("name", "email_receive")->first();
        if ($list_email) {
            $list_email = json_decode($list_email->value);
            foreach ($list_email as $email) {
                $toEmail = $email->email;
                $data    = [
                    "message" => 'Hallo '. $email->name . $message,
                    "link" => url('admin/orders')
                ];
                Mail::to($toEmail)->send(new OrderMail($data));
            }
        }
    }

  public function generate()
  {
    $prefix = "";
    $ref_no = $prefix;
    $ref_no .= date('Ymd');

    $yearmonth = date('Y-m-d');
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

    return $ref_no;
  }

  public function orderItems(Request $request)
  {
    $products = Product::get();
    $order_id = DB::table('orders')->max('id');

    foreach ($products as $values) {
      if ($values['id'] == $request->product_id) {
        OrderItems::create([
          'order_id' => $order_id,
          'product_id' => $request->product_id,
          'product_variant_id' => $request->variant_id,
          'quantity' => $request->quantity,
          'noted' => $request->noted,
        ]);
      }
    }
  }

  public function notification()
  {
    Config::$isProduction = false;
    Config::$serverKey = "SB-Mid-server-hNxOxUyJ2PbHCbFrFu6oJHMF";
    $json_result = file_get_contents('php://input');
    $result = json_decode($json_result);
    //DB::table('endpoint_json')->insert(["data"=>$json_result]);
    if ($result) {
      $notif = new Notification();
      $notif = $notif->getResponse();
      if (($notif->status_code == 200) || ($notif->status_code == 201) || ($notif->status_code == 202)) {
        if ($result->signature_key == $notif->signature_key) {
          $transaction = trim(strtolower($notif->transaction_status));
          $type = $notif->payment_type;
          $order_id = $notif->order_id;
          $payment_type = [
            "bank_transfer"     => "Virtual Account",
            "credit_card"       => "Credit Card",
            "gopay"             => "GoPay",
            "mandiri_clickpay"  => "Mandiri KlikPay",
            "cimb_clicks"       => "CIMB Clicks",
            "bca_klikbca"       => "bca_klikbca",
            "bca_klikpay"       => "BCA KlikPay",
            "bri_epay"          => "bri_epay",
            "telkomsel_cash"    => "Telkomsel Cash",
            "echannel"          => "E-channel",
            "bbm_money"         => "bbm_money",
            "xl_tunai"          => "XL Tunai",
            "indosat_dompetku"  => "Indosat Dompetku",
            "mandiri_ecash"     => "Mandiri E-Cash",
            "permata_va"        => "Permata Virtual Account",
            "bca_va"            => "BCA Virtual Account",
            "bni_va"            => "BNI Virtual Account",
            "danamon_online"    => "Danamon Online",
            "other_va"          => "Other Virtual Account",
            "kioson"            => "Kioson",
            "cstore"            => "Indomaret"
          ];

          switch ($transaction) {
            case 'capture':
              if ($type == 'credit_card') {
                $fraud = $notif->fraud_status;
                if ($fraud == 'challenge') {
                  // TODO set payment status in merchant's database to 'Challenge by FDS'
                  // TODO merchant should decide whether this transaction is authorized or not in MAP
                  $payment['status'] = $transaction . "_" . $fraud;
                  $payment['information'] = "Transaction Order ID: " . $order_id . " is challenged by FDS";
                } else {
                  // TODO set payment status in merchant's database to 'Success'
                  $payment['status'] = $transaction;
                  $payment['information'] = "Transaction Order ID: " . $order_id . " successfully captured using " . $payment_type[$type];
                }
              }
              break;

            case 'settlement':
              // TODO set payment status in merchant's database to 'Settlement'
              $payment['status'] = $transaction;
              $payment['information'] = "Transaction Order ID: " . $order_id . " successfully transfered using " . $payment_type[$type];
              break;

            case 'pending':
              // TODO set payment status in merchant's database to 'Pending'
              $payment['status'] = $transaction;
              $payment['information'] = "Waiting customer to finish transaction Order ID: " . $order_id . " using " . $payment_type[$type];
              break;

            case 'deny':
              // TODO set payment status in merchant's database to 'Denied'
              $payment['status'] = $transaction;
              $payment['information'] = "Payment using " . $payment_type[$type] . " for transaction Order ID: " . $order_id . " is denied.";
              break;

            case 'expire':
              // TODO set payment status in merchant's database to 'Expire'
              $payment['status'] = $transaction;
              $payment['information'] = "Payment using " . $payment_type[$type] . " for transaction Order ID: " . $order_id . " is expired.";
              break;

            case 'cancel':
              $payment['status'] = $transaction;
              $payment['information'] = "Payment using " . $payment_type[$type] . " for transaction Order ID: " . $order_id . " is canceled.";
              break;

            default:
              $payment['status'] = "undifined";
              $payment['information'] = "Undifined Status Payment";
              break;
          }

          $order = Orders::where("invoice_number", $order_id);
          if ($order->count() > 0) {
            $order = $order->first();
            $payment['data'] = $json_result;
            OrderBillings::where("order_id", $order->id)->update($payment);
            if ($payment['status'] == "settlement" || ($payment['status'] == "capture" && $fraud = "accept")) {
              Orders::where('orders.id', $order->id)->where("status", 'waiting_for_payment')->update(['status' => 'processed']);
            } elseif ($payment['status'] == "deny" || $payment['status'] == "expire" || $payment['status'] == "cancel") {
              Orders::where('orders.id', $order->id)->update(['status' => 'canceled']);
            }
          }
        } //end check signature
      } //end check notif status code
    } //end check result
  }

  public function payment_finish(Request $request)
  {
    return redirect()->route('order_history_detail', $request->order_id);
  }

  public function payment_unfinish()
  {
  }

  public function payment_error()
  {
  }

  public function getBankAccount()
  {
  }

  public function getCities(Request $request)
  {
    $selected_id = $request->selected_data;
    $cities = City::where("cities.province_id", $selected_id)->get();
    return response()->json($cities);
  }

  public function getDistricts(Request $request)
  {
  }

  public function getServiceCourier(Request $request) {
    $courier_id = Courier::where('code', $request->courier_id)->first();
    if (!empty($courier_id)) {
        $services = ServiceCourier::where('courier_id', $courier_id->id)->get();
        return response()->json($services, 200);
    }
    return [];
  }



}
