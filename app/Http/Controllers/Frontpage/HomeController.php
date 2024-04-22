<?php

namespace App\Http\Controllers\Frontpage;

use DB;
use Mail;
use App\Models\Post;
use App\Models\Brands;
use App\Mail\OrderMail;
use App\Models\Banners;
use App\Models\Product;
use App\Models\Category;
use App\Models\Promotion;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\PromotionProduct;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $banners = Banners::where('status', true)->where('posisi_banner', 'atas')->get();
        $banners_kanan = Banners::where('status', true)->where('posisi_banner', 'kanan')->orderBy('created_at')->get();
        $banners_bawah = Banners::where('status', true)->where('posisi_banner', 'bawah')->orderBy('created_at', 'DESC')->get();

        date_default_timezone_set('Asia/Jakarta');
        $promotions = Promotion::select(DB::raw('promotions.*'))
                            ->orderBy('promotions.start_date', 'ASC')
                            ->where('type', 'flash_sale')
                            ->where('end_date', '>', date("Y-m-d H:i:s"))
                            ->where('status', 1)
                            ->limit(1)->get();

        $promotions->map(function($pr){
            $data_flash_sale = PromotionProduct::select(
                DB::raw("
                    products.*,
                    promotion_products.promotion_id,
                    promotion_products.promotion_stock,
                    product_medias.data_file as image,
                    categories.name as category,
                    stock.total_stock,
                    product_variants.id as variant_id,
                    MIN(product_variants.price) as min_price,
                    MAX(product_variants.price) as max_price,
                    product_variants.price,
                    MIN(promotion_price.price) AS min_discount_price,
                    MAX(promotion_price.price) AS max_discount_price,
                    MIN(promotion_price.price) AS after_discount_price,
                    COUNT(products.id) total_variant,
                    (
                        SELECT SUM(promotion_products.promotion_stock) FROM promotion_products
                        LEFT JOIN promotions ON promotions.id=promotion_products.promotion_id
                        WHERE promotion_products.product_id=products.id
                        AND promotions.start_date <= NOW()
                        AND promotions.end_date >= NOW()
                        GROUP BY promotions.id
                        HAVING
                    SUM ( promotion_products.promotion_stock ) > 0 
                    ORDER BY
                    CASE
			
                        WHEN promotions.TYPE = 'flash_sale' THEN
                        1 
                        WHEN promotions.TYPE = 'reguler' THEN
                        2 
                    END ASC,
                    MIN ( promotion_products.after_discount_price ) ASC 
                    LIMIT 1
                    ) AS stock_barang")
                )
                ->leftJoin(DB::raw('promotions'), 'promotions.id', '=', 'promotion_products.promotion_id')
                ->leftJoin(DB::raw('products'), 'products.id', '=', 'promotion_products.product_id')
                ->leftJoin(DB::raw('product_medias'), 'product_medias.product_id', '=', 'products.id')
                ->leftJoin(DB::raw('product_variants'), 'product_variants.product_id', '=', 'products.id')
                ->leftJoin(DB::raw('categories'), 'categories.id', '=', 'products.category_id')
                ->leftJoinSub('SELECT promotion_products.promotion_id, promotion_products.product_id, SUM(promotion_products.promotion_stock) total_stock
                    FROM promotion_products
                    GROUP BY promotion_products.product_id, promotion_products.promotion_id',
                    'stock',
                    function($join)
                    {
                        $join->on('promotions.id', '=', 'stock.promotion_id');
                        $join->on('products.id', '=', 'stock.product_id');
                    })
                   ->leftJoinSub("SELECT products.id, product_variants.id AS variant_id,
                    COALESCE(( SELECT min(promotion_products.after_discount_price) AS dc_price FROM promotion_products
                    LEFT JOIN promotions ON promotions.id=promotion_products.promotion_id
                    WHERE promotions.start_date <= NOW()
                    AND promotions.end_date >= NOW()
                    AND promotion_products.product_variant_id = product_variants.id

                    GROUP BY
				    promotions.ID 
                    HAVING
                        SUM ( promotion_products.promotion_stock ) > 0 
                    ORDER BY
                    CASE
                            
                            WHEN promotions.TYPE = 'flash_sale' THEN
                            1 
                            WHEN promotions.TYPE = 'reguler' THEN
                            2 
                        END ASC,
                        dc_price ASC 
                        LIMIT 1 
                    ),
                        product_variants.price 
                    ) AS price 
                    FROM products
                    LEFT JOIN product_variants ON product_variants.product_id = products.id
                    LEFT JOIN promotion_products ON promotion_products.product_variant_id = product_variants.id
                    GROUP BY product_variants.id, products.id, promotion_products.promotion_id
                    ORDER BY products.id ASC",
                    'promotion_price',
                    function($join)
                    {
                        $join->on('products.id', '=', 'promotion_price.id');
                    })
                    ->where('products.status', true)
                    ->groupBy(
                        'products.id', 'promotions.id', 'promotion_products.promotion_id',
                        'promotion_products.promotion_stock', 'product_medias.data_file',
                        'categories.name', 'stock.total_stock', 'product_variants.id'
                    );
            
                $pr->sales = $data_flash_sale->where('promotion_products.promotion_id', $pr->id)->limit(2)->get();
            });
        
        $promotions_reguler = Promotion::select(DB::raw('promotions.*'))
                            ->orderBy('promotions.start_date', 'ASC')
                            ->where('type', 'reguler')
                            ->where('end_date', '>', date("Y-m-d H:i:s"))
                            ->where('status', 1)
                            ->limit(1)->get();

        $promotions_reguler->map(function($pr){
            $data_reguler = PromotionProduct::select(
                DB::raw("
                    products.*,
                    promotion_products.promotion_id,
                    promotion_products.promotion_stock,
                    product_medias.data_file as image,
                    categories.name as category,
                    stock.total_stock,
                    product_variants.id as variant_id,
                    MIN(product_variants.price) as min_price,
                    MAX(product_variants.price) as max_price,
                    product_variants.price,
                    MIN(promotion_price.price) AS min_discount_price,
                    MAX(promotion_price.price) AS max_discount_price,
                    MIN(promotion_price.price) AS after_discount_price,
                    COUNT(products.id) total_variant,
                    (
                        SELECT SUM(promotion_products.promotion_stock) FROM promotion_products
                        LEFT JOIN promotions ON promotions.id=promotion_products.promotion_id
                        WHERE promotion_products.product_id=products.id
                        AND promotions.start_date <= NOW()
                        AND promotions.end_date >= NOW()
                        GROUP BY promotions.id
                        HAVING
                    SUM ( promotion_products.promotion_stock ) > 0 
                    ORDER BY
                    CASE
			
                        WHEN promotions.TYPE = 'reguler' THEN
                        1 
                    END ASC,
                    MIN ( promotion_products.after_discount_price ) ASC 
                    LIMIT 1
                    ) AS stock_barang")
                )
                ->leftJoin(DB::raw('promotions'), 'promotions.id', '=', 'promotion_products.promotion_id')
                ->leftJoin(DB::raw('products'), 'products.id', '=', 'promotion_products.product_id')
                ->leftJoin(DB::raw('product_medias'), 'product_medias.product_id', '=', 'products.id')
                ->leftJoin(DB::raw('product_variants'), 'product_variants.product_id', '=', 'products.id')
                ->leftJoin(DB::raw('categories'), 'categories.id', '=', 'products.category_id')
                ->leftJoinSub('SELECT promotion_products.promotion_id, promotion_products.product_id, SUM(promotion_products.promotion_stock) total_stock
                    FROM promotion_products
                    GROUP BY promotion_products.product_id, promotion_products.promotion_id',
                    'stock',
                    function($join)
                    {
                        $join->on('promotions.id', '=', 'stock.promotion_id');
                        $join->on('products.id', '=', 'stock.product_id');
                    })
                   ->leftJoinSub("SELECT products.id, product_variants.id AS variant_id,
                    COALESCE(( SELECT min(promotion_products.after_discount_price) AS dc_price FROM promotion_products
                    LEFT JOIN promotions ON promotions.id=promotion_products.promotion_id
                    WHERE promotions.start_date <= NOW()
                    AND promotions.end_date >= NOW()
                    AND promotion_products.product_variant_id = product_variants.id

                    GROUP BY
				    promotions.ID 
                    HAVING
                        SUM ( promotion_products.promotion_stock ) > 0 
                    ORDER BY
                    CASE
                            WHEN promotions.TYPE = 'reguler' THEN
                            1 
                        END ASC,
                        dc_price ASC 
                        LIMIT 1 
                    ),
                        product_variants.price 
                    ) AS price 
                    FROM products
                    LEFT JOIN product_variants ON product_variants.product_id = products.id
                    LEFT JOIN promotion_products ON promotion_products.product_variant_id = product_variants.id
                    GROUP BY product_variants.id, products.id, promotion_products.promotion_id
                    ORDER BY products.id ASC",
                    'promotion_price',
                    function($join)
                    {
                        $join->on('products.id', '=', 'promotion_price.id');
                    })
                    ->where('products.status', true)
                    ->groupBy(
                        'products.id', 'promotions.id', 'promotion_products.promotion_id',
                        'promotion_products.promotion_stock', 'product_medias.data_file',
                        'categories.name', 'stock.total_stock', 'product_variants.id'
                    );
            
                $pr->sales = $data_reguler->where('promotion_products.promotion_id', $pr->id)->limit(2)->get();
            });
        // if($promotion != ''){
        //     $flash_sale = $data_flash_sale->where('promotion_products.promotion_id', $promotion->id)->get();
        // }else{
            // $flash_sale = $data_flash_sale->get();
        // }


        $query_new_products = Product::select(
            DB::raw('
            products.*,
            product_medias.data_file as image,
            categories.name as category,
            SUM(CAST(stock.stock AS DECIMAL)) as total_stock,
            product_variants.id as variant_id,
            MIN(product_variants.price) as min_price,
            MAX(product_variants.price) as max_price,
            product_variants.price,
            MIN(promotion_price.price) AS min_discount_price,
            MAX(promotion_price.price) AS max_discount_price,
            MIN(promotion_price.price) AS after_discount_price,
            (
                SELECT SUM(promotion_products.promotion_stock) FROM promotion_products
                WHERE promotion_products.product_id=products.id
            ) as promotion_stock,
            (SELECT COUNT(product_variants.id) FROM product_variants WHERE product_variants.product_id = products.id) AS total_variant,
            (SELECT SUM(CAST(stock.stock AS DECIMAL)) FROM stock WHERE product_variants.product_id = products.id) AS stock_barang')
        )
            ->orderBy('products.created_at', 'DESC')
            ->leftJoin(DB::raw('categories'), 'categories.id', '=', 'products.category_id')
            ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
            ->leftJoin(DB::raw('product_variants'), 'products.id', '=', 'product_variants.product_id')
            ->leftJoin(DB::raw('stock'), 'product_variants.id', '=', 'stock.item_variant_id')
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
            ->where('products.show_new_product', 1)
            ->groupBy(["products.id","product_medias.data_file","categories.name","product_variants.id"])
            ->limit(4);
        if ($request->has("categories")) {
            $query_new_products->whereIn("products.category_id", $request->categories);
        }

        $new_products = $query_new_products->where('products.status', true)->get();

        // return $new_products;

        $query_best_sellers = OrderItems::select(DB::raw(
                "products.*,
                product_medias.data_file as image,
                categories.name as category,
                SUM(CAST(stock.stock AS DECIMAL)) as total_stock,
                product_variants.id as variant_id,
                MIN(product_variants.price) as min_price,
                MAX(product_variants.price) as max_price,
                product_variants.price,
                (
                    SELECT min(promotion_products.after_discount_price) AS dc_price FROM promotion_products
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
                    LIMIT 1
                )
                AS min_discount_price,
                (
                    SELECT max(promotion_products.after_discount_price) AS dc_price FROM promotion_products
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
                    LIMIT 1
                )
                AS max_discount_price,
                (
                    SELECT min(promotion_products.after_discount_price) AS dc_price FROM promotion_products
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
                    LIMIT 1
                )
                AS after_discount_price,
                (SELECT SUM(CAST(stock.stock AS DECIMAL)) FROM stock WHERE product_variants.product_id = products.id) AS stock_barang"
        ))
            ->leftJoin(DB::raw('products'), 'order_items.product_id', '=', 'products.id')
            ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
            ->leftJoin(DB::raw('product_variants'), 'products.id', '=', 'product_variants.product_id')
            ->leftJoin(DB::raw('stock'), 'product_variants.id', '=', 'stock.item_variant_id')
            ->leftJoin(DB::raw('promotion_products'), 'products.id', '=', 'promotion_products.product_id')
            ->leftJoin(DB::raw('categories'), 'categories.id', '=', 'products.category_id')
            ->groupBy(["products.id","product_medias.data_file","categories.name","product_variants.id"])
            ->limit(12);
        if ($request->has("categories")) {
            $query_best_sellers->whereIn("products.category_id", $request->categories);
        }

        $best_sellers = $query_best_sellers->where('products.status', true)->get();

        // $categories = Category::where('status', true)->get();
        $categories = Category::select(DB::raw('categories.*'))
            ->leftJoin(DB::raw('products'), 'products.category_id', '=', 'categories.id')
            ->whereNotNull('products.id')
            ->where('categories.status', true)
            ->groupBy('categories.id')
            ->get();
        $brands = Brands::where('status', true)->get();

        if ($request->has("categories")) {
            $query_new_products->whereIn("products.category_id", $request->categories);
        }

        $query_news = Post::select(DB::raw('posts.*, post_categories.name as post_category_name'))
            ->leftJoin(DB::raw('post_categories'), 'post_categories.id', '=', 'posts.post_category_id')->where("posts.status", 1)
            ->orderBy("created_at", "DESC")
            ->limit(4);

        $news = $query_news->where('posts.post_category_id', 3)->get();

        // echo($news);
        // exit();

        if ($request->ajax()) {
            return view('frontpage-schoko.home.product_list', compact("banners", "promotions","promotions_reguler", "new_products", "best_sellers", "categories", "brands", "news"))->render();
        }

        return view("frontpage-schoko.home.home", compact("banners", "promotions","promotions_reguler", "new_products", "best_sellers", "categories", "brands", "news", "banners_kanan", "banners_bawah"));
    }

    public function changeLanguage(Request $request)
    {
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);
    }

    public function getProducts(Request $request)
    {
        $category = $request->category;

        $query_new_products = Product::select(DB::raw('products.*, product_medias.data_file as image, MIN(product_variants.price) as min_price, MAX(product_variants.price) as max_price'))
            ->orderBy('products.created_at', 'DESC')
            ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
            ->leftJoin(DB::raw('product_variants'), 'products.id', '=', 'product_variants.product_id')
            ->groupBy('products.id')
            ->limit(12);
        if ($request->category != null) {
            $new_products = $query_new_products->where("products.category_id", $category)->get();
        } else {
            $new_products = $query_new_products->get();
        }

        $output = [
            'product_list'   => $new_products
        ];
        return response()->json($output);
    }

    public function testEmail()
    {
        $toEmail = "sepraha@gmail.com";
        $data    = [
            "message" => 'Hallo Sepraha this is a testing e-mail',
            "link" => url('admin/orders')
        ];
        Mail::to($toEmail)->send(new OrderMail($data));
    }
}
