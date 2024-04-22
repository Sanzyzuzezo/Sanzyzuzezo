<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;
use App\Models\CashRegister;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $cash_register = CashRegister::where('user_id', $user->id)
        ->where('status', 'Open')
        ->first();
        
        $is_open_cash_register = !empty($cash_register) ? true : false;

        $data = [
            'user' => $user,
            'cash_register' => $cash_register,
            'is_open_cash_register' => $is_open_cash_register
        ];

        return response()
            ->json([
                'status' => 200, 
                'message' => 'Data successfully loaded', 
                'data' => $data ]
            , 200);
        return auth()->user();
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['status'=> 400, 'message' => 'Bad Request', 'errors' => $validator->errors()], 400);       
        }
        $user = User::where('email', $request['email'])->first();

        if (!$user) {
            return response()->json([
                'status'=> 404,
                'message' => 'User Not Found'
            ], 404);
        }

        if($user->employee == 1) {
            $token = $user->createToken('auth_token')->plainTextToken;
            $data = [
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ];

            return response()->json([
                'status' => 200,
                'message' => 'You have successfully logged in',
                'data' => $data
        ], 200);
        }

        if ((!empty($user) && $user->cashier == 0) || (!auth()->guard('api')->attempt(['email' => $request->email, 'password' => $request->password])))
        {
            return response()
                ->json(['status'=> 401, 'message' => 'Unauthorized'], 401);
        }


        $user->tokens()->delete();
        
        $token = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ];

        return response()
            ->json(['status' => 200, 'message' => 'You have successfully logged in', 'data' => $data ], 200);
    }
    
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()
            ->json(['status' => 200, 'message' => 'You have successfully logged out and the token was successfully deleted'], 200);
    }
}
