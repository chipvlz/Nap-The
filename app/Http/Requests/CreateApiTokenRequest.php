<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateApiTokenRequest extends Request
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
            'provider'=>'required|unique:api_token',
            ];
    }

    public function messages()
    {
        return [
            'provider.required' => 'Bạn chưa nhập đối tác!',
            'provider.unique'  => 'Đối tác đã tồn tại',
            ];
    }
}
