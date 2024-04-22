<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use App\Models\Setting;
use App\Models\Province;
use DataTables;
use Image;
use File;
use DB;

class SettingsController extends Controller
{
    private static $module = "settings";

    public function smtp()
    {
        //Check permission
        if (!isAllowed(static::$module, "smtp")) {
            abort(403);
        }

        $setting = Setting::where("name", "smtp")->first();
        if ($setting) {
            $setting = json_decode($setting->value);
        }

        return view("administrator.settings.smtp", compact("setting"));
    }

    public function updateSMTP(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "smtp")) {
            abort(403);
        }

        $this->validate($request, [
            'smtp_host'     => 'required',
            'smtp_security' => 'required',
            'smtp_port'     => 'required',
            'smtp_user'     => 'required',
        ]);

        $setting = Setting::where("name", "smtp")->first();
        if ($setting) {
            $setting = json_decode($setting->value);
        }

        $data_smtp = [
            "host"      => $request->smtp_host,
            "security"  => $request->smtp_security,
            "port"      => $request->smtp_port,
            "user"      => $request->smtp_user,
        ];

        if ($request->smtp_password != "") {
            $data_smtp["password"] = $request->smtp_password;
        } else {
            $data_smtp["password"] = $setting->password;
        }

        $data = [
            'value'    => json_encode($data_smtp),
        ];

        if (!$setting) {
            $data["name"] = "smtp";
            Setting::create($data);
        } else {
            Setting::where('name', "smtp")->update($data);
        }

        //Write log
        createLog(static::$module, __FUNCTION__, 0);

        return redirect(route('admin.settings.smtp'));
    }

    public function general()
    {
        //Check permission
        if (!isAllowed(static::$module, "general")) {
            abort(403);
        }

        // $setting = Setting::where('name', 'smtp')->first();
        // $smtp_setting = json_decode($setting['value']);
        // return $smtp_setting;

        $settings = Setting::get()->toArray();
        $provinces = Province::get();
        $settings = array_column($settings, 'value', 'name');

        $address = [];
        if (isset($settings['address'])) {
            $address = json_decode($settings['address']);
        }

        return view("administrator.settings.general", compact("settings", "provinces", "address"));
    }

    public function updateGeneral(Request $request)
    {
        // return $request;
        //Check permission
        if (!isAllowed(static::$module, "general")) {
            abort(403);
        }

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

        $settings = Setting::get()->toArray();
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

        if ($request->hasFile('logo')) {
            if (array_key_exists("logo", $settings)) {
                $imageBefore = $settings["logo"];
                if (!empty($settings["logo"])) {
                    $image_path = "./administrator/assets/media/settings/" . $settings["logo"];
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
                $image->move($logo,$fileName);
                $data_settings['logo'] = $fileName;
            } else {
            $image->move($logo,$fileName);
            Image::make($logo . '/' . $fileName)->resize(500, 500)->save();
            $data_settings['logo'] = $fileName;
            }
        }

        if ($request->hasFile('favicon')) {
            if (array_key_exists("favicon", $settings)) {
                $imageBefore = $settings["favicon"];
                if (!empty($settings["favicon"])) {
                    $image_path = "./administrator/assets/media/settings/" . $settings["favicon"];
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
                $image->move($favicon,$fileName);
                $data_settings['favicon'] = $fileName;
            } else {
            $image->move($favicon,$fileName);
            Image::make($favicon . '/' . $fileName)->resize(500, 500)->save();
            $data_settings['favicon'] = $fileName;
            }
        }

        foreach ($data_settings as $key => $value) {
            if (array_key_exists($key, $settings)) {
                $data["value"]  = $value;
                Setting::where('name', $key)->update($data);
            } else {
                $data["name"]   = $key;
                $data["value"]  = $value;
                Setting::create($data);
            }
        }

        //Write log
        createLog(static::$module, __FUNCTION__, 0);

        return redirect(route('admin.settings.general'));
    }
}
