<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderUpdateStatusRequest extends FormRequest
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

    public function rules()
    {
        return [
            'order_id' => 'required',
            'status'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'order_id.required' => 'Dữ liệu không được để trống',
            'status.required'   => 'Dữ liệu không được để trống',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'  => 'fail',
            'message' => 'Validation errors',
            'data'    => $validator->errors()
        ]));
    }
}
