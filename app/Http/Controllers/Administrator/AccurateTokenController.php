<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Models\AccurateToken;
use App\Http\Controllers\Controller;

class AccurateTokenController extends Controller
{
    private static $module = "accurate_token";

    public function index()
    {

        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        $company_id = getCompanyId();

        $settings = AccurateToken::where('company_id', $company_id)->get()->toArray();

        $settings = array_column($settings, 'value', 'name');

        return view("administrator.accurate.token", compact("settings"));
    }

    public function update(Request $request)
    {
        // return $request;
        //Check permission
        if (!isAllowed(static::$module, "update")) {
            abort(403);
        }

        $company_id = getCompanyId();

        $settings = AccurateToken::where('company_id', $company_id)->get()->toArray();
        $settings = array_column($settings, 'value', 'name');

        $data_settings = [];
        $data_settings["plain_text"] = date('d/m/Y H:i:s', strtotime(now()));
        $data_settings["secret_key"] = $request->secret_key;
        $data_settings["cryptograpich_hash"] = $request->cryptograpich_hash;
        $data_settings["output_hash"] = $request->output_hash;
        // Plain text input
        $plainText = $data_settings["plain_text"];

        // Secret key
        $secretKey = $data_settings["secret_key"];

        // Cryptographic hash function
        $hashFunction = $data_settings["cryptograpich_hash"];

        // Calculate HMAC (Hash-based Message Authentication Code)
        $hmac = hash_hmac($hashFunction, $plainText, $secretKey, true);

        // Choose output text format: Hex or Base64
        $outputFormat = $data_settings["output_hash"]; // 'hex' or 'base64'

        if ($outputFormat === 'hex') {
            $data_settings["hashed_output"] = bin2hex($hmac);
        } elseif ($outputFormat === 'base64') {
            $data_settings["hashed_output"] = base64_encode($hmac);
        }

        foreach ($data_settings as $key => $value) {
            $data = [
                'value' => $value,
                'company_id' => $company_id,
            ];
        
            if (array_key_exists($key, $settings)) {
                AccurateToken::where('name', $key)
                    ->where('company_id', $company_id)
                    ->update($data);
            } else {
                $data['name'] = $key;
                AccurateToken::create($data);
            }
        }
        
        //Write log
        createLog(static::$module, __FUNCTION__, 0);

        return redirect(route('admin.accurate.token'));
    }
}
