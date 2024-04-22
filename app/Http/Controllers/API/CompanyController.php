<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use DataTables;
use Image;
use File;
use DB;

class CompanyController extends Controller
{
    public function company(Request $request)
{
    $companies = Setting::pluck('value', 'name')->toArray();

    $logo = $companies['logo'] ?? null;
    $logo_path = "";

    if ($logo) {
        $logo_path = $logo != null ? './administrator/assets/media/settings/' . $logo: img_src('default.jpg', '');
    }

    $favicon = $companies['favicon'] ?? null;
    $favicon_path = "";

    if ($favicon) {
        $favicon_path = $favicon != null ? './administrator/assets/media/settings/' . $favicon: img_src('default.jpg', '');
    }

    $companies['logo'] = $logo_path;
    $companies['favicon'] = $favicon_path;

    return response()->json([
        'status' => 200,
        'message' => 'Data berhasil dimuat.',
        'companies' => $companies,
    ]);
}


     
    
}