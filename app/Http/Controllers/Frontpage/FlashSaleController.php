<?php

namespace App\Http\Controllers\Frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Models\Banners;
use App\Models\Product;
use App\Models\Brands;
use App\Models\OrderItems;
use App\Models\Category;
use App\Models\Post;
use App\Models\Promotion;
use App\Models\PromotionProduct;
use Mail;
use App\Mail\OrderMail;
use DB;

class FlashSaleController extends Controller
{
    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $promotion = Promotion::select(DB::raw('promotions.*'))
                            ->orderBy('promotions.start_date', 'ASC')
                            ->where('type', 'flash_sale')
                            ->where('end_date', '>', date("Y-m-d H:i:s"))
                            ->where('status', 1)
                            ->with("promotion_product")
                            ->get();

        $flash_sale = PromotionProduct::select(
            DB::raw('
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
            (
                SELECT min(promotion_products.after_discount_price) FROM promotion_products
                LEFT JOIN promotions ON promotions.id=promotion_products.promotion_id
                WHERE promotions.start_date <= NOW()
                AND promotions.end_date >= NOW()
                AND promotion_products.product_id = products.id
            )
            AS min_discount_price,
            (
                SELECT max(promotion_products.after_discount_price) FROM promotion_products
                LEFT JOIN promotions ON promotions.id=promotion_products.promotion_id
                WHERE promotions.start_date <= NOW()
                AND promotions.end_date >= NOW()
                AND promotion_products.product_id = products.id
            )
            AS max_discount_price,
            (
                SELECT min(promotion_products.after_discount_price) FROM promotion_products
                LEFT JOIN promotions ON promotions.id=promotion_products.promotion_id
                WHERE promotions.start_date <= NOW()
                AND promotions.end_date >= NOW()
                AND promotion_products.product_id = products.id
            )
            AS after_discount_price,
            COUNT(products.id) total_variant,
            (
                SELECT SUM(promotion_products.promotion_stock) FROM promotion_products
                LEFT JOIN promotions ON promotions.id=promotion_products.promotion_id
                WHERE promotion_products.product_id=products.id
                AND promotions.start_date <= NOW()
                AND promotions.end_date >= NOW()
            ) AS stock_barang')
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
            ->where('products.status', 1)
            ->groupBy(
                'products.id', 'promotions.id', 'promotion_products.promotion_id',
                'promotion_products.promotion_stock', 'product_medias.data_file',
                'categories.name', 'stock.total_stock', 'product_variants.id'
            )
            ->get();

        return view("frontpage-schoko.flash_sale.index", compact("promotion", "flash_sale"));
    }

}
