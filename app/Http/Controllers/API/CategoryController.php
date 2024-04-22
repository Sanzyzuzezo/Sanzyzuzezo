<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Brands;
use App\Models\Product;
use Illuminate\Http\Request;
use DB;
use Validator;

class CategoryController extends Controller
{
    public function category(Request $request){
        $query = Category::whereNull('parent')->with('categories');

        $category = $query->paginate($request->limit);

        return response()->json([
            'status'=> 200,
            'message' => 'You successfully completed loaded.',
            'data' => $category,  
        ]);

    }

        public function index(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'limit' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 400);
        // }

        $categories = Category::all();
        if ($request->no_image === 'true') {
        }else{
            $categories->map(function ($categorie) {
                $categorie->image = $categorie->image != null ? '/administrator/assets/media/categories/' . $categorie->image : img_src('default.jpg', '');
            });
        }

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dimuat.',
            'data' => $categories,
        ]);
    }
    public function categoryDetail($id) {
        $query = Product::select(
            'products.*',
            'categories.name as category_name',
            'brands.name as brand_name',
            DB::raw('MIN(product_variants.price) as min_price'),
            DB::raw('MAX(product_variants.price) as max_price'),
            'product_medias.data_file',
            DB::raw('COUNT(products.id) as total_variant')
        )
        ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
        ->leftJoin('brands', 'brands.id', '=', 'products.brand_id')
        ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
        ->leftJoin('product_medias', 'products.id', '=', 'product_medias.product_id')
        ->where('categories.id', $id)
        ->groupBy('products.id', 'categories.name', 'brands.name', 'product_medias.data_file');
    
        $products = $query->paginate(9);
        $categories = Category::select('categories.*')->where('status', true)->where('categories.id', $id)->get();
        $brands = Brands::select('brands.*')
        ->leftJoin(DB::raw('products'), 'brands.id', '=', 'products.brand_id')
        ->leftJoin(DB::raw('categories'), 'categories.id', '=', 'products.category_id')
        ->where('brands.status', true)
        ->where('categories.id', $id)->get();

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
            'message' => 'You successfully completed loaded.',
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
    
}
