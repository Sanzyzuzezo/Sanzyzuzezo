<?php

namespace App\Http\Controllers\API;

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
use App\Models\ProductMedia;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\PromotionProduct;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PromotionsController extends Controller
{
    public function flashSale(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $validator = Validator::make($request->all(),[
            'company_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
    
        $media = ProductMedia::select('product_id', DB::raw('data_file'));
    
        $query = Promotion::select(DB::raw('promotions.*'))
            ->orderBy('promotions.created_at', 'DESC')
            ->where('type', 'flash_sale')
            ->where('end_date', '>', now())
            ->where('status', 1)
            ->with(['promotion_product' => function ($variantsQuery) use ($media) {
                $variantsQuery
                    ->select('promotion_products.*', DB::raw('media.data_file AS media'), DB::raw('products.name AS products_name'), DB::raw('product_variants.name AS product_variants_name'))
                    ->leftJoin('products', 'promotion_products.product_id', '=', 'products.id')
                    ->leftJoin('product_variants', 'promotion_products.product_variant_id', '=', 'product_variants.id')
                    ->leftJoinSub($media, 'media', function ($join) {
                        $join->on('products.id', '=', 'media.product_id');
                    })
                    ->groupBy('promotion_products.id', 'products.id', 'media.data_file','products.name','product_variants.name');
            }])
            ->take(1);

            if ($request->company_id !== 0) {
                $query->where('promotions.company_id', $request->company_id);
            }
        
            $flash_sale = $query->get();
    
        $flash_sale->each(function ($pr) {
            $pr->promotion_product->each(function ($item) {
                $item->media = $item->media != null ? img_src($item->media, 'product') : img_src('default.jpg', '');
            });
        });

        $flash_sale->map(function ($fs) {
            $fs->image = $fs->image != null ? '/administrator/assets/media/banners/' . $fs->image: img_src('default.jpg', '');
        });

        if (!$flash_sale) {
            return response()->json(['status'=> 404, 'message' => 'Promo not avaliable'], 404);  
        }
    
        return response()->json([
            'status' => 200,
            'message' => 'You successfully completed loaded.',
            'flash_sale' => $flash_sale,
        ]);
    }

    public function reguler(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $validator = Validator::make($request->all(),[
            'company_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $media = ProductMedia::select('product_id', DB::raw('data_file'));
        
        $query = Promotion::select(DB::raw('promotions.*'))
            ->orderBy('promotions.created_at', 'DESC')
            ->where('type', 'reguler')
            ->where('end_date', '>', now())
            ->where('status', 1)
            ->with(['promotion_product' => function ($variantsQuery) use ($media) {
                $variantsQuery
                ->select('promotion_products.*', DB::raw('media.data_file AS media'), DB::raw('products.name AS products_name'), DB::raw('product_variants.name AS product_variants_name'))
                ->leftJoin('products', 'promotion_products.product_id', '=', 'products.id')
                ->leftJoin('product_variants', 'promotion_products.product_variant_id', '=', 'product_variants.id')
                    ->leftJoinSub($media, 'media', function ($join) {
                        $join->on('products.id', '=', 'media.product_id');
                    })
                    ->groupBy('promotion_products.id', 'products.id', 'media.data_file','products.name','product_variants.name');
            }])
            ->take(1);
            if ($request->company_id !== 0) {
                $query->where('promotions.company_id', $request->company_id);
            }
        
            $reguler = $query->get();

        $reguler->each(function ($pr) {
            $pr->promotion_product->each(function ($item) {
                $item->media = $item->media != null ? img_src($item->media, 'product') : img_src('default.jpg', '');
            });
        });

        $reguler->map(function ($r) {
            $r->image = $r->image != null ? '/administrator/assets/media/banners/' . $r->image: img_src('default.jpg', '');
        });

        if (!$reguler) {
            return response()->json(['status'=> 404, 'message' => 'Promo not avaliable'], 404);  
        }

        return response()->json([
            'status' => 200,
            'message' => 'You successfully completed loaded.',
            'reguler' => $reguler,
        ]);
    }

    public function ListPromosflashSale(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $validator = Validator::make($request->all(),[
            'company_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $media = ProductMedia::select('product_id', DB::raw('data_file'));
        
        $query = Promotion::select(DB::raw('promotions.*'))
            ->orderBy('promotions.created_at', 'DESC')
            ->where('type', 'flash_sale')
            ->where('end_date', '>', now())
            ->where('status', 1)
            ->with(['promotion_product' => function ($variantsQuery) use ($media) {
                $variantsQuery
                ->select('promotion_products.*', DB::raw('media.data_file AS media'), DB::raw('products.name AS products_name'), DB::raw('product_variants.name AS product_variants_name'))
                ->leftJoin('products', 'promotion_products.product_id', '=', 'products.id')
                ->leftJoin('product_variants', 'promotion_products.product_variant_id', '=', 'product_variants.id')
                    ->leftJoinSub($media, 'media', function ($join) {
                        $join->on('products.id', '=', 'media.product_id');
                    })
                    ->groupBy('promotion_products.id', 'products.id', 'media.data_file','products.name','product_variants.name');
            }]);

            if ($request->company_id !== 0) {
                $query->where('promotions.company_id', $request->company_id);
            }
        
            $flash_sale = $query->get();

        $flash_sale->each(function ($pr) {
            $pr->promotion_product->each(function ($item) {
                $item->media = $item->media != null ? img_src($item->media, 'product') : img_src('default.jpg', '');
            });
        });

        $flash_sale->map(function ($fs) {
            $fs->image = $fs->image != null ? '/administrator/assets/media/banners/' . $fs->image: img_src('default.jpg', '');
        });

        if (!$flash_sale) {
            return response()->json(['status'=> 404, 'message' => 'Promo not avaliable'], 404);  
        }

        return response()->json([
            'status' => 200,
            'message' => 'You successfully completed loaded.',
            'flash_sale' => $flash_sale,
        ]);
    }

    public function ListPromosReguler(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $validator = Validator::make($request->all(),[
            'company_id' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $media = ProductMedia::select('product_id', DB::raw('data_file'));
        
        $query = Promotion::select(DB::raw('promotions.*'))
            ->orderBy('promotions.created_at', 'DESC')
            ->where('type', 'reguler')
            ->where('end_date', '>', now())
            ->where('status', 1)
            ->with(['promotion_product' => function ($variantsQuery) use ($media) {
                $variantsQuery
                ->select('promotion_products.*', DB::raw('media.data_file AS media'), DB::raw('products.name AS products_name'), DB::raw('product_variants.name AS product_variants_name'))
                ->leftJoin('products', 'promotion_products.product_id', '=', 'products.id')
                ->leftJoin('product_variants', 'promotion_products.product_variant_id', '=', 'product_variants.id')
                    ->leftJoinSub($media, 'media', function ($join) {
                        $join->on('products.id', '=', 'media.product_id');
                    })
                    ->groupBy('promotion_products.id', 'products.id', 'media.data_file','products.name','product_variants.name');
            }])
            ->take(1);

            if ($request->company_id !== 0) {
                $query->where('promotions.company_id', $request->company_id);
            }
        
            $reguler = $query->get();
    
        $reguler->each(function ($pr) {
            $pr->promotion_product->each(function ($item) {
                $item->media = $item->media != null ? img_src($item->media, 'product') : img_src('default.jpg', '');
            });
        });
    
        $reguler->map(function ($r) {
            $r->image = $r->image != null ? '/administrator/assets/media/banners/' . $r->image: img_src('default.jpg', '');
        });

        if (!$reguler) {
            return response()->json(['status'=> 404, 'message' => 'Promo not avaliable'], 404);  
        }
        
        return response()->json([
            'status' => 200,
            'message' => 'You successfully completed loaded.',
            'reguler' => $reguler,
        ]);
    }

    public function flashSalePromoDetails(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $media = ProductMedia::select('product_id', DB::raw('data_file'));
        
        $flash_sale = Promotion::select(DB::raw('promotions.*'))
            ->orderBy('promotions.created_at', 'DESC')
            ->where('type', 'flash_sale')
            ->where('end_date', '>', now())
            ->where('status', 1)
            ->where('id', $id)
            ->with(['promotion_product' => function ($variantsQuery) use ($media) {
                $variantsQuery
                ->select('promotion_products.*', DB::raw('media.data_file AS media'), DB::raw('products.name AS products_name'), DB::raw('product_variants.name AS product_variants_name'))
                ->leftJoin('products', 'promotion_products.product_id', '=', 'products.id')
                ->leftJoin('product_variants', 'promotion_products.product_variant_id', '=', 'product_variants.id')
                    ->leftJoinSub($media, 'media', function ($join) {
                        $join->on('products.id', '=', 'media.product_id');
                    })
                    ->groupBy('promotion_products.id', 'products.id', 'media.data_file','products.name','product_variants.name');
            }])
            ->first();

            if ($flash_sale) {
                $flash_sale->promotion_product->each(function ($item) {
                    $item->media = $item->media != null ? img_src($item->media, 'product') : img_src('default.jpg', '');
                });
        
                $fs->image = $fs->image != null ? '/administrator/assets/media/banners/' . $fs->image: img_src('default.jpg', '');
            }
        
        return response()->json([
            'status' => 200,
            'message' => $flash_sale ? 'You successfully completed loaded.' : 'Promo not found.',
            'flash_sale' => $flash_sale,
        ]);
    }


    public function regulerPromoDetails(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $media = ProductMedia::select('product_id', DB::raw('data_file'));
        
        $reguler = Promotion::select(DB::raw('promotions.*'))
            ->orderBy('promotions.created_at', 'DESC')
            ->where('type', 'reguler')
            ->where('end_date', '>', now())
            ->where('status', 1)
            ->where('id', $id)
            ->with(['promotion_product' => function ($variantsQuery) use ($media) {
                $variantsQuery
                ->select('promotion_products.*', DB::raw('media.data_file AS media'), DB::raw('products.name AS products_name'), DB::raw('product_variants.name AS product_variants_name'))
                ->leftJoin('products', 'promotion_products.product_id', '=', 'products.id')
                ->leftJoin('product_variants', 'promotion_products.product_variant_id', '=', 'product_variants.id')
                    ->leftJoinSub($media, 'media', function ($join) {
                        $join->on('products.id', '=', 'media.product_id');
                    })
                    ->groupBy('promotion_products.id', 'products.id', 'media.data_file','products.name','product_variants.name');
            }])
            ->first();
    
            if ($reguler) {
                $reguler->promotion_product->each(function ($item) {
                    $item->media = $item->media != null ? img_src($item->media, 'product') : img_src('default.jpg', '');
                });
        
                $r->image = $r->image != null ? '/administrator/assets/media/banners/' . $r->image: img_src('default.jpg', '');
            }
        
        return response()->json([
            'status' => 200,
            'message' => $reguler ? 'You successfully completed loaded.' : 'Promo not found.',
            'reguler' => $reguler,
        ]);
    }
}