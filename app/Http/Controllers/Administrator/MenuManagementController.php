<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MenuManagement;
use DataTables;
use Illuminate\Support\Facades\Validator;

use Harimayco\Menu\Models\Menus;
use Harimayco\Menu\Models\MenuItems;

class MenuManagementController extends Controller
{
    protected $model, $MenuManagement, $role;
    private static $module = "menu_managements";

    public function __construct(Menus $Menu, MenuManagement $MenuManagement) {
    }

    public function index() {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.menu-management.index');
    }

    public function getData () {

        return Datatables::of(Menus::where('deleted_at',null)->get())
        ->addColumn('action', function($row){
            $btn = "";
            if(isAllowed(static::$module, "detail"))://Check permission
            $btn .= '<a href="'.route('menu-management.detail','menu='.$row->id).'" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="black" />
                        <path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="black" />
                    </svg>
                </span>
            </a>';
            endif;
            if(isAllowed(static::$module, "edit"))://Check permission
            $btn .= '<a href="'.route('menu-management.edit',$row->id).'" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
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
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create() {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        return view('administrator.menu-management.add');
    }

    public function store(Request $request) {
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $this->validate($request,[
            'name' => 'required',
        ]);

        if(!$request->has('status')) {
            $status = 0;
        } else {
            $status = 1 ;
        }

        $menu_management = MenuManagement::create([ 'name' => $request->name ]);

        //Write log
        createLog(static::$module, __FUNCTION__, $menu_management->id);

        return redirect()->route('menu-management.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show() {
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }
        if(!isset($_GET['menu']))
            return redirect()->route('menu-management.index')->with('error', 'Menu tidak tersedia atau telah dihapus');

        $id = $_GET['menu'];
        $menu = Menus::find($id);

        if(empty($menu))
            return redirect()->route('menu-management.index')->with('error', 'Menu tidak tersedia atau telah dihapus');

        return view('administrator.menu-management.detail', ['menu' => $menu]);
    }

    public function edit($id) {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $menu = Menus::find($id);

        return view('administrator.menu-management.edit', ['menu' => $menu]);
    }

    public function update($id, Request $request) {
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        $this->validate($request,[
            'name' => 'required',
        ]);

        $menu = MenuManagement::find($id);
        $menu->name = $request->name;
        $menu->save();


        //Write log
        createLog(static::$module, __FUNCTION__, $id);

        return redirect()->route('menu-management.index')->with('success', 'Data berhasil dirubah');
    }

    
    public function destroy(Request $request) {
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }
        $id = $request->ix;
        
        $menuManagement = Menus::find($id);
        if (!$menuManagement) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori posting tidak ditemukan.'
            ], 404);
        }
        
        $datamenus = MenuItems::where('menu',$id)->get();
        foreach ($datamenus as $menu) {
            $menu->deleted_by = auth()->user() ? auth()->user()->id : '';
            $menu->update();
            $menu->delete();
        }
        $deletedBy = auth()->user() ? auth()->user()->id : '';
        $menuManagement->deleted_by = $deletedBy;
        $menuManagement->update();
        $menuManagement->delete();
        //Write log
        createLog(static::$module, __FUNCTION__, $id);

        return response()->json([
            'success' => true
        ]);
    }
}
