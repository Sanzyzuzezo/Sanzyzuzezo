<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Promotion;
use App\Models\PromotionProduct;
use App\Models\CustomerGroupCategories;
use Illuminate\Support\Facades\Cookie;
use App\Models\SettingCompany;
use DB;

class CartController extends Controller
{

    public function index(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $cart_data = Cart::where('customer_id', auth()->user()->id)->get();
            // $company_id = getCompanyId();
            // dd($company_id);

            // $settings = SettingCompany::where("company_id", $company_id)
            // ->where("settings_companies.name", "gudang_penjualan")
            // ->first();

            // dd($request->company_id);
            $products = Cart::select(DB::raw('
                    products.*,
                    product_medias.data_file as image,
                    product_variants.id as variant_id,
                    product_variants.name as variant,
                    product_variants.price as price,
                    product_variants.discount_price as discount_price,
                    carts.quantity as quantity,
                    stock.stock as stock_item'
                ))
				->leftJoin('products', 'products.id', '=', 'carts.product_id')
                ->leftJoin('product_medias', 'products.id', '=', 'product_medias.product_id')
                ->leftJoin('product_variants', 'product_variants.id', '=', 'carts.product_variant_id')
                ->leftJoin('stock', 'product_variants.id', '=', 'stock.item_variant_id')
                ->where('carts.customer_id', auth()->user()->id)
                ->where("stock.warehouse_id", $request->company_id)
                ->where("products.status", true)
                ->groupBy(['product_variants.id', 'products.id', 'product_medias.data_file', 'carts.quantity','stock.stock'])
                ->orderBy('products.id', 'ASC')
                ->get();
                $products->map(function ($pr) {
                    $pr->data_file = $pr->data_file != null ? '/administrator/assets/media/products/' . $pr->data_file : img_src('default.jpg', '');
                });
        
                $discount_customer = [];
                if (isset(auth()->user()->customer_group_id)) {
                    $discount_customer = DB::table('customer_group_categories')
                        ->where('customer_group_categories.customer_group_id', auth()->user()->customer_group_id)
                        ->get()->toArray();
                }
            $cart_no_promo = ['data_product' =>$products,'cart_data' => $cart_data,'discount_customer' => $discount_customer,];
        }

            $cart_data_promo = Cart::select(DB::raw('carts.*'))
            ->leftJoin('products', 'products.id', '=', 'carts.product_id')
            ->leftJoin('promotion_products', 'products.id', '=', 'promotion_products.product_id')
            ->leftJoin('promotions', 'promotions.id', '=', 'promotion_products.promotion_id')
            ->where('customer_id', auth()->user()->id)
            ->where('promotions.status', 1)
            ->where('promotions.end_date', '>', now())
            ->whereNotNull('promotion_products.promotion_stock')
            ->get();

            // $company_id = getCompanyId();

            $settings = SettingCompany::where("company_id", $request->company_id)
            ->where("settings_companies.name", "gudang_penjualan")
            ->first();

            $products_promo = Product::select(DB::raw('
                    products.*,
                    product_medias.data_file as image,
                    product_variants.id as variant_id,
                    product_variants.name as variant,
                    product_variants.price as price,
                    promotion_products.after_discount_price as promo_price,
                    promotion_products.promotion_stock as promotion_stock,
                    product_variants.discount_price as discount_price,
                    carts.quantity as quantity,
                    stock.stock as stock_item'
                ))
                ->leftJoin('promotion_products', 'products.id', '=', 'promotion_products.product_id')
                ->leftJoin('product_medias', 'products.id', '=', 'product_medias.product_id')
                ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->leftJoin('stock', 'product_variants.id', '=', 'stock.item_variant_id')
                ->leftJoin('carts', 'product_variants.id', '=', 'carts.product_variant_id')
                ->leftJoin('promotions', 'promotions.id', '=', 'promotion_products.promotion_id')
                ->where('carts.customer_id', auth()->user()->id)
                ->where("stock.warehouse_id", $request->company_id)
                ->where("products.status", 1)
                ->where("stock.stock", '>', 0)
                ->where('carts.product_id', '=', DB::raw('promotion_products.product_id'))
                ->where('carts.product_variant_id', '=', DB::raw('promotion_products.product_variant_id'))
                ->where('promotions.status', 1)
                ->where('promotions.end_date', '>', now())
                ->whereNotNull('promotion_products.promotion_stock')
                ->groupBy(['product_variants.id',"products.id","product_medias.data_file","carts.quantity","promotion_products.after_discount_price","promotion_products.promotion_stock","stock.stock"])
                ->orderBy('products.id', 'ASC')
                ->get();

            $promotion = Product::select('products.id')
                ->leftJoin('promotion_products', 'products.id', '=', 'promotion_products.product_id')
                ->leftJoin('promotions', 'promotions.id', '=', 'promotion_products.promotion_id')
                ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->leftJoin('carts', 'product_variants.id', '=', 'carts.product_variant_id')
                ->where('carts.product_id', '=', DB::raw('promotion_products.product_id'))
                ->where('carts.product_variant_id', '=', DB::raw('promotion_products.product_variant_id'))
                ->where('promotions.status', 1)
                ->where('promotions.end_date', '>', now())
                ->whereNotNull('promotion_products.promotion_stock')
                ->whereIn('carts.product_id', $products_promo->pluck('id')->all())
                ->groupBy(['product_variants.id',"products.id"])
                ->get();

            $products_promo->each(function ($pro) {
                $pro->data_file = $pro->data_file != null ? '/administrator/assets/media/products/' . $pro->data_file : img_src('default.jpg', '');
            });

            $discount_customer_promo = [];
            if (isset(auth()->user()->customer_group_id)) {
                $discount_customer_promo = CustomerGroupCategories::select('customer_group_categories.*')
                    ->leftJoin('customer_groups', 'customer_groups.id', '=', 'customer_group_categories.customer_group_id')
                    ->leftJoin('customers', 'customer_groups.id', '=', 'customers.customer_group_id')
                    ->leftJoin('carts as customer_carts', 'customers.id', '=', 'customer_carts.customer_id')
                    ->leftJoin('products', 'products.id', '=', 'customer_carts.product_id')
                    ->leftJoin('promotion_products', 'products.id', '=', 'promotion_products.product_id')
                    ->leftJoin('promotions', 'promotions.id', '=', 'promotion_products.promotion_id')
                    ->leftJoin('carts as product_carts', 'products.id', '=', 'product_carts.product_id')
                    ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                    ->where('customer_group_categories.customer_group_id', auth()->user()->customer_group_id)
                    ->where('promotions.status', 1)
                    ->where('promotions.end_date', '>', now())
                    ->whereNotNull('promotion_products.promotion_stock')
                    ->groupBy(["customer_group_categories.id"])
                    ->get()->toArray();
            }


            $cart_with_promo = [
                'data_product_promo' => $products_promo,
                'cart_data_promo' => $cart_data_promo,
                'discount_customer_promo' => $discount_customer_promo,
            ];
            if (!empty($promotion)) {
                return response()->json([
                    'status'=> 200,
                    'message' => 'You successfully completed loaded.',
                    'cart_no_promo' => $cart_no_promo,
                    'cart_with_promo' => $cart_with_promo,
                ]);
            } else {
                return response()->json([
                    'status'=> 200,
                    'message' => 'You successfully completed loaded.',
                    'cart_no_promo' => $cart_no_promo,
                ]);
        }

        
    }

    public function addToCart(Request $request)
    {
        $variant_id = $request->input('product_variant_id');
        $quantity = $request->input('quantity');
        $cart = null;

        if (auth()->check()) {
            $customer_id = auth()->user()->id;
            $product_variant_id = $request->input('product_variant_id');
            $product_id = Product::select('products.id')
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->where('product_variants.id', $product_variant_id)
            ->first();

            $cek_cart = Cart::where('customer_id', $customer_id)
                ->where('product_variant_id', $product_variant_id)
                ->where('product_id', $product_id->id)
                ->count();

            if ($cek_cart == 0) {
                $cart = Cart::create([
                    'customer_id' => $customer_id,
                    'product_variant_id' => $variant_id,
                    'quantity' => $quantity,
                    'product_id' => $product_id->id
                ]);
            } else {
                $cart = Cart::where('product_variant_id', $variant_id)
                    ->where('product_id', $product_id->id)
                    ->where('customer_id', $customer_id)
                    ->first();
                $cart->quantity += $quantity;
                $cart->save();
            }
        } 

        return response()->json([
            'status' => 200,
            'message' => 'You successfully added to cart.',
            'data' => $cart
        ]);
    }
    
    public function cartLoadByAjax()
    {
        if (isset(auth()->user()->id)) {
            $cart_data = Cart::where('customer_id', auth()->user()->id)->get();
            $totalcart = count($cart_data);

            return response()->json([
                'status' => 200,
                'message' => 'You successfully completed loaded.',
                'totalcart' => $totalcart
            ]);
        } else {
            $totalcart = 0;
            return response()->json([
                'status' => 200,
                'message' => 'You successfully completed loaded.',
                'totalcart' => $totalcart
            ]);
        }
    }


    public function updateCart(Request $request)
    {
        $variant_id = $request->input('product_variant_id');
        $quantity = $request->input('quantity');
    
        if (auth()->check()) {
            $product_variant_id = $request->input('product_variant_id');
            $product_id = Product::select('products.id')
                ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->where('product_variants.id', $product_variant_id)
                ->first();
    
            $cart = Cart::where('product_variant_id', $variant_id)
                ->where('product_id', $product_id->id)
                ->where('customer_id', auth()->user()->id)
                ->first();
    
            if ($cart) {
                $cart->quantity = $quantity;
                $cart->save();
    
                return response()->json([
                    'status' => 200,
                    'message' => 'You successfully update cart.',
                    'data' => $cart
                ]);
            }
        }

        return response()->json([
            'status' => 404,
            'message' => 'Cart not found or user not authenticated.',
            'data' => null
        ]);
    }
    


    public function deleteCart($id)
    {
        if (isset(auth()->user()->id)) {
            $cart_id = Cart::find($id);
            Cart::destroy($cart_id->id);

            return response()->json([
                'status' => 200,
                'message' => 'You successfully deleted cart.',
            ],200);
        }
    }

    public function clearCart(Request $request)
    {
        Cookie::queue(Cookie::forget("shopping_cart"));
    }
}
