<?php

namespace App\Http\Controllers\Administrator;

use DataTables;
use App\Models\User;
use App\Models\Employee;
use App\Models\Warehouse;
use App\Models\LogAccurate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AccurateToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AccurateSyncController extends Controller
{
    private static $module = "accurate_sync";

    function createLogAccurate($module, $action,  $response){
        $company_id = getCompanyId();
        $data = LogAccurate::create([
            'module' => $module,
            'company_id' => $company_id,
            'flag' => $action,
            'data' => $response,
            'created_by' => auth()->user()->id,
        ]);
    }

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        $company_id = getCompanyId();
        
        $settings = AccurateToken::where('company_id', $company_id)->get()->toArray();
        
        $settings = array_column($settings, 'value', 'name');
        
        return view("administrator.accurate.sync", compact("settings"));
    }

    public function getData(Request $request)
    {   
        $company_id = getCompanyId();

        $query = LogAccurate::query();

        if ($company_id != 0) {
            $query->where('company_id', $company_id);
        }

        if ($request->date || $request->customer_id) {
            $query = $query->where(function ($data_search) use ($request) {
                if($request->date != "") {
                    $start_date = '';
                    $tanggal = explode("-", $request->date);
                    $start_date = date('Y-m-d', strtotime($tanggal[0]));
                    $end_date = date('Y-m-d', strtotime($tanggal[1]));
                    $data_search = $data_search->whereBetween('sales.date', [$start_date, $end_date]);
                }
                if ($request->customer_id != "") {
                    $data_search->where("sales.customer_id", $request->customer_id);
                }
            });
        }
        
          
        $data = $query->get();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn = "";
                if(isAllowed(static::$module, "detail"))://Check permission
                    $btn .= '<a href="' . route('admin.sales.detail', $row->id) . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                    <span class="svg-icon svg-icon-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="black"/>
                            <path opacity="0.3" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="black"/>
                        </svg>
                        </span>
                </a>';
                endif;
                return $btn;
            })->rawColumns(['action'])
            ->make(true);
    }

    public function getToken(Request $request)
    {
        $company_id = getCompanyId();

        $settings = AccurateToken::where('company_id', $company_id)->get()->toArray();
        $settings = array_column($settings, 'value', 'name');

        $data_settings = [];
        $data_settings["plain_text"] = date('d/m/Y H:i:s', strtotime(now()));
        
        // Plain text input
        $plainText = $data_settings["plain_text"];

        // Secret key
        $secretKey = $settings["secret_key"];

        // Cryptographic hash function
        $hashFunction = $settings["cryptograpich_hash"];

        // Calculate HMAC (Hash-based Message Authentication Code)
        $hmac = hash_hmac($hashFunction, $plainText, $secretKey, true);

        // Choose output text format: Hex or Base64
        $outputFormat = $settings["output_hash"]; // 'hex' or 'base64'

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

        $data = AccurateToken::where('company_id', $company_id)->get()->toArray();
        $data = array_column($data, 'value', 'name');

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dimuat',
            'output' => $data
        ],200);
    }
    
    // public function saveWarehouse(Request $request){
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //     CURLOPT_URL => 'https://public.accurate.id/accurate/api/warehouse/save.do',
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => '',
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 0,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => 'POST',
    //     CURLOPT_POSTFIELDS => array(
        //         'id' => ($request->accurate_id !== 0 ? $request->accurate_id : ''),
        //         'name' => $request->name,
    //         'pic' => $request->pic,
    //         'suspended' => $request->suspended
    //     ),
    //     CURLOPT_HTTPHEADER => array(
    //         'X-Api-Timestamp: ' . $request->timestamps,
    //         'X-Api-Signature: ' . $request->signature,
    //         'Authorization: Bearer aat.MTAw.eyJ2IjoxLCJ1Ijo2MDA4NjksImQiOjEwODc0NjIsImFpIjo0Mzg1MSwiYWsiOiJjY2E3MDU2MS00YTZlLTQzOGMtYmMzMS1kNjIwZjEwODQ4ODYiLCJhbiI6IkJhc2UiLCJhcCI6IjRmYWEzOWZmLWU4NDUtNGQxOC05YzQ1LTk5MTZlNWU2NmIzYiIsInQiOjE3MDQ4NjkxOTQwODF9.vM0Q4tm5ReY4yY5wVu0R7/vai01pfqVbWDYos/faAGqjcye/tw5c4ZZ15LBqcFTPdpxlyzKvR13mBGhlcyMgoorj/N4QkSd9TaFZPXRdc1W/KW7eWFXiNLi9uZ8QJsiilhBj3aHUq34PSry10UtnhrowPDXxDv19U1DYE7d5Cn5e9y3Hhx52MpoQFJfIn782JokpugzkVSI=.aZjMfZX9tH4+2vNnMWRu/j/GAMcndjgQjz0H2tqw6KM',
    //         'Cookie: JSESSIONID=1E9CB2AD39743156E8A6FAB00B45251E.accurate_accurateapp_tomcatsaccurate7'
    //     ),
    //     ));

    //     $response = curl_exec($curl);
    //     curl_close($curl);

    //     // Decode the JSON response
    //     $responseData = json_decode($response);

    //     // Check if decoding was successful
    //     if ($responseData && isset($responseData->r->id) && ($request->accurate_id === "0")) {
    //         // Update the Warehouse with the accurate_id
    //         $id = intVal($request->id);
    //         $warehouse = Warehouse::find($id)->first();
    //         $warehouse->update(['accurate_id' => $responseData->r->id]);

    //         // Log the response and create a log for the warehouse
    //     }
    //     $this->createLogAccurate('warehouse', 'Save', $response);
        
    //     // Print the response
    //     echo $response;
    // }
    
    public function saveWarehouse(Request $request){
        $company_id = getCompanyId();
        $accurateData = $request->data;
        $count = Warehouse::where('name', $accurateData['name'])->where('company_id', $company_id)->withTrashed()->get();

        // Check if decoding was successful
        if ($accurateData && ($count->count() === 0)) {
            // Update the Warehouse with the accurate_id
            $warehouse = Warehouse::create([
                'name' => $accurateData['name'],
                'code' => Str::slug($accurateData['name']),
                'pic' => $accurateData['pic'] ? $accurateData['pic'] : $accurateData['name'],
                'accurate_id' => $accurateData['id'],
                'status' => $accurateData['suspended'] === 'false' ? 't' : 'f',
                'company_id' => $company_id,
            ]);
            
            // Log the response and create a log for the warehouse
            $this->createLogAccurate('warehouse', 'Save from accurate', $warehouse);
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil disimpan',
                'module' => 'Warehouse',
            ]);
        } else if ($accurateData && ($count->count() === 1)){
            $data = $count->first();
            $data->update([
                'accurate_id' => $accurateData['id']
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil diupdate',
                'module' => 'Warehouse',
                'data' => $data
            ]);
        }

    }

    public function updateWarehouse(Request $request){
        $req = $request->data;
        $data = Warehouse::where('id', $req['id'])->withTrashed()->first();
        $data->update([
            'accurate_id' => 0
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil diupdate',
            'module' => 'Warehouse',
        ]);
    }

    
    public function getDataWarehouse(){
        $company_id = getCompanyId();
        $data = Warehouse::where('company_id', $company_id)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dimuat',
            'module' => 'Warehouse',
            'data' => $data
        ],200);
    }

    public function getDataWarehouseDeleted(){
        $company_id = getCompanyId();
        $data = Warehouse::where('company_id', $company_id)->onlyTrashed()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dimuat',
            'module' => 'Warehouse',
            'data' => $data
        ],200);
    }

    
    public function getDataEmployee(){
        $company_id = getCompanyId();
        $data = User::where('company_id', $company_id)->where('employee', 1)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dimuat',
            'module' => 'Employee',
            'data' => $data
        ],200);
    }

    public function getDataEmployeeDeleted(){
        $company_id = getCompanyId();
        $data = User::where('company_id', $company_id)->where('employee', 1)->onlyTrashed()->get();

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dimuat',
            'module' => 'Employee',
            'data' => $data
        ],200);
    }

    public function saveEmployee(Request $request){
        $company_id = getCompanyId();
        $accurateData = $request->data;
        $count = User::where('email', $accurateData['email'])->where('company_id', $company_id)->withTrashed()->get();

        // Check if decoding was successful
        if ($accurateData && ($count->count() === 0)) {
            // Update the Employee with the accurate_id
            $employee = User::create([
                'user_group_id' => 1,
                'employee' => 1,
                'name' => $accurateData['name'],
                'email' => $accurateData['email'],
                'password' => Hash::make($accurateData['email']),
                'accurate_id' => $accurateData['id'],
                'status' => $accurateData['suspended'] === 'false' ? 't' : 'f',
                'company_id' => $company_id,
                'remember_token' => Str::random(60)
            ]);
            
            // Log the response and create a log for the employee
            $this->createLogAccurate('employee', 'Save from accurate', $employee);
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil disimpan',
                'module' => 'Employee',
            ]);
        } else if ($accurateData && ($count->count() === 1)){
            $data = $count->first();
            $data->update([
                'accurate_id' => $accurateData['id']
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil diupdate',
                'module' => 'Employee',
                'data' => $data
            ]);
        }

    }

    public function updateEmployee(Request $request){
        $req = $request->data;
        $data = User::where('id', $req['id'])->withTrashed()->first();
        $data->update([
            'accurate_id' => 0
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil diupdate',
            'module' => 'Employee',
        ]);
    }
}
