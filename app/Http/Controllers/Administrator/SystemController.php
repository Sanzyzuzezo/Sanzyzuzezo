<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use App\Models\LogSystem;
use DataTables;
use Image;
use File;
use DB;

class SystemController extends Controller
{
    private static $module = "systems";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "logs")) {
            abort(403);
        }

        return view("administrator.systems.index");
    }

    public function getData(Request $request)
    {
        $data = LogSystem::select(DB::raw('log_systems.*, users.name as user_name'))
        ->leftJoin(DB::raw('users'), 'users.id', '=', 'log_systems.user_id')
        ->get();
        
        return DataTables::of($data)->make(true);
    }

}
