<?php

namespace App\Http\Controllers\Frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use App\Models\Category;
use App\Models\Brands;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index() {
        $data['category'] = Category::all();
        return view('frontpage-schoko.products.product_category', compact('data'));
    }

    public function categoryDetail($id) {
        $query = Product::select(DB::raw('products.*, categories.name as category_name, brands.name as brand_name, SUM(product_variants.stock) as total_stock, MIN(product_variants.price) as min_price, product_variants.price, MAX(product_variants.price) as max_price, product_medias.data_file, COUNT(products.id) total_variant'))
            ->where('categories.id', $id)
            ->leftJoin(DB::raw('categories'), 'categories.id', '=', 'products.category_id')
            ->leftJoin(DB::raw('brands'), 'brands.id', '=', 'products.brand_id')
            ->leftJoin(DB::raw('product_variants'), 'products.id', '=', 'product_variants.product_id')
            ->leftJoin(DB::raw('product_medias'), 'products.id', '=', 'product_medias.product_id')
            ->groupBy('products.id');

        $products = $query->paginate(9);
        $categories = Category::where('status', true)->get();
        $brands = Brands::where('status', true)->get();

        return view("frontpage-schoko.products.products",compact("products", "categories", "brands"));
    }
}
