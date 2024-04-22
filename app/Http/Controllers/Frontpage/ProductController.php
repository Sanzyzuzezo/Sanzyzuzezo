<?php

namespace App\Http\Controllers\Frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brands;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\ProductVariant;
use App\Models\ProfileController;
use App\Models\Whishlist;
use App\Models\Post;
use App\Models\Promotion;
use App\Models\PromotionProduct;
use DataTables;
use Image;
use File;
use DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::select(DB::raw('products.*,
                categories.name as category_name,
                product_variants.id as variant_id,
                brands.name as brand_name,
                SUM(product_variants.stock) as total_stock,
                MIN(product_variants.price) as min_price,
                product_variants.price,
                MAX(product_variants.price) as max_price,
                MIN(promotion_price.price) AS min_discount_price,
                MAX(promotion_price.price) AS max_discount_price,
                MIN(promotion_price.price) AS after_discount_price,
                product_medias.data_file,
                (SELECT COUNT(product_variants.id) FROM product_variants WHERE product_variants.product_id = products.id) AS total_variant'
            ))
            // ->where(DB::raw('product_variants.stock', '>', 0))
            ->leftJoin(DB::raw('categories'), 'categories.id', '=', 'products.category_id')
            ->leftJoin(DB::raw('brands'), 'brands.id', '=', 'products.brand_id')
            ->leftJoin(DB::raw('product_variants'), 'products.id', '=', 'product_variants.product_id')
            ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
            ->leftJoin(DB::raw('promotion_products'), 'products.id', '=', 'promotion_products.product_id')
            ->leftJoinSub("SELECT products.id, product_variants.id AS variant_id, 
                COALESCE(( SELECT min(promotion_products.after_discount_price) AS dc_price FROM promotion_products
                LEFT JOIN promotions ON promotions.id=promotion_products.promotion_id
                WHERE promotions.start_date <= NOW()
                AND promotions.end_date >= NOW()
                AND promotion_products.product_variant_id = product_variants.id
                GROUP BY promotions.id
                HAVING SUM(promotion_products.promotion_stock) > 0
                ORDER BY 
                ( CASE  
                                WHEN promotions.type = 'flash_sale' THEN 1
                                WHEN promotions.type = 'reguler' THEN 2
                        END ) ASC, dc_price ASC
                LIMIT 1 ) , product_variants.price) AS price
                FROM products
                LEFT JOIN product_variants ON product_variants.product_id = products.id
                LEFT JOIN promotion_products ON promotion_products.product_variant_id = product_variants.id
                GROUP BY product_variants.id, products.id
                ORDER BY products.id ASC", 
            'promotion_price', 
            function($join)
            {
                $join->on('products.id', '=', 'promotion_price.id');
            })
            ->leftJoin(DB::raw('promotions'), function($join){
                $join->on('promotions.id', '=', 'promotion_products.promotion_id')
                ->where('promotions.start_date', '>=', date("Y-m-d H:i:s"))
                ->where('promotions.start_date', '<=', date("Y-m-d H:i:s"))
                ->where('promotions.end_date', '>=', date("Y-m-d H:i:s"))
                ->where('promotions.end_date', '<=', date("Y-m-d H:i:s"))
                ;
            })

            // ->whereBetween()
            ->groupBy(['products.id',"categories.name","product_variants.id","brands.name", "product_medias.data_file"]);

        date_default_timezone_set('Asia/Jakarta');
        $promotion = Promotion::select(DB::raw('promotions.*'))
            ->orderBy('promotions.created_at', 'DESC')
            ->where('start_date', '<=', date("Y-m-d H:i:s"))
            ->where('end_date', '>=', date("Y-m-d H:i:s"))
            ->where('status', 1)
            ->with("promotion_product")
            ->get();

        // return $query->get();
        if($request->has("categories")){
            $query->whereIn("products.category_id",$request->categories);
        }
        if($request->has("brands")){
            $query->whereIn("products.brand_id",$request->brands);
        }
        if($request->has("min_price")){
            if($request->min_price != ""){
                $query->where("product_variants.price", ">=", $request->min_price);
            }
        }
        if($request->has("max_price")){
            if($request->max_price != ""){
                $query->where("product_variants.price", "<=", $request->max_price);
            }
        }
        if($request->has("order_data")){
            $order_data = $request->order_data;
            switch($order_data){
                case 1:
                    $query->orderBy("products.category_id","ASC");
                break;
                case 2:
                    $query->orderBy("products.name","ASC");
                break;
                case 3:
                    $query->orderBy("products.name","DESC");
                break;
                case 4:
                    $query->orderBy("min_price","ASC");
                break;
                case 5:
                    $query->orderBy("min_price","DESC");
                break;
                default:
                break;
            }
        }
        // return $query->get();
        $products = $query->where('products.status', true)->paginate(6);
        // return $products;
        // $categories = Category::where('status', true)->get();
        $categories = Category::select(DB::raw('categories.*'))
                        ->leftJoin(DB::raw('products'), 'products.category_id', '=', 'categories.id')
                        ->whereNotNull('products.id')
                        ->where('categories.status', true)
                        ->groupBy('categories.id')
                        ->get();
        $brands = Brands::where('status', true)->get();

        if ($request->ajax()) {
            return view('frontpage-schoko.products.product_list', compact("products", "promotion", "categories", "brands"))->render();
        }

        return view("frontpage-schoko.products.products",compact("products", "promotion", "categories", "brands"));
    }

    public function getDetail(Request $request){
        $detail = Product::select(
            DB::raw(
                'products.*,
                categories.name as category_name,
                brands.name as brand_name,
                SUM(product_variants.stock) as total_stock,
                MIN(product_variants.price) as min_price,
                product_variants.price,
                MAX(product_variants.price) as max_price,
                product_medias.data_file,
                COUNT(products.id) total_variant'
            )
        )
        ->leftJoin(DB::raw('categories'), 'categories.id', '=', 'products.category_id')
        ->leftJoin(DB::raw('brands'), 'brands.id', '=', 'products.brand_id')
        ->where(["id" => $request->ix])
        ->with("images")
        ->with("variants")
        ->first();

        if (!$detail) {
            return abort(404);
        }
        return response()->json($detail);
    }

    public function getDetailVariant(Request $request){
        $detail = ProductVariant::select(
            DB::raw("
                product_variants.*,
                (
                    SELECT promotion_products.promotion_stock FROM promotion_products
                    LEFT JOIN promotions ON promotions.id=promotion_products.promotion_id
                    WHERE promotion_products.product_variant_id=product_variants.id
                    AND promotions.start_date <= NOW()
                    AND promotions.end_date >= NOW()
                    GROUP BY promotions.id
                    HAVING SUM(promotion_products.promotion_stock) > 0
                    ORDER BY 
                    ( CASE 
                                    WHEN  promotions.type = 'flash_sale' THEN 1
                                    WHEN  promotions.type = 'reguler' THEN 2
                            END ) ASC, promotion_products.after_discount_price ASC
                    LIMIT 1
                ) AS promotion_stock,
                (
                    SELECT promotion_products.after_discount_price FROM promotion_products
                    LEFT JOIN promotions ON promotions.id=promotion_products.promotion_id
                    WHERE promotion_products.product_variant_id=product_variants.id
                    AND promotions.start_date <= NOW()
                    AND promotions.end_date >= NOW()
                    GROUP BY promotions.id
                    HAVING SUM(promotion_products.promotion_stock) > 0
                    ORDER BY 
                    ( CASE 
                                    WHEN  promotions.type = 'flash_sale' THEN 1
                                    WHEN  promotions.type = 'reguler' THEN 2
                            END ) ASC, promotion_products.after_discount_price ASC
                    LIMIT 1
                ) AS promotion_price
            ")
        )
        ->where(["id" => $request->ix])->first();

        if (!$detail) {
            return abort(404);
        }

        return response()->json($detail);
    }

    public function detail(Request $request)
    {
        $detail = Product::select(
            DB::raw("
            products.*,
            categories.name as category_name,
            brands.name as brand_name,
            SUM(product_variants.stock) as total_stock,
            product_variants.price,
            promotion_products.after_discount_price,
            (
                SELECT promotion_products.after_discount_price AS dc_price FROM promotion_products
                LEFT JOIN promotions ON promotions.id=promotion_products.promotion_id
                WHERE promotions.start_date <= NOW()
                AND promotions.end_date >= NOW()
                AND promotion_products.product_variant_id = product_variants.id
                GROUP BY promotions.id, promotion_products.after_discount_price
                HAVING SUM(promotion_products.promotion_stock) > 0
                ORDER BY 
                ( CASE  
                            WHEN promotions.type = 'flash_sale' THEN 1
                            WHEN promotions.type = 'reguler' THEN 2
                        END ) ASC, dc_price ASC
                LIMIT 1
                )
                AS discount_price,
            (
                    SELECT SUM(promotion_products.promotion_stock) FROM promotion_products
                    LEFT JOIN promotions ON promotions.id=promotion_products.promotion_id
                    WHERE promotion_products.product_variant_id=product_variants.id
                    AND promotions.start_date <= NOW()
                    AND promotions.end_date >= NOW()
                    GROUP BY promotions.id, promotion_products.after_discount_price
                    HAVING SUM(promotion_products.promotion_stock) > 0
                    ORDER BY 
                    ( CASE  
                                WHEN promotions.type = 'flash_sale' THEN 1
                                WHEN promotions.type = 'reguler' THEN 2
                            END ) ASC, promotion_products.after_discount_price ASC
                    LIMIT 1
            ) as stock_promo")
        )
        ->leftJoin(DB::raw('categories'), 'categories.id', '=', 'products.category_id')
        ->leftJoin(DB::raw('brands'), 'brands.id', '=', 'products.brand_id')
        ->leftJoin(DB::raw('product_variants'), 'products.id', '=', 'product_variants.product_id')
        ->leftJoin(DB::raw('promotion_products'), 'products.id', '=', 'promotion_products.product_id')
        ->where(["products.id" => $request->slug])
        ->with("images")
        ->with("variants")
        ->groupBy(["products.id","categories.name","brands.name","product_variants.price","promotion_products.after_discount_price","product_variants.id"])
        ->first();

        date_default_timezone_set('Asia/Jakarta');

        $promotion = Promotion::select(DB::raw('promotions.*'))
            ->orderBy('promotions.created_at', 'DESC')
            ->where('start_date', '<=', date("Y-m-d H:i:s"))
            ->where('end_date', '>=', date("Y-m-d H:i:s"))
            ->where('status', 1)
            ->with("promotion_product")
            ->get();

        $new_products = Product::select(DB::raw('products.id'))
            ->orderBy('products.created_at', 'DESC')
            ->limit(4)
            ->get();

        // return $detail->variants;
        if (!$detail) {
            return abort(404);
        }

        $related_products = Product::select(DB::raw('products.*,
            categories.name as category_name,
            brands.name as brand_name,
            (SELECT SUM(product_variants.stock) FROM product_variants WHERE product_variants.product_id = products.id) as total_stock,
            MIN(product_variants.price) as min_price,
            MIN(product_variants.price) as price,
            MAX(product_variants.price) as max_price,
            MIN(promotion_price.price) AS min_discount_price,
            MAX(promotion_price.price) AS max_discount_price,
            MIN(promotion_price.price) AS after_discount_price,
            product_medias.data_file,
            (SELECT COUNT(product_variants.id) FROM product_variants WHERE product_variants.product_id = products.id) AS total_variant'
        ))
        // ->where(DB::raw('product_variants.stock', '>', 0))
        ->leftJoin(DB::raw('categories'), 'categories.id', '=', 'products.category_id')
        ->leftJoin(DB::raw('brands'), 'brands.id', '=', 'products.brand_id')
        ->leftJoin(DB::raw('product_variants'), 'products.id', '=', 'product_variants.product_id')
        ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
        ->leftJoinSub("SELECT products.id, product_variants.id AS variant_id, 
            COALESCE(( SELECT min(promotion_products.after_discount_price) AS dc_price FROM promotion_products
            LEFT JOIN promotions ON promotions.id=promotion_products.promotion_id
            WHERE promotions.start_date <= NOW()
            AND promotions.end_date >= NOW()
            AND promotion_products.product_variant_id = product_variants.id
            GROUP BY promotions.id
            HAVING SUM(promotion_products.promotion_stock) > 0
            ORDER BY 
            ( CASE  
                        WHEN promotions.type = 'flash_sale' THEN 1
                        WHEN promotions.type = 'reguler' THEN 2
                    END ) ASC, dc_price ASC
            LIMIT 1 ) , product_variants.price) AS price
            FROM products
            LEFT JOIN product_variants ON product_variants.product_id = products.id
            LEFT JOIN promotion_products ON promotion_products.product_variant_id = product_variants.id
            GROUP BY product_variants.id, products.id
            ORDER BY products.id ASC", 
        'promotion_price', 
        function($join)
        {
            $join->on('products.id', '=', 'promotion_price.id');
        })
        ->where("products.category_id",$detail->category_id)
        ->where("products.id", "!=",$detail->id)
        ->where("products.status", 1)
        ->groupBy(['products.id',"categories.name","brands.name","product_medias.data_file"])->take(4)->get();

        $categories = Category::select(DB::raw('categories.*, parent_categories.name as parent_name'))
            ->leftJoin(DB::raw('categories as parent_categories'), 'parent_categories.id', '=', 'categories.parent')
            ->whereNull('categories.parent')
            ->with('childCategories')->get();

        $query_news = Post::select(DB::raw('posts.*, post_categories.name as post_category_name'))
        ->leftJoin(DB::raw('post_categories'), 'post_categories.id', '=', 'posts.post_category_id')->where("posts.status", 1)
        ->orderBy("created_at", "DESC")
        ->limit(12);

        $news = $query_news->where('posts.post_category_id', 3)->get();

        return view("frontpage-schoko.products.product_detail",compact("detail", "promotion", "new_products", "related_products", "categories", "news"));
    }

    public function addToWishList(Request $request) {
        // 'customer_id', 'product_id'
        $data = $request->except(['_token', '_method']);

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

    public function addVariant(Request $request)
    {
        $detail = ProductVariant::select(
            DB::raw('
            product_variants.*,
            (
                SELECT promotion_products.after_discount_price AS dc_price FROM promotion_products
                LEFT JOIN promotions ON promotions.id=promotion_products.promotion_id
                WHERE promotions.start_date <= NOW()
                AND promotions.end_date >= NOW()
                AND promotion_products.product_variant_id = product_variants.id
                GROUP BY promotions.id
                HAVING SUM(promotion_products.promotion_stock) > 0
                ORDER BY 
                ( CASE promotions.type 
                                WHEN "flash_sale" THEN 1
                                WHEN "reguler" THEN 2
                        END ) ASC, dc_price ASC
                LIMIT 1
                )
                AS discount_price,
            (
                    SELECT SUM(promotion_products.promotion_stock) FROM promotion_products
                    LEFT JOIN promotions ON promotions.id=promotion_products.promotion_id
                    WHERE promotion_products.product_variant_id=product_variants.id
                    AND promotions.start_date <= NOW()
                    AND promotions.end_date >= NOW()
                    GROUP BY promotions.id
                    HAVING SUM(promotion_products.promotion_stock) > 0
                    ORDER BY 
                    ( CASE promotions.type 
                                    WHEN "flash_sale" THEN 1
                                    WHEN "reguler" THEN 2
                            END ) ASC, promotion_products.after_discount_price ASC
                    LIMIT 1
            ) as stock_promo
            ')
        )
        ->where(["product_id" => $request->product_id])->get();
        
        $detail->map(function($dt){
            $dt->harga = $dt->price;
            if($dt->discount_price != null){
                $dt->harga = $dt->discount_price;
            }
        }); 
        
        if (!$detail) {
            return abort(404);
        }
        return response()->json($detail);
    }

}
