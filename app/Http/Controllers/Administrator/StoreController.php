<?php

namespace App\Http\Controllers\Administrator;

use DB;
use File;
use Image;
use DataTables;
use App\Models\City;
use App\Models\Store;
use App\Models\Province;
use App\Models\Kecamatan;
use App\Models\Warehouse;
use App\Models\StoreDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{

    private static $module = "store";

    public function index() {

        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.store.index');
    }

    public function getData(Request $request){

        $company_id = getCompanyId();

        $query = Store::select(DB::raw('stores.*'));

        if ($company_id != 0) {
            $query->where('stores.company_id', $company_id);
        }

        if($request->status != ""){
            $status = $request->status == "active" ? 1 : 0;
            $query->where("stores.status", $status);
        }
        
        $data = $query->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '';
                //if (isAllowed(static::$module, "detail")) : //Check permission
                    $btn .= '<a href="' . route('admin.store.detail', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                    <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/><path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/></svg>
                    </span>
                </a>';
                // if(isAllowed(static::$module, "edit"))://Check permission
                $btn .= '<a href="'.route('admin.store.edit',$row->id).'" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                    <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                        </svg>
                    </span>
                </a>';
                // endif;
                // if(isAllowed(static::$module, "delete"))://Check permission
                $btn .= '<a href="#" data-ix="' . $row->id . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete">
                    <span class="svg-icon svg-icon-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                            <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                            <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                        </svg>
                    </span>
                </a>';
                // endif;
                return $btn;
            })
            ->addColumn('status', function ($row) {
                if ($row->status) {
                    $status = '<div class="badge badge-light-success mb-5">Active</div>';
                } else {
                    $status = '<div class="badge badge-light-danger mb-5">Inactive</div>';
                }
                return $status;
            })
            ->rawColumns(['title', 'status', 'action'])
            ->make(true);
    }

    public function getItemData(Request $request)
    {
        $data = Warehouse::where("id", $request->id)->first();

        return $data;
    }

    public function add() {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }
        $company_id = getCompanyId();

        $provinces = Province::get();
        $query = Warehouse::where('status', 1);
        if ($company_id != 0) {
            $query->where('warehouses.company_id', $company_id);
        }
        $warehouse = $query->get();
        return view('administrator.store.add', compact('provinces', 'warehouse'));
    }

    public function insert(Request $request) {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $company_id = getCompanyId();

        $data = $request->except(['_token', '_method', 'id', 'image']);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName  = Str::slug(strtolower($request->name)) . "_" . time() . '.' . $image->getClientOriginalExtension();
            $path = upload_path('store') . $fileName;
            Image::make($image->getRealPath())->resize(500, 500)->save($path, 100);

            $data['image'] = $fileName;
            $data['company_id'] = $company_id;
            $store = Store::create($data, false);
            foreach ($request->warehouse as $data){
                StoreDetail::create([
                    'store_id'      => $store->id,
                    'warehouse_id'  => $data['warehouse_id'],
                ]);
            }
        } else {
            $data['company_id'] = $company_id;
            $store = Store::create($data, false);
            foreach ($request->warehouse as $data){
                StoreDetail::create([
                    'store_id'      => $store->id,
                    'warehouse_id'  => $data['warehouse_id'],
                ]);
            }
        }

        // createLog(static::$module, __FUNCTION__, $user->id);
        return redirect()->route('admin.store');
    }

    public function edit($id) {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $store = Store::find($id);

        if (!empty($store)) {
            $store_detail = StoreDetail::select(DB::raw('store_detail.id, warehouses.code, warehouses.name, warehouses.id as warehouse_id'))
                                        ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'store_detail.warehouse_id')
                                        ->where('store_detail.store_id', $id)
                                        ->get();
            $provinces = Province::get();
            $company_id = getCompanyId();

            $query = Warehouse::where('status', 1);
            if ($company_id != 0) {
                $query->where('warehouses.company_id', $company_id);
            }
            $warehouse = $query->get();
            return view('administrator.store.edit', compact('provinces', 'store', 'store_detail', 'warehouse'));
        }

    }

    public function detail($id) {
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $store = Store::find($id);

        if (!empty($store)) {
            $store_detail = StoreDetail::select(DB::raw('store_detail.id, warehouses.code, warehouses.name, warehouses.id as warehouse_id'))
                                        ->leftJoin(DB::raw('warehouses'), 'warehouses.id', '=', 'store_detail.warehouse_id')
                                        ->where('store_detail.store_id', $id)
                                        ->get();
            $provinces = Province::get();
            $cities = City::get();
            $company_id = getCompanyId();

            $query = Warehouse::where('status', 1);
            if ($company_id != 0) {
                $query->where('warehouses.company_id', $company_id);
            }
            $warehouse = $query->get();
            return view('administrator.store.detail', compact('provinces', 'store', 'store_detail', 'warehouse','cities'));
        }

    }

    public function update(Request $request) {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $id = $request->id;
        $data = $request->except(['_token', '_method', 'id', 'image']);
        $model = Store::find($request->id);
        // dd($model);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName  = Str::slug(strtolower($request->name)) . "_" . time() . '.' . $image->getClientOriginalExtension();
            $path = upload_path('store') . $fileName;
            Image::make($image->getRealPath())->resize(500, 500)->save($path, 100);

            $data['image'] = $fileName;
            $model->update($data);
            $warehouses = $request->warehouse;
            $warehouses_id = collect($request->id)->pluck('id');
            
            foreach ($warehouses as $row) {
                $detail_id = isset($row['id']) ? $row['id'] : "";
                $data_update = [
                    'store_id'    => $id,
                    'warehouse_id' => $row['warehouse_id']
                ];

                if ($detail_id == "") {
                    StoreDetail::create($data_update);
                } else {
                    StoreDetail::where(["id" => $detail_id])->update($data_update);
                }
            }
            StoreDetail::whereNotIn('id', $warehouses_id)->where('store_id', $id)->delete();
            
        } else {
            $model->update($data);
            $warehouses = $request->warehouse;
            $warehouses_id = collect($request->id)->pluck('id');
            foreach ($warehouses as $row) {
                $detail_id = isset($row['id']) ? $row['id'] : "";
                $data_update = [
                    'store_id'    => $id,
                    'warehouse_id' => $row['warehouse_id']
                ];

                if ($detail_id == "") {
                    StoreDetail::create($data_update);
                } else {
                    StoreDetail::where(["id" => $detail_id])->update($data_update);
                }
            }
            StoreDetail::whereNotIn('id', $warehouses_id)->where('store_id', $id)->delete();
        }


        // createLog(static::$module, __FUNCTION__, $user->id);
        return redirect()->route('admin.store');
    }

    public function delete(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }
        
        $id = $request->ix;
        $stores = Store::find($id);
    
        if (!$stores) {
            return response()->json([
                'success' => false,
                'message' => 'Store tidak ditemukan.'
            ], 404);
        }
    
        $dataStores = $stores->store_detail;
        foreach ($dataStores as $store) {
            $store->deleted_by = auth()->user() ? auth()->user()->id : '';
            $store->update();
            $store->delete();
        }
        $deletedBy = auth()->user() ? auth()->user()->id : '';
        $stores->deleted_by = $deletedBy;
        $stores->update();
        $stores->delete();
    
        // Tulis log
        createLog(static::$module, __FUNCTION__, $id);
        return response()->json([
            'success' => true
        ]);
    }

    public function deleteDetail(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data_detail = StoreDetail::find($request->id);

        if ($data_detail) {
            // Simpan ID pengguna yang menghapus sebelum menghapus
            $deletedBy = auth()->user() ? auth()->user()->id : '';
            $data_detail->deleted_by = $deletedBy;
            $data_detail->update();

            // Hapus detail setelah update
            $data_detail->delete();

            // Write log
            createLog(static::$module, __FUNCTION__, $request->id);

            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }
    }
    

}
