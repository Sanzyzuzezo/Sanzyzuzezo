<?php

namespace App\Http\Controllers\Administrator;

use DB;
use File;
use Image;
use Response;
use DataTables;
use App\Models\Unit;
use App\Models\Brands;
use App\Models\Company;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductMedia;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Imports\ProductsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ItemsController extends Controller
{
    private static $module = "items";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        $company_id = getCompanyId();
        $query = Category::orderBy('id', 'asc');

        if ($company_id != 0) {
            $query->where("categories.company_id", $company_id);
        }

        $category = $query->get();

        return view("administrator.items.index", compact('category'));
    }

    public function getData(Request $request)
    {
        $company_id = getCompanyId();

        $query = Product::select(DB::raw('products.*, categories.name as category_name, brands.name as brand_name, SUM(CAST(stock.stock AS DECIMAL)) as total_stock, (SELECT data_file FROM product_medias WHERE product_id = products.id ORDER BY id DESC LIMIT 1) as data_file'))
        ->leftJoin(DB::raw('categories'), 'categories.id', '=', 'products.category_id')
        ->leftJoin(DB::raw('brands'), 'brands.id', '=', 'products.brand_id')
        ->leftJoin(DB::raw('product_variants'), 'products.id', '=', 'product_variants.product_id')
        ->leftJoin(DB::raw('stock'), 'product_variants.id', '=', 'stock.item_variant_id')
        ->groupBy(['products.id', 'categories.name', 'brands.name'])
        ->orderBy('products.created_at', 'DESC');


        if ($company_id != 0) {
            $query->where("products.company_id", $company_id);
        }

        if($request->category != ""){
            $query->where('products.category_id', $request->category);
        }    

        if ($request->status != "") {
            $status = $request->status == "active" ? 1 : 0;
            $query->where("products.status", $status);
        }
    
        $data = $query->get();
        // dd($data);

        return DataTables::of($data)
            // ->addColumn('name_package', function ($row) {
            //     $name_package = '<div class="d-flex align-items-center"><a href="' . route('admin.items.detail', $row->id) . '" class="symbol symbol-50px"><span class="symbol-label" style="background-image:url(' . asset('storage/administrator/assets/media/products/'.$row->data_file).'"></span></a><div class="ms-5"><a href="' . route('admin.items.detail', $row->id) . '" class="text-gray-800 text-hover-primary fs-5 fw-bolder" data-kt-ecommerce-product-filter="product_name">' . $row->name . '</a></div></div>';
            //     return $name_package;
            // })
            ->addColumn('name_package', function ($row) {
                $name_package = '<div class="d-flex align-items-center"><a href="' . route('admin.items.detail', $row->id) . '" class="symbol symbol-50px"><span class="symbol-label" style="background-image:url(' . img_src($row->data_file, "product") . ');"></span></a><div class="ms-5"><a href="' . route('admin.items.detail', $row->id) . '" class="text-gray-800 text-hover-primary fs-5 fw-bolder" data-kt-ecommerce-product-filter="product_name">' . $row->name . '</a></div></div>';
                return $name_package;
            })
            ->addColumn('status', function ($row) {
                if ($row->status) {
                    $status = '<div class="badge badge-light-success mb-5">Active</div>';
                    $status .= '<div class="form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input h-20px w-30px changeStatus" data-ix="' . $row->id . '" type="checkbox" value="1"
                        name="status" checked="checked" />
                    <label class="form-check-label fw-bold text-gray-400 ms-3"
                        for="status"></label>
                </div>';
                } else {
                    $status = '<div class="badge badge-light-danger mb-5">Inactive</div>';
                    $status .= '<div class="form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input h-20px w-30px changeStatus" data-ix="' . $row->id . '" type="checkbox" value="1"
                        name="status"/>
                    <label class="form-check-label fw-bold text-gray-400 ms-3"
                        for="status"></label>
                </div>';
                }
                return $status;
            })
            ->addColumn('action', function ($row) {
                $btn = "";
                if (isAllowed(static::$module, "detail")) : //Check permission
                    $btn .= '<a href="' . route('admin.items.detail', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                    <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/><path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/></svg>
                    </span>
                </a>';
                endif;
                if (isAllowed(static::$module, "duplicate")) : //Check permission
                    $btn .= '
                <a href="' . route('admin.items.duplicate', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                    <!--begin::Svg Icon | path: assets/media/icons/duotune/general/gen054.svg-->
                    <span class="svg-icon svg-icon-muted svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.5"
                                d="M18 2H9C7.34315 2 6 3.34315 6 5H8C8 4.44772 8.44772 4 9 4H18C18.5523 4 19 4.44772 19 5V16C19 16.5523 18.5523 17 18 17V19C19.6569 19 21 17.6569 21 16V5C21 3.34315 19.6569 2 18 2Z"
                                fill="black" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M14.7857 7.125H6.21429C5.62255 7.125 5.14286 7.6007 5.14286 8.1875V18.8125C5.14286 19.3993 5.62255 19.875 6.21429 19.875H14.7857C15.3774 19.875 15.8571 19.3993 15.8571 18.8125V8.1875C15.8571 7.6007 15.3774 7.125 14.7857 7.125ZM6.21429 5C4.43908 5 3 6.42709 3 8.1875V18.8125C3 20.5729 4.43909 22 6.21429 22H14.7857C16.5609 22 18 20.5729 18 18.8125V8.1875C18 6.42709 16.5609 5 14.7857 5H6.21429Z"
                                fill="black" />
                        </svg></span>
                    <!--end::Svg Icon-->
                </a>
                &nbsp;';
                endif;
                if (isAllowed(static::$module, "edit")) : //Check permission
                    $btn .= '<a href="' . route('admin.items.edit', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                    <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                        </svg>
                    </span>
                </a>';
                endif;
                if (isAllowed(static::$module, "delete")) : //Check permission
                    $btn .= '<a href="#" data-ix="' . $row->id . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete">
                    <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                        </svg>
                    </span>
                </a>';
                endif;
                return $btn;
            })
            ->addColumn('total_stock', function ($row) {
                $btn = '<span class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 updateStock" data-ix="' . $row->id . '">
                <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/>
                        <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/>
                    </svg>
                </span>
            </span>';
                return $btn;
            })
            ->rawColumns(['name_package', 'child', 'total_stock', 'status', 'action'])->make(true);
    }

    public function getMaxProduct()
    {
        $company_id = getCompanyId();
        if (($company_id != 0)) {
        $company    = Company::where('id', $company_id)->first();
        $max_product   = $company->max_product;

            return $max_product;
        } else {
            return 0;
        }
    }

    public function add()
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $company_id = getCompanyId();
        $query_categories = Category::where("categories.status", 1);
        if ($company_id != 0) {
            $query_categories->where("categories.company_id", $company_id);
        }
        $categories = $query_categories->get();
        
        $query_brands = Brands::orderBy('id', 'asc');
        if ($company_id != 0) {
            $query_brands->where("brands.company_id", $company_id);
        }
        $brands = $query_brands->get();
        
        $query_units = Unit::where("status", 1);
        if ($company_id != 0) {
            $query_units->where("units.company_id", $company_id);
        }
        $units = $query_units->get();
        return view("administrator.items.add", compact("categories", "brands", "units"));
    }

    public function save(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $company_id           = getCompanyId();
        $max_product          = $this->getMaxProduct();
        $product_company      = Product::where('company_id', $company_id)->get();
        $cek_max_product      = COUNT($product_company);

        $this->validate($request, [
            'category'  => 'required',
            'name'      => 'required'
        ]);
 
        if ($cek_max_product == $max_product) {
            session()->flash('warning', 'Gagal, Jumlah product sudah melebihi batas maksimal.');
            return redirect(route('admin.items'));
        } else {    
        $data = [
            'brand_id'      => $request->brand,
            'category_id'   => $request->category,
            'name'          => $request->name,
            'description'   => $request->description ? $request->description : "-",
            'status'        => $request->has('status') ? 1 : 0,
            'company_id'    => $company_id,
        ];
        $product = Product::create($data);
        }

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $no = 1;
            foreach ($images as $image) {

                $fileName  = Str::slug(strtolower($request->name)) . "_" . $no . "_" . time() . '.' . $image->getClientOriginalExtension();
                $path = upload_path('product') . $fileName;
                // if (!is_dir(storage_path("app/public/administrator/assets/media/products"))) {
                //     mkdir(storage_path("app/public/administrator/assets/media/products"), 0775, true);
                // }
                // Image::make($image->getRealPath())->resize(500, 500)->save(storage_path("app/public/administrator/assets/media/products/".$fileName), 100);
                Image::make($image->getRealPath())->resize(500, 500)->save($path, 100);
                $product->images()->create([
                    'data_file' => $fileName,
                    'type'      => 'image',
                    'main'      =>  $no == 1 ? true : false,
                ]);
                $no++;
            }
        }

        if ($request->has('variants')) {
            $variants = $request->variants;
            $no = 1;
            foreach ($variants as $variant) {
                $price = str_replace(',', '', $variant['price']);
                $discount_price = str_replace(',', '', $variant['discount_price']);
                $weight = str_replace(',', '', $variant['weight']);
                $minimal_stock = str_replace(',', '', $variant['minimal_stock']);
                // $stock = str_replace(',', '', $variant['stock']);
                $product->variants()->create([
                    'sku'                 => $variant['sku'],
                    'name'                => $variant['name'],
                    'unit_id'             => $variant['unit'],
                    'sale'                => isset($variant['sale']) ? true : false,
                    'bought'              => isset($variant['bought']) ? true : false,
                    'ingredient'          => isset($variant['ingredient']) ? true : false,
                    'show_online_shop'    => isset($variant['show_online_shop']) ? true : false,
                    'show_pos'            => isset($variant['show_pos']) ? true : false,
                    'production'          => isset($variant['production']) ? true : false,
                    'price'               => floatval($price),
                    'discount_price'      => floatval($discount_price),
                    'weight'              => floatval($weight),
                    'dimensions'          => json_encode(["length" => str_replace(',', '', $variant['dimensions']['length']), "width" => str_replace(',', '', $variant['dimensions']['width']), "height" => str_replace(',', '', $variant['dimensions']['height'])]),
                    'minimal_stock'       => floatval($minimal_stock),
                    // 'stock'               => floatval($stock),
                    'status'              => true,
                ]);
            }
        }

        //Write log
        createLog(static::$module, __FUNCTION__, $product->id);

        return redirect(route('admin.items'));
    }

    public function detail($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $detail = Product::where(["id" => $id])->with("images")->with("variants")->first();
        if (!$detail) {
            return abort(404);
        }

        $company_id = getCompanyId();
        $query_categories = Category::where("categories.status", 1);
        if ($company_id != 0) {
            $query_categories->where("categories.company_id", $company_id);
        }
        $categories = $query_categories->get();
        
        $query_brands = Brands::orderBy('id', 'asc');
        if ($company_id != 0) {
            $query_brands->where("brands.company_id", $company_id);
        }
        $brands = $query_brands->get();
        
        $query_units = Unit::where("status", 1);
        if ($company_id != 0) {
            $query_units->where("units.company_id", $company_id);
        }
        $units = $query_units->get();

        return view("administrator.items.detail", compact("categories", "brands", "detail", "units"));
    }

    public function edit($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $edit = Product::where(["id" => $id])->with("images")->with("variants")->first();

        if (!$edit) {
            return abort(404);
        }

        $company_id = getCompanyId();
        $query_categories = Category::where("categories.status", 1);
        if ($company_id != 0) {
            $query_categories->where("categories.company_id", $company_id);
        }
        $categories = $query_categories->get();
        
        $query_brands = Brands::orderBy('id', 'asc');
        if ($company_id != 0) {
            $query_brands->where("brands.company_id", $company_id);
        }
        $brands = $query_brands->get();
        
        $query_units = Unit::where("status", 1);
        if ($company_id != 0) {
            $query_units->where("units.company_id", $company_id);
        }
        $units = $query_units->get();

        return view("administrator.items.edit", compact("categories", "brands", "edit", "units"));
    }

    public function update(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $company_id = getCompanyId();

        $this->validate($request, [
            'category'  => 'required',
            'name'      => 'required'
        ]);

        //dd($request);
        $id = $request->id;

        $data = [
            'brand_id'      => $request->brand,
            'category_id'   => $request->category,
            'name'          => $request->name,
            'description'   => $request->description ? $request->description : "-",
            'status'        => $request->has('status') ? 1 : 0,
            'company_id'    => $company_id,

        ];

        $product = Product::where(["id" => $id])->update($data);

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $no = 1;
            foreach ($images as $image) {

                $fileName  = Str::slug(strtolower($request->name)) . "_" . $no . "_" . time() . '.' . $image->getClientOriginalExtension();
                $path = upload_path('product') . $fileName;
                // if (!is_dir(storage_path("app/public/administrator/assets/media/products"))) {
                //     mkdir(storage_path("app/public/administrator/assets/media/products"), 0775, true);
                // }
                // Image::make($image->getRealPath())->resize(500, 500)->save(storage_path("app/public/administrator/assets/media/products/".$fileName), 100);
                Image::make($image->getRealPath())->resize(500, 500)->save($path, 100);
                ProductMedia::create([
                    'product_id'    => $id,
                    'data_file'     => $fileName,
                    'type'          => 'image',
                    'main'          =>  $no == 1 ? true : false,
                ]);
                $no++;
            }
        }

        if ($request->has('image_delete') && $request->image_delete !== "") {
            $id_images = explode(',', $request->image_delete);
            $id_images = array_filter($id_images, 'strlen');
            if (count($id_images) > 0) {
                $files = ProductMedia::whereIn('id', $id_images)->get()->pluck('data_file')->filter(function ($value, $key) {
                    return !filter_var($value, FILTER_VALIDATE_URL);
                })->map(function ($image) {
                    return upload_path('product', $image);
                })->toArray();
                File::delete($files);
                ProductMedia::destroy($id_images);
            }
        }

        if ($request->has('variants')) {
            $variants = $request->variants;
            $variants_id = collect($request->variants)->pluck('id');
            
            foreach ($variants as $variant) {
                $price = str_replace(',', '', $variant['price']);
                $discount_price = str_replace(',', '', $variant['discount_price']);
                $weight = str_replace(',', '', $variant['weight']);
                $minimal_stock = str_replace(',', '', $variant['minimal_stock']);
                // $stock = str_replace(',', '', $variant['stock']);
                $variant_id = $variant['id'];
                $data_update = [
                    'product_id'          => $id,
                    'sku'                 => $variant['sku'],
                    'name'                => $variant['name'],
                    'unit_id'             => $variant['unit'],
                    'sale'                => isset($variant['sale']) ? true : false,
                    'bought'              => isset($variant['bought']) ? true : false,
                    'ingredient'          => isset($variant['ingredient']) ? true : false,
                    'show_online_shop'    => isset($variant['show_online_shop']) ? true : false,
                    'show_pos'            => isset($variant['show_pos']) ? true : false,
                    'production'          => isset($variant['production']) ? true : false,
                    'price'               => floatval($price),
                    'discount_price'      => floatval($discount_price),
                    'weight'              => floatval($weight),
                    'dimensions'          => json_encode(["length" => str_replace(',', '', $variant['dimensions']['length']), "width" => str_replace(',', '', $variant['dimensions']['width']), "height" => str_replace(',', '', $variant['dimensions']['height'])]),
                    'minimal_stock'       => floatval($minimal_stock),
                    // 'stock'               => floatval($stock),
                    'status'              => true,
                ];

                if ($variant_id == "") {
                    ProductVariant::create($data_update);
                } else {
                    ProductVariant::where(["id" => $variant_id])->update($data_update);
                }
            }
            ProductVariant::whereNotIn('id', $variants_id)->where('product_id', $id)->delete();
        }

        //Write log
        createLog(static::$module, __FUNCTION__, $id);

        return redirect(route('admin.items'));
    }

    public function delete(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        $id = $request->ix;
        $product = Product::find($id);
        
        $files = ProductMedia::where('product_id', $id)->get()->pluck('image')->filter(function ($value, $key) {
            return !filter_var($value, FILTER_VALIDATE_URL);
        })->map(function ($image) {
            return upload_path('product', $image);
        })->toArray();
        File::delete($files);
        
        $productMedias = $product->images;
        $productVariants = $product->variants;
        $deletedBy = auth()->user() ? auth()->user()->id : '';

        foreach ($productMedias as $medias) {
            $medias->deleted_by = $deletedBy;
            $medias->update();
            $medias->delete();
        }
        foreach ($productVariants as $variants) {
            $variants->deleted_by = $deletedBy;
            $variants->update();
            $variants->delete();
        }

        $product->deleted_by = $deletedBy;
        $product->update();
        $product->delete();

        //Write log
        createLog(static::$module, __FUNCTION__, $id);
        return response()->json(['message' => 'Product has been deleted.']);
    }

    public function duplicate($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "duplicate")) {
            abort(403);
        }

        $company_id = getCompanyId();

        $edit = Product::where(["id" => $id])->where("company_id", $company_id)->with("images")->with("variants")->first();
        if (!$edit) {
            return abort(404);
        }
        $company_id = getCompanyId();
        $query_categories = Category::where("categories.status", 1);
        if ($company_id != 0) {
            $query_categories->where("categories.company_id", $company_id);
        }
        $categories = $query_categories->get();
        
        $query_brands = Brands::orderBy('id', 'asc');
        if ($company_id != 0) {
            $query_brands->where("brands.company_id", $company_id);
        }
        $brands = $query_brands->get();
        
        $query_units = Unit::where("status", 1);
        if ($company_id != 0) {
            $query_units->where("units.company_id", $company_id);
        }
        $units = $query_units->get();

        return view("administrator.items.duplicate", compact("categories", "brands", "edit", "units"));
    }

    public function doDuplicate(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "duplicate")) {
            abort(403);
        }

        $company_id = getCompanyId();

        $this->validate($request, [
            'category'  => 'required',
            'name'      => 'required'
        ]);

        //dd($request);
        $duplicate_product = $request->id;
        $data = [
            'brand_id'      => $request->brand,
            'category_id'   => $request->category,
            'name'          => $request->name,
            'description'   => $request->description ? $request->description : "-",
            'status'        => $request->has('status') ? 1 : 0,
            'company_id'    => $company_id,
        ];


        $product = Product::create($data);
// dd($request);
        if ($request->image_delete != null) {
            $id_images = explode(',', $request->image_delete);
    // dd($id_images);
            if (!empty($id_images)) {
                $data_image = ProductMedia::whereNotIn('id', $id_images)
                    ->where('product_id', $duplicate_product)
                    ->get();
                $no = 1;
                foreach ($data_image as $image) {
                    $oldPath = "./administrator/assets/media/products/" . $image->data_file;

                    $fileExtension = File::extension($oldPath);
                    $newName = Str::slug(strtolower($request->name)) . "_" . $no . "_" . time() . '.' . $fileExtension;
                    $newPathWithName = "./administrator/assets/media/products/" . $newName;

                    if (File::copy($oldPath, $newPathWithName)) {
                        $product->images()->create([
                            'data_file' =>  $newName,
                            'type'      =>  'image',
                            'main'      =>  $no == 1 ? true : false,
                        ]);
                    }
                    $no++;
                }
            }
        }

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $no = 1;
            foreach ($images as $image) {

                $fileName  = Str::slug(strtolower($request->name)) . "_" . $no . "_" . time() . '.' . $image->getClientOriginalExtension();
                $path = upload_path('product') . $fileName;
                // if (!is_dir(storage_path("app/public/administrator/assets/media/products"))) {
                //     mkdir(storage_path("app/public/administrator/assets/media/products"), 0775, true);
                // }
        
                // Image::make($image->getRealPath())->resize(500, 500)->save(storage_path("app/public/administrator/assets/media/products/".$fileName), 100);
                Image::make($image->getRealPath())->resize(500, 500)->save($path, 100);
                $product->images()->create([
                    'data_file' => $fileName,
                    'type'      => 'image',
                    'main'      =>  $no == 1 ? true : false,
                ]);
                $no++;
            }
        }

        $originalImages = ProductMedia::where('product_id', $duplicate_product)->get();

        foreach ($originalImages as $originalImage) {
            $oldPath = "./administrator/assets/media/products/" . $originalImage->data_file;
            $fileExtension = File::extension($oldPath);
            $newName = Str::slug(strtolower($request->name)) . "_" . time() . '_' . $originalImage->id . '.' . $fileExtension;
            $newPathWithName = "./administrator/assets/media/products/" . $newName;
    
            if (File::copy($oldPath, $newPathWithName)) {
                $product->images()->create([
                    'data_file' => $newName,
                    'type'      => $originalImage->type,
                    'main'      => $originalImage->main,
                ]);
            }
        }

        if ($request->has('variants')) {
            $variants = $request->variants;
            $no = 1;
            foreach ($variants as $variant) {
                $price = str_replace(',', '', $variant['price']);
                $product->variants()->create([
                    'sku'           => $variant['sku'],
                    'name'          => $variant['name'],
                    'price'         => floatval($price),
                    'weight'        => floatval($variant['weight']),
                    'dimensions'    => json_encode(["length" => floatval($variant['dimensions']['length']), "width" => floatval($variant['dimensions']['width']), "height" => floatval($variant['dimensions']['height'])]),
                    'minimal_stock' => floatval($variant['minimal_stock']),
                    // 'stock'         => str_replace(',', '', $variant['stock']),
                    'status'        => true,
                ]);
            }
        }

        //Write log
        createLog(static::$module, __FUNCTION__, $duplicate_product);

        return redirect(route('admin.items'));
    }

    public function import()
    {
        //Check permission
        if (!isAllowed(static::$module, "import")) {
            abort(403);
        }

        $company_id = getCompanyId();
        $query_categories = Category::where("categories.status", 1);
        if ($company_id != 0) {
            $query_categories->where("categories.company_id", $company_id);
        }
        $categories = $query_categories->get();
        
        $query_brands = Brands::orderBy('id', 'asc');
        if ($company_id != 0) {
            $query_brands->where("brands.company_id", $company_id);
        }
        $brands = $query_brands->get();

        return view("administrator.items.import", compact("categories", "brands"));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function doImport(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "import")) {
            abort(403);
        }

        $company_id = getCompanyId();

        try {
            Excel::import(new ProductsImport($request->brands, $request->category), request()->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $company_id = getCompanyId();
            $query_categories = Category::where("categories.status", 1);
            if ($company_id != 0) {
                $query_categories->where("categories.company_id", $company_id);
            }
            $categories = $query_categories->get();
            
            $query_brands = Brands::orderBy('id', 'asc');
            if ($company_id != 0) {
                $query_brands->where("brands.company_id", $company_id);
            }
            $brands = $query_brands->get();
            return view("administrator.items.import", compact("categories", "brands", "failures"));;
        }


        //Write log
        createLog(static::$module, __FUNCTION__, 0);

        return redirect(route('admin.items'));
    }

    public function changeStatus(Request $request)
    {
        $data['status'] = $request->status == "active" ? 1 : 0;
        $id = $request->ix;
        Product::where(["id" => $id])->update($data);
        //Write log
        createLog(static::$module, __FUNCTION__, $id);
        return response()->json(['message' => 'Product has been deleted.']);
    }

    public function getDetail(Request $request)
    {
        // $id = $request->ix;
        // $detail = Product::select(DB::raw('products.*, SUM(CAST(stock.stock AS DECIMAL)) as total_stock'))
        // ->leftJoin(DB::raw('stock'), 'product_variants.id', '=', 'stock.item_variant_id')
        // ->where('id', $id)->first();
        $id = $request->ix;
        $detail = Product::select('products.*', 'product_variants.*', DB::raw('SUM(CAST(stock.stock AS DECIMAL)) as total_stock'), 'stock.warehouse_id', 'warehouses.name as warehouse_name')
            ->leftJoin('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('stock', 'product_variants.id', '=', 'stock.item_variant_id')
            ->leftJoin('warehouses', 'stock.warehouse_id', '=', 'warehouses.id')
            ->where('products.id', $id)
            ->groupBy(['products.id', 'product_variants.id', 'stock.warehouse_id', 'warehouses.name'])
            ->get();
      


        // dd($detail);
        if (!$detail) {
            return abort(404);
        }
        return response()->json($detail);
    }

    public function updateStock(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        //dd($request);
        foreach ($request->stock as $key => $value) {
            ProductVariant::where(["id" => $key])->update(["stock" => $value]);
            //Write log
            createLog(static::$module, __FUNCTION__, $key);
        }
        return redirect(route('admin.items'));
    }

    public function downloadFormat(){
        $file = "./administrator/assets/media/format/format-import-product.xlsx";
        return Response::download($file);
    }
}
