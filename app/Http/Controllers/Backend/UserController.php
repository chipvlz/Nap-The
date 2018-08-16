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

    public function  addUser()
    {
        return view('backend.page.user.add');
    }

    public  function processAddUser(Requests\CreateUserRequest $request)
    {
        $dataRequest = $request->except('_token');
        if ($this->user->save($dataRequest)) {
            return redirect()->route('user.index')->with('success','Thêm mới user thành công!');
        } else {
            return redirect()->back()->withErrors('Lỗi thêm mới user!');
        }
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

    public function  delete($id)
    {
        if ($this->user->delete($id)) {
            return redirect()->back()->with('success','Xóa user thành công!');
        } else {
            return redirect()->back()->withErrors('Lỗi xóa user!');
        }
    }
}
