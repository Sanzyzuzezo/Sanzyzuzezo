<?php

namespace App\Http\Controllers\Administrator;

use DB;
use File;
use Image;
use DataTables;
use App\Models\User;
use App\Models\Store;
use App\Models\Company;
use App\Models\UserGroup;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class UserAdminsController extends Controller
{
    private static $module = "user_admins";

    public function dashboard()
    {
        $user = Auth::user();
        return view("administrator.user_admins.dashboard", compact("user"));
    }

    public function index()
    {
        return view("administrator.user_admins.index");
    }

    public function getData(Request $request)
    {
        $company_id = getCompanyId();

        $query = User::select(DB::raw('users.*, user_groups.name as user_group_name'))
        ->Join(DB::raw('user_groups'), 'user_groups.id', '=', 'users.user_group_id');

        if ($company_id != 0) {
            $query->where("users.company_id", $company_id);
        }
    
        if ($request->status != "") {
            $status = $request->status == "active" ? 1 : 0;
            $query->where("users.status", $status);
        }
    
        $data = $query->get();


        return DataTables::of($data)
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
                // $btn .= '<a href="' . route('admin.user-admins.edit', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                //     <span class="svg-icon svg-icon-3">
                //         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                //             <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                //             <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                //         </svg>
                //     </span>
                // </a>';
                $btn .= '<a href="#" data-ix="' . $row->id . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete">
                    <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                        </svg>
                    </span>
                </a>';
                return $btn;
            })->rawColumns(['name_package', 'child', 'status', 'action'])->make(true);
    }

    public function getStoreData()
    {
        $data = Store::select(DB::raw('stores.id, stores.name'))
                        ->where("stores.status", 1)
                        ->get();

        return DataTables::of($data)->make(true);
    }
    
    public function getWarehouseData()
    {
        $data = Warehouse::select(DB::raw('warehouse.id, warehouse.code, warehouse.name'))
                        ->where("warehouse.status", 1)
                        ->get();

        return DataTables::of($data)->make(true);
    }

    public function getMaxUser()
    {
        $company_id = getCompanyId();
        if (($company_id != 0)) {
        $company    = Company::where('id', $company_id)->first();
        $max_user   = $company->max_user;

            return $max_user;
        } else {
            return 1;
        }
    }

    public function add()
    {
        $user_groups = UserGroup::where("user_groups.status", 1)->get();
        $data_user = User::find(auth()->user()->id);
        $company    = Company::all();
        return view("administrator.user_admins.add",compact("user_groups","data_user","company"));
    }

    public function save(Request $request)
    {

        $max_user       = $this->getMaxUser();
        $company_id     = $request->company_id;
        $user_company   = User::where('company_id', $company_id)->get();
        $cek_max_user   = COUNT($user_company) - 1;

        $this->validate($request, [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($cek_max_user == $max_user) {
            session()->flash('warning', 'Gagal, Jumlah pengguna melebihi batas maksimal.');
            return redirect(route('admin.user-admins'));
        } else {
        
        $data = [
            'user_group_id'     => $request->user_group,
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'cashier'           => $request->has('cashier') == null ? 0 : $request->store_id,
            'warehouse_pic'     => $request->has('warehouse_pic') == null ? 0 : $request->warehouse_id,
            'status'            => $request->has('status') ? 1 : 0,
            'employee'          => $request->has('employee') ? 1 : 0,
            'company_id'        => $company_id
        ];
        $user = User::create($data);
        //Write log
        createLog(static::$module, __FUNCTION__, $user->id);
        return redirect(route('admin.user-admins'));
        }
    }

    public function detail($id)
    {

        $detail = User::find($id);
        if (!$detail) {
            return abort(404);
        }

        return view('administrator.user_admins.detail', compact("detail"));
    }

    public function edit($id)
    {
        // $edit = User::find($id);
        
        $edit = User::select(DB::raw('users.*, stores.name as store_name, warehouses.code as warehouse_code, warehouses.name as warehouse_name'))
                    ->leftJoin(DB::raw('stores'), 'stores.id', '=', 'users.cashier')
                    ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'users.warehouse_pic')
                    ->find($id);
                    

        if (!$edit) {
            return abort(404);
        }

        $user_groups = UserGroup::where("user_groups.status", 1)->get();
        return view("administrator.user_admins.edit", compact("user_groups", "edit"));
    }

    public function update(Request $request)
    {

        $this->validate($request, [
            'name' => 'required'
        ]);

        $data = [
            'user_group_id'     => $request->user_group,
            'name'              => $request->name,
            'email'             => $request->email,
            'cashier'           => $request->has('cashier') == null ? 0 : $request->store_id,
            'warehouse_pic'     => $request->has('warehouse_pic') == null ? 0 : $request->warehouse_id,
            'status'            => $request->has('status') ? 1 : 0,
        ];

        if($request->has('password') && $request->password != ""){
            $data['password'] = Hash::make($request->password);
        }

        $id = $request->id;
        $user = User::find($id);

        User::where('id', $id)->update($data);
        //Write log
        createLog(static::$module, __FUNCTION__, $id);
        return redirect(route('admin.user-admins'));
    }

    public function delete(Request $request)
    {

        $id = $request->ix;
        $user_group = User::find($id);
        
        $deletedBy = auth()->user() ? auth()->user()->id : '';

        $data = User::find($id);
        $data->deleted_by = $deletedBy;
        $data->update();
        $data->delete();

         //Write log
         createLog(static::$module, __FUNCTION__, $id);
         return response()->json([
             'success' => true
         ]);
    }

    public function changeStatus(Request $request)
    {
        $data['status'] = $request->status == "active" ? 1 : 0;
        $id = $request->ix;
        User::where(["id" => $id])->update($data);
        //Write log
        createLog(static::$module, __FUNCTION__, $id);
        return response()->json(['message' => 'Status has changed.']);
    }

    public function isExistEmail(Request $request)
    {
        if ($request->ajax()) {
            $user = User::select("*");
    
            if (isset($request->email)) {
                $user->where(DB::raw('LOWER(email)'), strtolower($request->email));
            }
    
            if (isset($request->id)) {
                $user->where('id', '<>', $request->id);
            }
    
            $data = ['valid' => ($user->count() == 0)];
    
            return $data;
        }
    }
}
