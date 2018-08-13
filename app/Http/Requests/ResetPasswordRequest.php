<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ResetPasswordRequest extends Request
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
            'password_old'=>'required|max:16|min:6',
            'password_new'=>'required|max:16|min:6',
            'confirm_password'=> 'same:password_new',
        ];
    }

    public function messages()
    {
        return [
            'password_old.required' => 'Bạn chưa nhập mật khẩu cũ !',
            'password_old.max'  => 'Mật khẩu nhỏ hơn 16 ký tự !',
            'password_old.min'  => 'Mật khẩu phải từ 6 ký tự !',

            'password_new.required' => 'Bạn chưa nhập mật khẩu mới !',
            'password_new.max'  => 'Mật khẩu mới nhỏ hơn 16 ký tự !',
            'password_new.min'  => 'Mật khẩu mới phải từ 6 ký tự !',
            'confirm_password.same'=>'Nhập lại mật khẩu mới không đúng!'

        ];
    }
}
