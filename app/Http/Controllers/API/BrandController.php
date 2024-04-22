<?php

namespace App\Http\Controllers\API;

use File;
use DB;
use App\Models\Category;
use App\Models\Brands;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{

    public function brands(Request $request) {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $brands = Brands::where('company_id', $request->company_id)->get();
    
        if ($request->no_image === 'true') {
        } else {
            $brands->map(function ($brand) {
                $brand->image = $brand->image != null ? '/administrator/assets/media/brands/' . $brand->image : img_src('default.jpg', '');
            });
        }
        
    
        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dimuat.',
            'data' => $brands,
        ]);
    }
    

    public function brandDetails($id) {
        $query = Product::select(DB::raw('products.*, categories.name as category_name, brands.name as brand_name, SUM(product_variants.stock) as total_stock, MIN(product_variants.price) as min_price, product_variants.price, MAX(product_variants.price) as max_price, product_medias.data_file, COUNT(products.id) total_variant'))
            ->where('brands.id', $id)
            ->leftJoin(DB::raw('categories'), 'categories.id', '=', 'products.brand_id')
            ->leftJoin(DB::raw('brands'), 'brands.id', '=', 'products.brand_id')
            ->leftJoin(DB::raw('product_variants'), 'products.id', '=', 'product_variants.product_id')
            ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
            ->groupBy('products.id','categories.id','brands.id','product_variants.price','product_medias.data_file');

        $products = $query->paginate(9);
        $categories = Category::select('categories.*')
                                ->leftJoin(DB::raw('products'), 'categories.id', '=', 'products.category_id')
                                ->leftJoin(DB::raw('brands'), 'brands.id', '=', 'products.brand_id')
                                ->where('categories.status', true)
                                ->where('brands.id', $id)
                                ->get();
        $brands = Brands::select('brands.*')
                          ->where('status', true)
                          ->where('brands.id', $id)->get();
        $products->map(function ($product) {
            $product->data_file = $product->data_file != null ? '/administrator/assets/media/products/' . $product->data_file : img_src('default.jpg', '');
        });
        $brands->map(function ($brand) {
            $brand->image = $brand->image != null ? '/administrator/assets/media/brands/' . $brand->image : img_src('default.jpg', '');
        });
        $categories->map(function ($categorie) {
            $categorie->image = $categorie->image != null ? '/administrator/assets/media/categories/' . $categorie->image : img_src('default.jpg', '');
        });

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dimuat.',
            'brands' => $brands,
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}