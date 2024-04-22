<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;

class PaymentMethodController extends Controller
{
    public function payment_method(){
        $payment_method = PaymentMethod::select('payment_methods.id', 'payment_methods.name', 'payment_methods.icon', 'payment_methods.icon_active')
        ->with('PaymentMethodDetails:id,payment_method_id,name')->get();
        $payment_method->map(function($pm){
        	$pm->icon = $pm->icon != null ? img_src($pm->icon, 'payment_methods') : img_src('default.jpg', '');
        	$pm->icon_active = $pm->icon_active != null ? img_src($pm->icon_active, 'payment_methods') : img_src('default.jpg', '');
        });

        return response()->json([
            'status' => 200, 
            'message' => 'Data successfully',
            'data' => $payment_method,
        ]);
    }
}
