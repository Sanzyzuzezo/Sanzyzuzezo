<?php

namespace App\Http\Controllers\API;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\SettingCompany;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function company(Request $request){
        if (!$request->company_id) {
            return response()->json([
                'status' => 404,
                'message' => "Company id not found",
            ], 404);
        }
        
        $settings = SettingCompany::where('company_id', $request->company_id)->get()->toArray();
        if (!$settings) {
            return response()->json([
                'status' => 404,
                'message' => "Data not found",
            ], 404);
        }

        $settings = array_column($settings, 'value', 'name');

        $logo = $settings['logo'] ?? null;
        $logo_path = "";

        if ($logo) {
            $logo_path = $logo != null ? './administrator/assets/media/settings/' . $logo: img_src('default.jpg', '');
        }

        $favicon = $settings['favicon'] ?? null;
        $favicon_path = "";

        if ($favicon) {
            $favicon_path = $favicon != null ? './administrator/assets/media/settings/' . $favicon: img_src('default.jpg', '');
        }

        $settings['logo'] = $logo_path;
        $settings['favicon'] = $favicon_path;

        return response()->json([
            'status' => 200,
            'message' => "Data successfully",
            'data' => $settings,
        ], 200);
    }
}
