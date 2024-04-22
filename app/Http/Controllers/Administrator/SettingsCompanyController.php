<?php

namespace App\Http\Controllers\Administrator;

use DB;
use File;
use Image;
use DataTables;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SettingCompany;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class SettingsCompanyController extends Controller
{
    private static $module = "settings_companies";

    public function settingsCompany()
    {

        //Check permission
        if (!isAllowed(static::$module, "settings_companies")) {
            abort(403);
        }

        $company_id = getCompanyId();

        $settings = SettingCompany::where('company_id', $company_id)->get()->toArray();

        $settings = array_column($settings, 'value', 'name');

        $gudang = Warehouse::where("company_id", $company_id)->get();

        $address = [];
        if (isset($settings['address'])) {
            $address = json_decode($settings['address']);
        }

        return view("administrator.settings_companies.index", compact("settings", "address", "gudang"));
    }

    public function updateSettingsCompany(Request $request)
    {
        // return $request;
        //Check permission
        if (!isAllowed(static::$module, "settings_companies")) {
            abort(403);
        }

        $company_id = getCompanyId();

        $email_receives = [];
        $index = 0;
        if (!empty($request->name_receive)) {
            foreach ($request->name_receive as $name_receive) {
                $email_receives [] = ['name' => $name_receive, 'email' =>  $request->email_receive[$index]];
                $index++;
            }
        }

        $social_medias = [];
        $index = 0;
        if (!empty($request->title_social_media)) {
            foreach ($request->title_social_media as $title_social_media) {
                $social_medias [] = [
                    'title' => $title_social_media,
                    'icon' =>  $request->icon_social_media[$index],
                    'link' =>  $request->link_social_media[$index]
                ];
                $index++;
            }
        }

        $address = [];
        $address['kecamatan'] = $request->kecamatan;
        $address['kota'] = $request->city;
        $address['provinsi'] = $request->province;
        $address['detail'] = $request->address;

        $settings = SettingCompany::where('company_id', $company_id)->get()->toArray();
        $settings = array_column($settings, 'value', 'name');

        $data_settings = [];
        $data_settings["site_name"] = $request->site_name;
        // $data_settings["default_language"] = $request->default_language;
        $data_settings["email"] = $request->email;
        $data_settings["address"] = json_encode($address);
        $data_settings["phone"] = $request->phone;
        $data_settings["whatsapp"] = $request->whatsapp;
        $data_settings["email_receive"] = json_encode($email_receives);
        $data_settings["social_media"] = json_encode($social_medias);
        $data_settings["min_purchase"] = $request->min_purchase;
        $data_settings["internal_courier_price"] = $request->internal_courier_price;
        $data_settings["gudang_penjualan"] = $request->gudang_penjualan;

        if ($request->hasFile('logo')) {
            if (array_key_exists("logo", $settings)) {
                $imageBefore = $settings["logo"];
                if (!empty($settings["logo"])) {
                    $image_path = "./administrator/assets/media/settings_companies/" . $settings["logo"];
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }

            $image = $request->file('logo');
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::slug(time() . "_" . $image->getClientOriginalName()) . '.' . $extension;
            $path = upload_path('logo') . $fileName;
            $logo = upload_path('logo');
            if ($extension === 'svg') {
                $image->move($logo, $fileName);
                $data_settings['logo'] = $fileName;
            } else {
                $image->move($logo, $fileName);
                Image::make($logo . '/' . $fileName)->resize(500, 500)->save();
                $data_settings['logo'] = $fileName;
            }
        }

        if ($request->hasFile('favicon')) {
            if (array_key_exists("favicon", $settings)) {
                $imageBefore = $settings["favicon"];
                if (!empty($settings["favicon"])) {
                    $image_path = "./administrator/assets/media/settings_companies/" . $settings["favicon"];
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }

            $image = $request->file('favicon');
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::slug(time() . "_" . $image->getClientOriginalName()) . '.' . $extension;
            $path = upload_path('favicon') . $fileName;
            $favicon = upload_path('favicon');
            if ($extension === 'svg') {
                $image->move($favicon, $fileName);
                $data_settings['favicon'] = $fileName;
            } else {
                $image->move($favicon, $fileName);
                Image::make($favicon . '/' . $fileName)->resize(500, 500)->save();
                $data_settings['favicon'] = $fileName;
            }
        }

        foreach ($data_settings as $key => $value) {
            $data = [
                'value' => $value,
                'company_id' => $company_id,
            ];
        
            if (array_key_exists($key, $settings)) {
                SettingCompany::where('name', $key)
                    ->where('company_id', $company_id)
                    ->update($data);
            } else {
                $data['name'] = $key;
                SettingCompany::create($data);
            }
        }
        
        //Write log
        createLog(static::$module, __FUNCTION__, 0);

        return redirect(route('admin.settings.company'));
    }
}
