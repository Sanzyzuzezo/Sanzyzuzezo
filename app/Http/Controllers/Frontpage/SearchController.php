<?php

namespace App\Http\Controllers\Frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\PostCategory;
use App\Models\Post;
use DataTables;
use Image;
use File;
use DB;

class SearchController extends Controller
{
    public function index(Request $request)
    {

        // return $request;

        $query = Post::select(DB::raw('posts.*, post_categories.name as post_category_name'))
            ->leftJoin(DB::raw('post_categories'), 'post_categories.id', '=', 'posts.post_category_id');

        $query_product = Product::select(DB::raw('products.*,
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
                COUNT(products.id) total_variant'
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
            ->groupBy(['products.id',"categories.name","product_variants.id","brands.name","product_medias.data_file"]);

        if ($request->has("categories")) {
            $query->whereIn("posts.post_category_id", $request->categories);
        }

        if ($request->keywords != null || $request->keywords != ''){
            $query->whereRaw("title REGEXP ".DB::connection()->getPdo()->quote($request->keywords));
            $query_product->whereRaw("products.name REGEXP ".DB::connection()->getPdo()->quote($request->keywords));
        }

        $data = $query->where("posts.status", 1)->orderBy("created_at", "DESC")->paginate(10);
        $products = $query_product->where("products.status", 1)->orderBy("created_at", "DESC")->paginate(10);

        $categories = PostCategory::where('status', true)->get();

        if ($request->ajax()) {
            // return view('frontpage.search.product_list', compact("products"))->render();
            return view('frontpage-schoko.search.search_list', compact("data", "categories","products"))->render();
        }

        return view("frontpage-schoko.search.search", compact("data", "categories","products"));

    }

    public function detail(Request $request)
    {
        $detail = Post::where('slug', $request->slug)->first();
        if (!$detail) {
            return abort(404);
        }
        $recent_news = Post::where('status', true)->orderBy('created_at', 'DESC')->take(5)->get();
        $categories = PostCategory::where('status', true)->get();
        return view('frontpage-schoko.news.news_detail', compact("detail", "recent_news", "categories"));
    }
}
