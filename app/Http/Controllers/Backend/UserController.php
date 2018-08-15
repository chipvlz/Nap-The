<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function  __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    public function  index()
    {
        $dataUser = $this->user->all();
        return view('backend.page.user.index', compact('dataUser'));
    }
    public function  resetPassword()
    {
        return view('backend.page.user.reset_password');
    }

    public function  processResetPassword(Requests\ResetPasswordRequest $request)
    {
        $dataRequest = $request->except('_token');
        if (\Hash::check($dataRequest['password_old'],\Auth::user()->password)) {
            $data = [
              'password' => $dataRequest['password_new']
            ];
            $userId = \Auth::user()->id;
            if ($this->user->update($userId, $data)) {
                \Auth::logout();
                return redirect()->route('auth.logout')->with('success','Đổi mật khẩu thành công !');
            } else {
                return redirect()->back()->withErrors('Lỗi đổi mật khẩu!');
            }
        } else {
            return redirect()->back()->withErrors('Mật khẩu cũ không đúng!');
        }
    }

    public function profile()
    {
        return view('backend.page.user.profile');
    }
}
