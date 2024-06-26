<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            "name" => "required",
            "email" => "required",
            // "phone" => "required",
            "subject" => "required",
            "description" => "required"
        ];
    }

    // protected function failedValidation(Validator $validator) {

    //     throw new HttpResponseException(response()->json([
    //         'errors' => $validator->errors(),
    //         'status' => true
    //     ], 422));
    // }
}
