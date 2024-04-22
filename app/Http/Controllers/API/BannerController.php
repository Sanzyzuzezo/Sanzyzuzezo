<?php

namespace App\Http\Controllers\API;

use File;
use DB;
use App\Models\Banners;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function banners() {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $banners = Banners::where('company_id', $request->company_id)->get();
    
        $banners->map(function ($banner) {
            $banner->image = $banner->image != null ? '/administrator/assets/media/banners/' . $banner->image : img_src('default.jpg', '');
        });
    
        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dimuat.',
            'data' => $banners,
        ]);
    }
}