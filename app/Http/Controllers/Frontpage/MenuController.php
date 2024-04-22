<?php

namespace App\Http\Controllers\Frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\Category;
use DataTables;
use Image;
use File;
use DB;

class MenuController extends Controller
{
    public function index(Request $request)
    {

        // return $request;

        $query_new_products = Product::select(DB::raw('
            products.*,
            product_medias.data_file as image,
            categories.name as category,
            SUM(product_variants.stock) as total_stock,
            product_variants.id as variant_id,
            MIN(product_variants.price) as min_price,
            MAX(product_variants.price) as max_price,
            product_variants.price,
            COUNT(products.id) total_variant,
            (SELECT SUM(product_variants.stock) FROM product_variants WHERE product_variants.product_id = products.id) AS stock_barang' )
        )
        ->orderBy('products.created_at', 'DESC')
        ->leftJoin(DB::raw('categories'), 'categories.id', '=', 'products.category_id')
        ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
        ->leftJoin(DB::raw('product_variants'), 'products.id', '=', 'product_variants.product_id')
        ->groupBy(['products.id',"product_medias.data_file","categories.name","product_variants.id"])
        ->limit(12);
        if($request->has("categories")){
            $query_new_products->whereIn("products.category_id",$request->categories);
        }

        $new_products = $query_new_products->where('products.status', true)->get();

        $query_event = Post::select(DB::raw('posts.*, post_categories.name as post_category_name'))
        ->leftJoin(DB::raw('post_categories'), 'post_categories.id', '=', 'posts.post_category_id')->where("posts.status", 1)
        ->orderBy("created_at", "DESC")
        ->limit(4);

        $events = $query_event->where('post_categories.name', 'like', '%event%')->get();

        $categories = Category::where('status', '1')->get();

        return view("frontpage-schoko.menu.menu", compact("categories", "events", "new_products"));

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
