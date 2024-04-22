<?php

namespace App\Http\Controllers\API;

use DB;
use Validator;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductMedia;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\ProfileController;
use App\Models\Whishlist;
use App\Models\Post;
use App\Models\Promotion;
use App\Models\PromotionProduct;
use App\Models\Orders;
use App\Models\OrderItems;
use DataTables;
use Image;
use File;

class ProductController extends Controller
{
    public function product(Request $request){
    	$validator = Validator::make($request->all(),[
            'limit' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = auth()->user();
        $warehouse = User::select('users.*', 'stores.code AS code_cashier', 'store_detail.warehouse_id')
        ->leftJoin('stores', 'stores.id', '=', 'users.cashier')
        ->leftJoin('store_detail', 'store_detail.store_id', '=', 'stores.id')
        ->where('users.cashier', $user->cashier)->first();

        $stock = ProductVariant::select('product_variants.id', 'stock.stock AS stock_item')
        ->leftJoin('stock', 'stock.item_variant_id', '=', 'product_variants.id')
        ->where('warehouse_id', $warehouse->warehouse_id);

        $price = ProductVariant::select('product_id',DB::raw('min(price) as min_price'), DB::raw('max(price) as max_price'))->where('show_pos',1)->groupBy('product_id');
        $media = ProductMedia::select('product_id', DB::raw('data_file'))->where('main',1);
    	$query = Product::select('products.*', 'price.min_price', 'price.max_price', 'media.data_file')->with(['variants' => function ($query) use ($stock){
            $query
            ->select('product_variants.*', DB::raw(' CAST(IFNULL(stock.stock_item, 0) AS UNSIGNED) AS stock_item'))
            ->leftJoinSub($stock, 'stock', function($join){
                $join->on('product_variants.id', '=', 'stock.id');
            })
            ->where('show_pos',1);
        }])
        ->joinSub($price, 'price', function($join){
    		$join->on('products.id', '=', 'price.product_id');
    	})
        ->joinSub($media, 'media', function($join){
    		$join->on('products.id', '=', 'media.product_id');
    	});

        if (!empty($request->category_id)) {
            $category = Category::where('parent',$request->category_id)->pluck('id');
    		$query->whereIn('products.category_id', $category)->orWhere('products.category_id',$request->category_id);
    	}
    	if (!empty($request->search)) {
    		$query->where('products.name', 'LIKE', '%'.$request->search.'%');
    	}

        $product_total = $query->count();
        $product = $query->paginate($request->limit);
        
        $product->map(function($pr){
        	// $pr->data_file = $pr->data_file != null ? asset('storage/administrator/assets/media/products/'.$pr->data_file) : img_src('default.jpg', '');
        	$pr->data_file = $pr->data_file != null ? img_src($pr->data_file, 'product') : img_src('default.jpg', '');
        });

        if($request->category_id == 'undefined'){
            return response()->json(['status'=> 406, 'message' => 'Not Acceptable'], 406); 
        }

        if (empty($product_total)) {
            return response()->json(['status'=> 404, 'message' => 'Product not found'], 404);
        }

        return response()->json([
            'status'=> 200,
            'message' => 'You successfully completed loaded.',
            'data' => $product,
        ]);
    }

    public function product_detail($id, Request $request){
        $product = Product::where('id',$id)->first();
        $variants = ProductVariant::where('product_id', $id)
        ->where('show_pos',1)
        ->get();
        $max_price = ProductVariant::select(DB::raw('max(price) as price'))->where('product_id', $id)->first();

        $query = [$product,$variants,$max_price];

        if (!$product) {
            return response()->json(['status'=> 404, 'message' => 'Product not found'], 404);  
        }

        return response()->json([
            'status'=> 200,
            'message' => 'You successfully completed loaded.',
            'data' => $query,
        ]);
    }

    //Guest

    public function products(Request $request){
        $validator = Validator::make($request->all(),[
            'limit' => 'required',
            'company_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $stock = ProductVariant::select('product_variants.id', 'stock.stock AS stock_item')
        ->leftJoin('stock', 'stock.item_variant_id', '=', 'product_variants.id');
    
        $price = ProductVariant::select('product_id', DB::raw('min(price) as min_price'), DB::raw('max(price) as max_price'))
            ->groupBy('product_id');
        
        $media = ProductMedia::select('product_id', DB::raw('data_file'));
        
        $promo = ProductVariant::select('product_variants.id', 'promotion_products.product_variant_id AS product_variant_id', 'promotion_products.after_discount_price AS after_discount_price',
        'promotion_products.current_stock AS current_stock', 'promotion_products.promotion_stock AS promotion_stock')
        ->leftJoin('promotion_products', 'product_variants.id', '=', 'promotion_products.product_variant_id')
        ->leftJoin('promotions', 'promotions.id', '=', 'promotion_products.promotion_id')
        ->groupBy('product_variants.id', 'promotion_products.product_variant_id', 'promotion_products.after_discount_price', 'promotion_products.current_stock', 'promotion_products.promotion_stock');
    
        $promoSubquery = $promo->toSql();
            
        $requestPrice = $request->input('price', '');

        $query = Product::select('products.*', 'price.min_price', 'price.max_price', 'categories.name as category_name', 'brands.name as brand_name')
            ->with('images')
            ->with(['variants' => function ($query) use ($stock, $promoSubquery, $requestPrice) {
                $query
                    ->select('product_variants.*', DB::raw('stock.stock_item AS stock_item'), DB::raw('promo.after_discount_price AS after_discount_price'),
                        DB::raw('promo.current_stock AS current_stock'), DB::raw('promo.promotion_stock AS promotion_stock'))
                    ->leftJoinSub($stock, 'stock', function ($join) {
                        $join->on('product_variants.id', '=', 'stock.id');
                    })
                    ->leftJoin(DB::raw("($promoSubquery) as promo"), function ($join) {
                        $join->on('product_variants.id', '=', 'promo.id');
                    })
                    ->groupBy('product_variants.id', 'stock.stock_item', 'promo.after_discount_price',
                        'promo.current_stock', 'promo.promotion_stock');
        
                    $query->orderBy('product_variants.id', 'desc');
            }])
            ->leftJoin(DB::raw('categories'), 'categories.id', '=', 'products.category_id')
            ->leftJoin(DB::raw('brands'), 'brands.id', '=', 'products.brand_id')
            ->leftJoinSub($price, 'price', function ($join) {
                $join->on('products.id', '=', 'price.product_id');
            });

            if ($requestPrice === "asc") {
                $query->orderBy('price.min_price', 'asc');
            } elseif ($requestPrice === "desc") {
                $query->orderBy('price.max_price', 'desc');
            } else {
                $query->orderBy('products.id', 'desc');
            }
        
        if (!empty($request->category_id)) {
            $categoryIds = is_array($request->category_id) ? $request->category_id : explode(',', $request->category_id);    
            $categories = Category::whereIn('parent', $categoryIds)->pluck('id')->toArray();
            $categoryIds = array_merge($categoryIds, $categories);
            $query->whereIn('products.category_id', $categoryIds);
        }
        
        if (!empty($request->brand_id)) {
            $brandIds = is_array($request->brand_id) ? $request->brand_id : explode(',', $request->brand_id);    
            $brands = Brands::whereIn('id', $brandIds)->pluck('id')->toArray();
            $brandIds = array_merge($brandIds, $brands);
            $query->whereIn('products.brand_id', $brandIds);
        }
        
        if (!empty($request->search)) {
            $query->where('products.name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->company_id !== 0) {
            $query->where('products.company_id', $request->company_id);
        }
        
        $product_total = $query->count();
        $products = $query->paginate($request->limit);
        

        $products->map(function($pr){
            $pr->data_file = $pr->data_file != null ? '/administrator/assets/media/products/' . $pr->data_file : img_src('default.jpg', '');
        });
    
        if($request->category_id == 'undefined'){
            return response()->json(['status'=> 406, 'message' => 'Not Acceptable'], 406); 
        }
    
        return response()->json([
            'status'=> 200,
            'message' => 'You successfully completed loaded.',
            'data' => $products,
            'product_total' => $product_total,
        ]);
    }
    
    public function productDetails($id, Request $request){

        $product = Product::select('products.*', 'brands.name as name_brand', 'categories.name as name_category')
        ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
        ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
        ->where('products.id', $id)
        ->first();
        
        $variants = ProductVariant::where('product_id', $id)->get();
        $medias = ProductMedia::where('product_id', $id)->get();
        $medias->map(function($pr){
            $pr->data_file = $pr->data_file != null ? '/administrator/assets/media/products/' . $pr->data_file : img_src('default.jpg', '');
        });

        $max_price = ProductVariant::select(DB::raw('max(price) as price'))->where('product_id', $id)->first();

        $query = [$product,$variants,$max_price, $medias];

        if (!$product) {
            return response()->json(['status'=> 404, 'message' => 'Product not found'], 404);  
        }

        return response()->json([
            'status'=> 200,
            'message' => 'You successfully completed loaded.',
            'data' => $query,
        ]);
    }

    public function newProducts(Request $request){
        $validator = Validator::make($request->all(),[
            'company_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $stock = ProductVariant::select('product_variants.id', 'stock.stock AS stock_item')
        ->leftJoin('stock', 'stock.item_variant_id', '=', 'product_variants.id');
    
        $price = ProductVariant::select('product_id', DB::raw('min(price) as min_price'), DB::raw('max(price) as max_price'))
        ->groupBy('product_id');
    
        $media = ProductMedia::select('product_id', DB::raw('data_file'));

        $promo = ProductVariant::select('product_variants.id', 'promotion_products.product_variant_id AS product_variant_id', 'promotion_products.after_discount_price AS after_discount_price',
        'promotion_products.current_stock AS current_stock', 'promotion_products.promotion_stock AS promotion_stock')
        ->leftJoin('promotion_products', 'product_variants.id', '=', 'promotion_products.product_variant_id')
        ->leftJoin('promotions', 'promotions.id', '=', 'promotion_products.promotion_id')
        ->groupBy('product_variants.id', 'promotion_products.product_variant_id', 'promotion_products.after_discount_price', 'promotion_products.current_stock', 'promotion_products.promotion_stock');
    
        $promoSubquery = $promo->toSql();

        $requestPrice = $request->input('price', '');

        $query = Product::select('products.*', 'price.min_price', 'price.max_price', 'media.data_file')
        ->orderBy('products.created_at', 'DESC')
        ->limit(5)

        ->with(['variants' => function ($query) use ($stock, $promoSubquery) {
                $query
                    ->select('product_variants.*', DB::raw('stock.stock_item AS stock_item'), DB::raw('promo.after_discount_price AS after_discount_price'),
                        DB::raw('promo.current_stock AS current_stock'), DB::raw('promo.promotion_stock AS promotion_stock'))
                    ->leftJoinSub($stock, 'stock', function ($join) {
                        $join->on('product_variants.id', '=', 'stock.id');
                    })
                    ->leftJoin(DB::raw("($promoSubquery) as promo"), function ($join) {
                        $join->on('product_variants.id', '=', 'promo.id');
                    })
                    ->groupBy('product_variants.id', 'stock.stock_item', 'promo.after_discount_price',
                        'promo.current_stock', 'promo.promotion_stock');

                    if ($requestPrice === "asc") {
                        $query->orderBy('product_variants.price', 'asc');
                    } elseif ($requestPrice === "desc") {
                        $query->orderBy('product_variants.price', 'desc');
                    } else {
                        $query->orderBy('product_variants.id', 'desc');
                    }
            }])
        ->leftJoinsub($price, 'price', function($join){
            $join->on('products.id', '=', 'price.product_id');
        })
        ->leftJoinSub($media, 'media', function($join){
            $join->on('products.id', '=', 'media.product_id');
        });
    
        if (!empty($request->category_id)) {
            $category = Category::where('parent', $request->category_id)->pluck('id');
            $query->whereIn('products.category_id', $category)->orWhere('products.category_id', $request->category_id);
        }
        if (!empty($request->search)) {
            $query->where('products.name', 'LIKE', '%'.$request->search.'%');
        }

        if ($request->company_id !== 0) {
            $query->where('products.company_id', $request->company_id);
        }
    
        // $product_total = $query->count();
        $products = $query->get();
    
        $products->map(function($pr){
            $pr->data_file = $pr->data_file != null ? '/administrator/assets/media/products/' . $pr->data_file : img_src('default.jpg', '');
        });
    
        if($request->category_id == 'undefined'){
            return response()->json(['status'=> 406, 'message' => 'Not Acceptable'], 406); 
        }
    
        return response()->json([
            'status'=> 200,
            'message' => 'You successfully completed loaded.',
            'data' => $products,
        ]);
    }

public function hotProducts(Request $request)
{
    $validator = Validator::make($request->all(),[
        'company_id' => 'required',
    ]);
    if($validator->fails()){
        return response()->json($validator->errors());
    }
    
    $stock = ProductVariant::select('product_variants.id', 'stock.stock AS stock_item')
        ->leftJoin('stock', 'stock.item_variant_id', '=', 'product_variants.id');

    $price = ProductVariant::select('product_id', DB::raw('min(price) as min_price'), DB::raw('max(price) as max_price'))
        ->groupBy('product_id');

    $media = ProductMedia::select('product_id', DB::raw('data_file'));

    $promo = ProductVariant::select('product_variants.id', 'promotion_products.product_variant_id AS product_variant_id', 'promotion_products.after_discount_price AS after_discount_price',
        'promotion_products.current_stock AS current_stock', 'promotion_products.promotion_stock AS promotion_stock')
        ->leftJoin('promotion_products', 'product_variants.id', '=', 'promotion_products.product_variant_id')
        ->leftJoin('promotions', 'promotions.id', '=', 'promotion_products.promotion_id')
        ->groupBy('product_variants.id', 'promotion_products.product_variant_id', 'promotion_products.after_discount_price', 'promotion_products.current_stock', 'promotion_products.promotion_stock');
    
    $promoSubquery = $promo->toSql();

    $requestPrice = $request->input('price', '');

    $query = Product::select('products.*', 'price.min_price', 'price.max_price', 'media.data_file')
        ->with(['variants' => function ($variantsQuery) use ($stock, $promoSubquery) {
            $variantsQuery
                ->select('product_variants.*', DB::raw('stock.stock_item AS stock_item'), DB::raw('SUM(order_items.quantity) as total_selling'), DB::raw('promo.after_discount_price AS after_discount_price'),
                    DB::raw('promo.current_stock AS current_stock'), DB::raw('promo.promotion_stock AS promotion_stock'))
                ->leftJoinSub($stock, 'stock', function ($join) {
                    $join->on('product_variants.id', '=', 'stock.id');
                })
                ->leftJoin(DB::raw("($promoSubquery) as promo"), function ($join) {
                    $join->on('product_variants.id', '=', 'promo.id');
                })
                ->leftJoin('order_items', 'order_items.product_variant_id', '=', 'product_variants.id')
                ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.status', 'paid')
                ->groupBy('product_variants.id', 'stock.stock_item', 'promo.after_discount_price',
                    'promo.current_stock', 'promo.promotion_stock');

                if ($requestPrice === "asc") {
                    $query->orderBy('product_variants.price', 'asc');
                } elseif ($requestPrice === "desc") {
                    $query->orderBy('product_variants.price', 'desc');
                } else {
                    $query->orderBy('product_variants.id', 'desc');
                }
        }])
        ->leftJoinSub($price, 'price', function ($join) {
            $join->on('products.id', '=', 'price.product_id');
        })
        ->leftJoinSub($media, 'media', function ($join) {
            $join->on('products.id', '=', 'media.product_id');
        })
        ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
        ->leftJoin('order_items', 'order_items.product_variant_id', '=', 'product_variants.id')
        ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
        ->where('orders.status', 'paid')
        ->groupBy('product_variants.id','order_items.quantity','products.id','price.min_price', 'price.max_price', 'media.data_file')
        ->orderBy('order_items.quantity', 'DESC')
        ->limit(5);

    if (!empty($request->category_id)) {
        $category = Category::where('parent', $request->category_id)->pluck('id');
        $query->whereIn('products.category_id', $category)->orWhere('products.category_id', $request->category_id);
    }
    if (!empty($request->search)) {
        $query->where('products.name', 'LIKE', '%'.$request->search.'%');
    }

    if ($request->company_id !== 0) {
        $query->where('products.company_id', $request->company_id);
    }

    // $product_total = $query->count();
    $products = $query->get();

    $products->map(function ($pr) {
        $pr->data_file = $pr->data_file != null ? '/administrator/assets/media/products/' . $pr->data_file : img_src('default.jpg', '');
    });

    if($request->category_id == 'undefined'){
        return response()->json(['status'=> 406, 'message' => 'Not Acceptable'], 406); 
    }

    return response()->json([
        'status' => 200,
        'message' => 'You successfully completed loaded.',
        'data' => $products,
    ]);
}

    public function addToWishList(Request $request) {
        $data = $request->except(['_token', '_method']);

        $validator = Validator::make($request->all(),[
            'product_id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['status'=> 400, 'message' => 'Bad request', 'errors' => $validator->errors()], 400);
        }

        if (isset(auth()->user()->id)) {

            $check = Whishlist::where('customer_id', auth()->user()->id)
                ->where('product_id', $request->product_id)
                ->first();

            if ($check != "" || $check != null || !empty($check)) {
                $response = [ 'status' => true, 'data' => $data, 'insert' => false ];
                return $response;
            } else {
                $data['customer_id'] = auth()->user()->id;
                $whishlist = Whishlist::create($data, false);
                $wishlist_count = Whishlist::where('customer_id', auth()->user()->id)->count();
                $response = [ 'status' => true, 'data' => $whishlist, 'insert' => true, 'count' => $wishlist_count ];
                return $response;
            }

        } else {
            $response = [ 'status' => false, 'data' => $data ];
            return $response;
        }
    }

}
