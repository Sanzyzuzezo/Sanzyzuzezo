<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brands;
use DataTables;
use File;

class BrandsController extends Controller
{
    public static $module = "brands";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
			abort(403);
		}
        return view('administrator.brands.index');
    }
    
    public function getData(Request $request)
    {
        $company_id = getCompanyId();

        $query = Brands::select('brands.*');

        if ($company_id != 0) {
            $query->where('brands.company_id', $company_id);
        }
    
        if ($request->status != "") {
            $status = $request->status == "active" ? 1 : 0;
            $query->where("brands.status", $status);
        }
    
        $data = $query->get();
        return DataTables::of($data)
            ->addColumn('name_package', function ($row) {
                $imageUrl = asset_administrator("assets/media/brands/" . ($row->image ? $row->image : 'default.jpg'));
                $name_package = "
                    <div class='d-flex align-items-center'>
                        <div class='symbol symbol-50px'>
                            <img src='$imageUrl' />
                        </div>
                        <div class='ms-5'>$row->name</div>
                    </div>";
                
                return $name_package;
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    $status = '<div class="badge badge-light-success">Active</div>';
                } else {
                    $status = '<div class="badge badge-light-danger">Inactive</div>';
                }
                return $status;
            })
            ->addColumn('action', function($row){
                $btn = "";
                if(isAllowed(static::$module, "edit"))://Check permission
                $btn .= '<a href="'.route('admin.brands.edit',$row->id).'" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
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
            })
            ->rawColumns(['name_package', 'status', 'action'])
            ->make(true);
    }

    public function add() { 
        if (!isAllowed(static::$module, "add")) {
			abort(403);
		}
        return view('administrator.brands.add'); 
    }
     
    public function insert(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
			abort(403);
		}

        $company_id = getCompanyId();

    	$this->validate($request,[
    		'name' => 'required',
			'image' => 'required|mimes:jpeg,png,jpg|max:2048',
    	]);

        $file = $request->file('image');

		$file_name = time()."_".$file->getClientOriginalName();

		$folder_up = upload_path('brand');
		$file->move($folder_up,$file_name);
 
        if(!$request->has('status')){
            $status = 0 ;
        }else{
            $status = 1 ;
        }

        $brand = Brands::create([
    		'name' => $request->name,
    		'image' => $file_name,
    		'status' => $status,
    		'company_id' => $company_id,
    	]);

        //Write log
        createLog(static::$module, __FUNCTION__, $brand->id);
 
    	return redirect('/admin/brands')->with(['success' => 'Your data added successfully.']);
    }

    public function edit($id)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
			abort(403);
		}

        $brands = Brands::find($id);
        return view('administrator.brands.edit', ['brands' => $brands]);
    }

    public function update($id, Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
			abort(403);
		}

        $this->validate($request,[
            'name' => 'required',
        ]);

        if(!$request->has('status')){
            $status = 0 ;
        }else{
            $status = 1 ;
        }

        $brands = Brands::find($id);
        $brands->name = $request->name;
        $brands->status = $status;

        if($request->image != ''){
            if(file_exists('./administrator/assets/media/brands/'.$brands->image)){
                $file_old = './administrator/assets/media/brands/'.$brands->image;
                unlink($file_old);
            }

            $file = $request->file('image');
            $file_name = time()."_".$file->getClientOriginalName();
            $folder_up = upload_path('brand');
            $file->move($folder_up,$file_name);
            
            $brands->image = $file_name;
        }

        $brands->save();

        //Write log
        createLog(static::$module, __FUNCTION__, $id);

        return redirect('/admin/brands')->with(['success' => 'Your data updated successfully.']);
    }
    
    public function delete(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
			abort(403);
		} 
        $id = $request->ix;
        $brands = Brands::find($id);
        if (!empty($brands->image)) {
            $image_path = "./administrator/assets/media/brands/".$brands->image;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $deletedBy = auth()->user() ? auth()->user()->id : '';

        $data = Brands::find($id);
        $data->deleted_by = $deletedBy;
        $data->update();
        $data->delete();

         //Write log
         createLog(static::$module, __FUNCTION__, $id);
         return response()->json([
             'success' => true
         ]);
    }

}
