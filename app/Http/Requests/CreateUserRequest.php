<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateUserRequest extends Request
{
    public function authorize()
    {
        return true;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'fullname'=>'required|max:255',
            'name'=>'required|max:25|min:6',
            'email'=>'required|unique:users|email',
            'phone'=>'required|unique:users|max:12|min:10',
            'password'=>'required|max:16|min:6',
            'confirm_password'=> 'same:password',
        ];
    }

    public function messages()
    {
        return [
            'fullname.required' => 'Bạn chưa nhập họ tên !',
            'fullname.max'  => 'Họ tên từ 10 đến 255 ký tự!',

            'name.required' => 'Bạn chưa nhập username !',
            'name.max'  => 'Username từ 10 đến 255 ký tự!',
            'name.min'  => 'Username phải từ 6 ký tự !',

            'email.required' => 'Bạn chưa nhập email !',
            'email.unique'  => 'Email đã tồn tại',
            'email.email'  => 'Sai định dạng mới',

            'phone.required' => 'Bạn chưa nhập số điện thoại !',
            'phone.unique'  => 'Số điện thoại đã tồn tại',

            'password.required' => 'Bạn chưa nhập mật khẩu mới !',
            'password.max'  => 'Mật khẩu mới nhỏ hơn 16 ký tự !',
            'password.min'  => 'Mật khẩu mới phải từ 6 ký tự !',
            'confirm_password.same'=>'Nhập lại mật khẩu mới không đúng!'

        ];
    }
}
