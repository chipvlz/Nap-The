<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\ApiToken\ApiTokenRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiTokenController extends Controller
{
    public  function  __construct(ApiTokenRepositoryInterface $apiToken)
    {
        $this->apiToken = $apiToken;
    }

    public function  index()
    {
        $dataApi = $this->apiToken->all();
        return view('backend.page.api.index', compact('dataApi'));
    }
    public function  generateKey()
    {
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        if ($this->apiToken->save(['token'=>$token])) {
            return redirect()->back()->with('success', 'Tạo key API thành công !');
        } else {
            return redirect()->back()->withErrors('Lỗi tạo key API!');
        }
    }

    public function stopAndOpenApi(Request $request)
    {
        $active = $request->get('active', 'int');
        $id = $request->get('id', 'int');
        $response = [];
        if ($this->apiToken->update($id, ['active'=>$active])) {
            $response['status']=1;
            $response['message'] = 'Cập nhật thành công';
        } else {
            $response['status']=0;
            $response['message'] = 'Lỗi xử lý';
        }
        return response()->json($response);
    }
}