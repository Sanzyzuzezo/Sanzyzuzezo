<?php

namespace App\Http\Controllers\API;

use File;
use DB;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function stores() {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $stores = Store::where('company_id', $request->company_id)->get();
    
        $stores->map(function ($store) {
            $store->image = $store->image != null ? '/administrator/assets/media/stores/' . $store->image : img_src('default.jpg', '');
        });
    
        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dimuat.',
            'data' => $stores,
        ]);
    }
}