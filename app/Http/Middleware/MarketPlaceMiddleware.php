<?php

namespace App\Http\Middleware;

use DB;
use Closure;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketPlaceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $bearer = $request->bearerToken();
        if (!$bearer) {
            return response()->json([
                'status' => 404,
                'message' => 'Token Not Found'
            ], 404);
        }
        
        $bearerParts = explode('|', $bearer);

        $id = $bearerParts[0];
        $tokenValue = $bearerParts[1];

        $token = DB::table('personal_access_tokens')
            ->where('token', hash('sha256', $tokenValue))
            ->where('id', $id)
            ->first();

        if ($token) {
            $user = Customers::find($token->tokenable_id);

            if ($user) {
                auth()->guard('api_marketplace')->login($user);
                return $next($request);
            }
        }

        return response()->json([
            'success' => false,
            'error' => 'Access denied.',
        ]);

    }
}
