<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class OrderCreateRequestApi extends FormRequest
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
            'name'        => 'required',
            // 'address'     => 'required',
            'phone'       => 'required',
            'total_money' => 'required',
            'products'    => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'name.required'        => 'Dữ liệu không được để trống',
            // 'address.required'     => 'Dữ liệu không được để trống',
            'phone.required'       => 'Dữ liệu không được để trống',
            'total_money.required' => 'Dữ liệu không được để trống',
            'products.required'    => 'Dữ liệu không được để trống',
            'products.array'       => 'Sản phẩm phải là một mảng',
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
