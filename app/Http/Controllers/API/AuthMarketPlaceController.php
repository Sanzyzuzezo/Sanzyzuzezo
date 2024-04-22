<?php

namespace App\Http\Controllers\API;

use DB;
use Validator;
use App\Models\Customers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ResetPassword;
use App\Mail\ResetPasswordMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class AuthMarketPlaceController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => 'Bad Request', 'errors' => $validator->errors()], 400);
        }

        $user = Customers::where('email', $request['email'])->first();

        if (!$user) {
            return response()->json([
                'status'=> 404,
                'message' => 'User Not Found'
            ], 404);
        }

        if (!Hash::check($request['password'], $user->password)) {
            return response()->json(['status' => 401, 'message' => 'Unauthorized'], 401);
        }

        // Delete existing tokens (if any)
        $user->tokens()->delete();

        // Create a new token
        $token = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];

        return response()->json([
            'status' => 200,
            'message' => 'You have successfully logged in',
            'data' => $data,
        ]);
    }


    public function logout()
    {
        auth('api_marketplace')->tokens()->delete();

        return response()->json([
            'status' => 200,
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ], 200);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        // Dapatkan informasi pengguna dari Google
        // $googleUser = Socialite::driver('google')->user();

        // Cek apakah pengguna sudah terdaftar di sistem berdasarkan email
        $user = Customers::where('email', $request->email)->first();

        if (!$user) {
             // Pengguna belum terdaftar, buat akun baru

             $user = Customers::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => 0,
                'customer_group_id' => 0,
                'email_veryfied_at' => now(),
                'remember_token' => Str::random(60),
                'company_id' => $request->company_id
             ]);
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

    public function mailResetPassword(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:customers,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Bad Request',
                'errors' => $validator->errors()
            ], 400);
        }

        // Generate token dan update atau insert ke dalam tabel password_resets
        $email = $request->input('email');
        $token = Str::random(64);

        try {
            DB::beginTransaction();
            DB::table('password_resets')->updateOrInsert(
                ['email' => $email],
                ['token' => $token, 'created_at' => now()]
            );
            DB::commit();
            
            // Ambil informasi pengguna berdasarkan email
            $user = Customers::where('email', $email)->first();
            
            // Jika pengguna tidak ditemukan, kembalikan response error
            if (!$user) {
                DB::rollback();
                return response()->json([
                    'status' => 404,
                    'message' => 'User Not Found'
                ], 404);
            }
    
            // Persiapkan data untuk email
            $mailData = [
                'title' => 'Reset Password',
                'email' => $email,
                'token' => $token,
                'username' => $user->name,
                // 'resetLink' => route('admin.profile.password.reset', $token),
                'resetLink' => $token,
            ];
            
            // Kirim email reset password
            Mail::to($email)->send(new ResetPasswordMail($mailData));
            
            // Berikan response berhasil
            return response()->json([
                'status' => 200,
                'message' => 'We have successfully sent a link for password reset'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'konfirmasi_password' => 'required|min:8|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Bad Request',
                'errors' => $validator->errors()
            ], 400);
        }

        $email = $request->input('email');
        $token = $request->input('token');

        // Verifikasi token dan email pada tabel reset password
        $resetPassword = ResetPassword::where('token', $token)
            ->where('email', $email)
            ->first();

        // Jika token atau email tidak sesuai, kembalikan response error
        if (!$resetPassword) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid email or token'
            ], 400);
        }

        // Cari pengguna berdasarkan email
        $user = Customers::where('email', $email)->first();

        // Jika pengguna tidak ditemukan, kembalikan response error
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User Not Found'
            ], 404);
        }

        try {
            DB::beginTransaction();
            // Update password pengguna
            $user->update([
                'password' => Hash::make($request->input('password')),
                'remember_token' => Str::random(60),
            ]);

            // Hapus token dari tabel reset password
            ResetPassword::where('token', $token)
                ->where('email', $email)
                ->delete();

            // Berikan response berhasil
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Password has been reset successfully'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage()
            ], 500);
        }

    }

}

