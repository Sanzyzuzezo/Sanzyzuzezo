<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use DataTables;
use Image;
use File;
use DB;

class CategoriesController extends Controller
{
    private static $module = "categories";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        return view("administrator.categories.index");
    }

    public function getData(Request $request)
    {
        $company_id = getCompanyId();

        $query = Category::select(DB::raw('categories.*, parent_categories.name as parent_name'))
            ->leftJoin(DB::raw('categories as parent_categories'), 'parent_categories.id', '=', 'categories.parent')
            ->whereNull('categories.parent')
            ->with('childCategories');
            
        if ($company_id != 0) {
            $query->where('categories.company_id', $company_id);
        }
        if ($request->status != "") {
            $status = $request->status == "active" ? 1 : 0;
            $query->where("categories.status", $status);

            $query->with([
                'childCategories' => function($q) use ($status) {
                    $q->where('categories.status', $status);
                }
            ]);
        }

        $data = $query->get();
        //dd($data);

        return DataTables::of($data)
            ->addColumn('name_package', function ($row) {
                $name_package = '<div class="d-flex align-items-center"><div class="symbol symbol-50px"><span class="symbol-label" style="background-image:url(' . img_src($row->image, "category") . ');"></span></div><div class="ms-5"><a href="' . route('admin.categories.detail', $row->id) . '" class="text-gray-800 text-hover-primary fs-5 fw-bolder" data-kt-ecommerce-product-filter="product_name">' . $row->name . '</a></div></div>';
                return $name_package;
            })
            ->addColumn('child', function ($row) {
                $child = '<div id="kt_docs_jstree_basic">';

                if (!empty($row->childCategories)) {
                    $child .= '<ul>';
                    foreach ($row->childCategories as $sub) {
                        $child .= '<li data-jstree=\'{ "selected" : true }\'>';
                        $child .= '<a class="text-muted" href="' . route('admin.categories.detail', $sub->id) . '">' . $sub->name . '</a>';
                        $child .= ' <a href="' . route('admin.categories.edit', $sub->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                            </svg>
                        </span>
                    </a>
                    <a href="#" data-ix="' . $sub->id . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none">
                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                            </svg>
                        </span>
                    </a>';
                        if (!empty($sub->categories)) {
                            $child .= '<ul>';
                            foreach ($sub->categories as $subsub) {
                                $child .= '<li>';
                                $child .= '<a class="text-muted" href="' . route('admin.categories.detail', $subsub->id) . '">' . $subsub->name . '</a>';
                                $child .= ' <a href="' . route('admin.categories.edit', $subsub->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                            </svg>
                        </span>
                    </a>
                    <a href="#" data-ix="' . $subsub->id . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none">
                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                            </svg>
                        </span>
                    </a>';
                                $child .= '</li>';
                            }
                            $child .= '</ul>';
                        }
                        $child .= '</li>';
                    }
                    $child .= '</ul>';
                }
                $child .= '</div>';
                return $child;
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
                if(isAllowed(static::$module, "edit"))://Check permission
                $btn .= '<a href="' . route('admin.categories.edit', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                    <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                        </svg>
                    </span>
                </a>';
                endif;
                if(isAllowed(static::$module, "delete"))://Check permission
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
            })->rawColumns(['name_package', 'child', 'status', 'action'])->make(true);
    }

    public function add()
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }
        $company_id = getCompanyId();
        // $categories = $this->getCategoryTreeForParentId();
        // echo "<pre>";
        // print_r($categories);
        // echo "</pre>";
        // exit;
        //$categories = Category::all();
        $query = Category::select(DB::raw('categories.*, parent_categories.name as parent_name'))
            ->leftJoin(DB::raw('categories as parent_categories'), 'parent_categories.id', '=', 'categories.parent')
            ->whereNull('categories.parent');
            // ->orWhereNull('parent_categories.parent')
        if ($company_id != 0) {
            $query->where('parent_categories.company_id', $company_id);
        }

        $categories = $query->get();
        return view("administrator.categories.add", compact("categories"));
    }

    public function save(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $company_id = getCompanyId();
        
        $this->validate($request, [
            'name' => 'required'
        ]);

        $data = [
            'parent'    => $request->parent,
            'name'      => $request->name,
            'status'    => $request->has('status') ? 1 : 0,
            'company_id'    => $company_id,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName  = Str::slug(strtolower($request->name)) . '.' . $image->getClientOriginalExtension();
            $path = upload_path('category') . $fileName;
            Image::make($image->getRealPath())->resize(500, 500)->save($path, 100);
            $data['image'] = $fileName;
        }

        $category = Category::create($data);
        //Write log
        createLog(static::$module, __FUNCTION__, $category->id);
        return redirect(route('admin.categories'));
    }

    public function detail($id)
    {
        $categories = Category::select(DB::raw('categories.*, parent_categories.name AS parent_name'))
            ->leftJoin(DB::raw('categories as parent_categories'), 'parent_categories.id', '=', 'categories.parent')
            // ->whereNull('categories.parent')
            ->where('categories.id', $id)
            ->with('childCategories')
            ->get();

        return view('administrator.categories.detail', ['categories' => $categories]);
    }

    public function edit($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        $edit = Category::find($id);
        if (!$edit) {
            return abort(404);
        }
        $company_id = getCompanyId();
        $query_categories = Category::select(DB::raw('categories.*, parent_categories.name as parent_name'))
            ->leftJoin(DB::raw('categories as parent_categories'), 'parent_categories.id', '=', 'categories.parent')
            ->whereNull('categories.parent')
            ->where('categories.id', '!=', $edit->id);
            if ($company_id != 0) {
                $query_categories->where('parent_categories.company_id', $company_id);
            }
        $categories =   $query_categories->get(); 

        $query_childs = Category::select(DB::raw('categories.*, parent_categories.name as parent_name'))
        ->leftJoin(DB::raw('categories as parent_categories'), 'parent_categories.id', '=', 'categories.parent')
        ->where('categories.parent',$edit->id);
        if ($company_id != 0) {
            $query_childs->where('categories.company_id', $company_id);
        }
        $childs =   $query_childs->get(); 

        $child = null;

        if (!$childs->isEmpty()) {
            $child = $childs[0]->id;
        }else { $child =""; }
        return view("administrator.categories.edit", compact("categories","child", "edit"));
    }

    public function update(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        $this->validate($request, [
            'name' => 'required'
        ]);
        $id = $request->id;
        $edit = Category::find($id);
        $childs = Category::select(DB::raw('categories.*, parent_categories.name as parent_name'))
        ->leftJoin(DB::raw('categories as parent_categories'), 'parent_categories.id', '=', 'categories.parent')
        ->where('categories.parent',$edit->id)
        ->get();
        $child = null;
        if (!$childs->isEmpty()) {
            $child = $childs[0]->id;
        }else { $child =""; }
        if ($child!="") {
            $data = [
                'name'      => $request->name,
                'status'    => $request->has('status') ? 1 : 0,
            ];
        } else {
            $data = [
                'parent'    => $request->parent,
                'name'      => $request->name,
                'status'    => $request->has('status') ? 1 : 0,
            ];
        }
        $id = $request->id;
        $categories = Category::find($id);

        #---------- Upload an Image ----------
        if ($request->hasFile('image')) {
            $imageBefore = $categories->image;
            if (!empty($categories->image)) {
                $image_path = "./administrator/assets/media/categories/" . $categories->image;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $image = $request->file('image');
            $fileName  = Str::slug(strtolower($request->name)) . '.' . $image->getClientOriginalExtension();
            $path = upload_path('category') . $fileName;
            Image::make($image->getRealPath())->resize(500, 500)->save($path, 100);
            $data['image'] = $fileName;
        }

        $category = Category::where('id', $id)->update($data);
        //Write log
        createLog(static::$module, __FUNCTION__, $id);
        return redirect(route('admin.categories'));
    }

    public function delete(Request $request)
    {
        // Periksa izin
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }
    
        $id = $request->ix;
        $category = Category::with('childCategories')->find($id);
    
        if (!empty($category)) {
            $deletedBy = auth()->user() ? auth()->user()->id : '';
            $imagePath = "./administrator/assets/media/categories/" . $category->image;
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $category->childCategories->each(function ($childCategory) use ($deletedBy) {
                $childCategory->deleted_by = $deletedBy;
                $childCategory->save();
            });
            
            $category->deleted_by = $deletedBy;
            $category->save();
            $category->childCategories()->delete();
            $category->delete();
            createLog(static::$module, __FUNCTION__, $id);
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }
    }
    


    


    public function deleteChild($parent_id)
    {
        $result = Category::select(DB::raw('categories.*, parent_categories.name AS parent_name'))
            ->leftJoin(DB::raw('categories as parent_categories'), 'parent_categories.id', '=', 'categories.parent')
            ->where('categories.parent', $parent_id)->get();
        foreach ($result as $mainCategory) {
            if (!empty($mainCategory->image)) {
                $image_path = "./administrator/assets/media/categories/" . $mainCategory->image;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $data = Category::destroy($mainCategory->id);
            $data->deleted_by = $deletedBy;
            $data->update();
            $data->delete();
            createLog(static::$module, __FUNCTION__, $mainCategory->id);
            $this->deleteChild($mainCategory->id);
            return response()->json([
                'success' => true
            ]);
        }
    }

    public function getCategoryTreeForParentId($parent_id = NULL)
    {
        $categories = array();
        $result = Category::select(DB::raw('categories.*, parent_categories.name AS parent_name'))
            ->leftJoin(DB::raw('categories as parent_categories'), 'parent_categories.id', '=', 'categories.parent')
            ->where('categories.parent', $parent_id)->get();
        foreach ($result as $mainCategory) {
            $category = array();
            $category['id'] = $mainCategory->id;
            $category['name'] = $mainCategory->name;
            $category['parent_id'] = $mainCategory->parent;
            $category['sub_categories'] = $this->getCategoryTreeForParentId($category['id']);
            $categories[$mainCategory->id] = $category;
        }
        return $categories;
    }

    public function changeStatus(Request $request)
    {
        $data['status'] = $request->status == "active" ? 1 : 0;
        $id = $request->ix;
        Category::where(["id" => $id])->update($data);
        //Write log
        createLog(static::$module, __FUNCTION__, $id);
        if ($request->status == "inactive") {
            $this->changeStatusChild($id, $request->status);
        }

        return response()->json(['message' => 'Product has been deleted.']);
    }

    public function changeStatusChild($parent_id, $status)
    {
        $result = Category::select(DB::raw('categories.*, parent_categories.name AS parent_name'))
            ->leftJoin(DB::raw('categories as parent_categories'), 'parent_categories.id', '=', 'categories.parent')
            ->where('categories.parent', $parent_id)->get();
        foreach ($result as $mainCategory) {
            $data['status'] = $status == "active" ? 1 : 0;
            $id = $mainCategory->id;
            Category::where(["id" => $id])->update($data);
            //Write log
            createLog(static::$module, __FUNCTION__, $id);
            $this->changeStatusChild($mainCategory->id, $status);
        }
    }
}
