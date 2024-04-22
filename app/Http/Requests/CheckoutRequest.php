<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'addres_id' => 'required',
            'address' => 'required',
            'bank_account' => 'required',
            'firstname' => 'required',
            // item => [{product_id => "3", variant_id => "3", quantity => "4", price => "13500", note => null},…],
            'order_total' => 'required',
            'payment_method' => 'required',
            'postalcode' => 'required',
            // radio-'group' => 'required',
            'shipping_city' => 'required',
            'shipping_city_label' => 'required',
            'shipping_cost' => 'required',
            'shipping_courier' => 'required',
            'shipping_distric' => 'required',
            'shipping_distric_label' => 'required',
            'shipping_province' => 'required',
            'shipping_province_label' => 'required',
            'shipping_service' => 'required',
        ];
    }


}
