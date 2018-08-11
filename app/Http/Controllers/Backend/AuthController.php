<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function  login()
    {
        return view('backend.login');
    }

    public function  processLogin(Requests\LoginRequest $request)
    {
        $dataRequest = $request->except(['_token']);
        if (Auth::attempt($dataRequest,true)) {
            return redirect()->route('home.index');
        }
        else{
            return redirect()->back()->withErrors("Số điện thoại hoặc mật khẩu không đúng")->withInput($request->all());
        }
    }

    public function  logout()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }
}
