<?php

namespace App\Http\Controllers\Frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;
use DB;

class CartController extends Controller
{

    public function index()
    {
        if (isset(auth()->user()->id)) {
            $cart_data = Cart::where('customer_id', auth()->user()->id)->get();
            // $cart_data = null;

            $products = Product::select(DB::raw('
                    products.*,
                    product_medias.data_file as image,
                    product_variants.id as variant_id,
                    product_variants.name as variant,
                    product_variants.price as price,
                    product_variants.discount_price as discount_price,
                    product_variants.stock as stock,
                    carts.quantity as quantity'
                ))
                ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
                ->leftJoin(DB::raw('product_variants'), 'products.id', '=', 'product_variants.product_id')
                ->leftJoin('carts', 'product_variants.id', '=', 'carts.product_variant_id')
                ->where('carts.customer_id', auth()->user()->id)
                ->groupBy(['product_variants.id',"products.id","product_medias.data_file","carts.quantity"])
                ->orderBy('products.id', 'ASC')
                ->get();

        }else{
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));

            if ($cookie_data != null) {
                $cart_data = json_decode($cookie_data, true);
                $product_id_list = array_column($cart_data, 'variant_id');
            } else {
                $product_id_list = [];
                $cart_data = null;
            }


            $products = Product::select(DB::raw('
                    products.*,
                    product_medias.data_file as image,
                    product_variants.id as variant_id,
                    product_variants.name as variant,
                    product_variants.price as price,
                    product_variants.discount_price as discount_price,
                    product_variants.stock as stock'
                ))
                ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
                ->leftJoin(DB::raw('product_variants'), 'products.id', '=', 'product_variants.product_id')
                ->whereIn('product_variants.id', $product_id_list)
                ->groupBy(['product_variants.id',"products.id","product_medias.data_file"])
                ->orderBy('products.id', 'ASC')
                ->get();
        }

        // return Cart::where('product_variant_id', 3)->get();

        $discount_customer = [];
        if (isset(auth()->user()->customer_group_id)) {
            $discount_customer = DB::table('customer_group_categories')
                ->where('customer_group_categories.customer_group_id', auth()->user()->customer_group_id)
                ->get()->toArray();
        }

        return view('frontpage-schoko.cart')->with(['cart_data' => $products, 'quantity' => $cart_data, 'discount_customer' => $discount_customer]);
    }

    public function addToCart(Request $request)
    {
        $variant_id = $request->input('variant_id');
        $quantity = $request->input('quantity');

        if (isset(auth()->user()->id)) {
            $customer_id = auth()->user()->id;
            $product_variant_id = $request->input('variant_id');
            $cek_cart = Cart::where('customer_id', $customer_id)->where('product_variant_id', $product_variant_id)->count();

            if($cek_cart == null){
                Cart::create([
                    'customer_id' => auth()->user()->id,
                    'product_variant_id' => $variant_id,
                    'quantity' => $quantity
                ]);
            }else{
                $cart = Cart::where('product_variant_id', $variant_id)->where('customer_id', auth()->user()->id)->first();
                $cart->quantity = $cart->quantity+$quantity;
                $cart->save();
            }
        }else{
            if (Cookie::get('shopping_cart')) {
                $cookie_data = stripslashes(Cookie::get('shopping_cart'));
                $cart_data = json_decode($cookie_data, true);
            } else {
                $cart_data = array();
            }

            $variant_id_list = array_column($cart_data, 'variant_id');
            $var_id_is_there = $variant_id;

            if (array_key_exists($var_id_is_there, $cart_data)) {
                $cart_data[$variant_id]["quantity"] = $cart_data[$variant_id]["quantity"] + $request->input('quantity');
                $item_data = json_encode($cart_data);
                $minutes = 60;
                Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes, "/"));
            } else {
                $item_array = array(
                    'variant_id' => $variant_id,
                    'quantity' => $quantity
                );
                $cart_data[$variant_id] = $item_array;

                $item_data = json_encode($cart_data);
                $minutes = 60;
                Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes, "/"));
            }
        }
    }
    
    public function cartLoadByAjax()
    {
        if (isset(auth()->user()->id)) {
            $cart_data = Cart::where('customer_id', auth()->user()->id)->get();
            $totalcart = count($cart_data);

            echo json_encode(array('totalcart' => $totalcart));
            die;
            return;
        }else{
            if (Cookie::get('shopping_cart')) {
                $cookie_data = stripslashes(Cookie::get('shopping_cart'));
                $cart_data = json_decode($cookie_data, true);
                $totalcart = count($cart_data);

                echo json_encode(array('totalcart' => $totalcart));
                die;
                return;
            } else {
                $totalcart = "0";
                echo json_encode(array('totalcart' => $totalcart));
                die;
                return;
            }
        }
    }

    public function updateCart(Request $request)
    {
        $variant_id = $request->input('variant_id');
        $quantity = $request->input('quantity');

        if (isset(auth()->user()->id)) {
            $cart = Cart::where('product_variant_id', $variant_id)->where('customer_id', auth()->user()->id)->get('id')->first();
            $cart->quantity = $quantity;
            $cart->save();
        }else{
            if (Cookie::get('shopping_cart')) {
                $cookie_data = stripslashes(Cookie::get('shopping_cart'));
                $cart_data = json_decode($cookie_data, true);

                $variant_id_list = array_column($cart_data, 'variant_id');
                $var_id_is_there = $variant_id;

                if (array_key_exists($var_id_is_there, $cart_data)) {
                    $cart_data[$variant_id]["quantity"] = $quantity;
                    $item_data = json_encode($cart_data);
                    $minutes = 60;
                    Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes, "/"));
                }
            }
        }
    }

    public function deleteCart(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $variant_id = $request->input('variant_id');
            $cart_id = Cart::where('product_variant_id', $variant_id)->where('customer_id', auth()->user()->id)->get('id')->first();
            Cart::destroy($cart_id->id);
        }else{
            $variant_id = $request->input('variant_id');

            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart_data = json_decode($cookie_data, true);

            $variant_id_list = array_column($cart_data, 'variant_id');
            $var_id_is_there = $variant_id;

            if (array_key_exists($var_id_is_there, $cart_data)) {
                unset($cart_data[$variant_id]);
                $item_data = json_encode($cart_data);
                $minutes = 60;
                Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes, "/"));
            }
        }
    }

    public function clearCart(Request $request)
    {
        Cookie::queue(Cookie::forget("shopping_cart"));
    }

    public function selectCart(Request $request)
    {
        $data = $request->data;

        if (isset(auth()->user()->id)) {
            foreach ($data as $item) {
                $variant_id = $item["variant_id"];
                $quantity = $item["quantity"];

                $item_array = array(
                    'variant_id' => $variant_id,
                    'quantity' => $quantity
                );
                $product_data[$variant_id] = $item_array;
            }

            $order_data = json_encode($product_data);
            $minutes = 60;

            Cookie::queue(Cookie::make('shopping_order', $order_data, $minutes)); //add shopping order
        }else{
            $cookie_data = stripslashes(Cookie::get('shopping_cart'));
            $cart_data = json_decode($cookie_data, true);

            foreach ($data as $item) {
                $variant_id = $item["variant_id"];
                $quantity = $item["quantity"];
                $variant_id_list = array_column($cart_data, 'variant_id');
                $var_id_is_there = $variant_id;

                if (array_key_exists($var_id_is_there, $cart_data)) {
                    unset($cart_data[$variant_id]);

                    $item_array = array(
                        'variant_id' => $variant_id,
                        'quantity' => $quantity
                    );
                    $product_data[$variant_id] = $item_array;
                }
            }

            $order_data = json_encode($product_data);
            $item_data = json_encode($cart_data);
            $minutes = 60;

            Cookie::queue(Cookie::make('shopping_order', $order_data, $minutes)); //add shopping order
            // Cookie::queue(Cookie::make('shopping_cart', $item_data, $minutes, "/")); // delete cart
        }
    }
}
