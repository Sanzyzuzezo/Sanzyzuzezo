<?php

namespace App\Http\Controllers\API;

use File;
use DB;
use App\Models\Pages;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->company_id) {
            return response()->json([
                'status' => 400,
                'message' => "Company id is required",
            ], 400);
        }
        
        $pages = Pages::where('company_id', $request->company_id)->get();
        if (!$pages) {
            return response()->json([
                'status' => 404,
                'message' => "Data not found",
            ], 404);
        }

        $pages->map(function($pr){
            $pr->image = $pr->image != null ? '/administrator/assets/media/pages/' . $pr->image: img_src('default.jpg', '');
        });

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dimuat.',
            'data' => $pages,
        ]);
    }
}