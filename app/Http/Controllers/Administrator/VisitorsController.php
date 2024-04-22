<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use App\Models\Visitor;
use DataTables;
use Image;
use File;
use DB;

class VisitorsController extends Controller
{
    private static $module = "visitors";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        return view("administrator.visitors.index");
    }

    public function getData(Request $request)
    {
        $company_id = getCompanyId();

        $query = Visitor::select(DB::raw('visitors.*'));
        
        if ($company_id != 0) {
            $query->where('visitors.company_id', $company_id);
        }

        $data = $query->get();
        
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn = "";
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
            })->rawColumns([ 'action'])->make(true);
    }

    public function delete(Request $request)
    {      
        //Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }
        
        $deletedBy = auth()->user() ? auth()->user()->id : '';

        $data = Visitor::find($request->ix);
        $data->deleted_by = $deletedBy;
        $data->update();
        $data->delete();

         //Write log
         createLog(static::$module, __FUNCTION__, $request->ix);
         return response()->json([
             'success' => true
         ]);
    }
}
