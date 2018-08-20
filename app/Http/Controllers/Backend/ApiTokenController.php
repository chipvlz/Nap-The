<?php

namespace App\Http\Controllers\Backend;

use App\Models\ApiToken;
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
    public function  generateKey(Requests\CreateApiTokenRequest $request)
    {
        $provider = $request->get('provider', '');
        $token = bin2hex(openssl_random_pseudo_bytes(16));
        if ($this->apiToken->save(['token'=>$token,'provider'=>$provider])) {
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

    public function stopMoreApi(Request $request)
    {
            $paramId = $request->get('param');
            $response = [];
            if (!empty($paramId)) {
                $arrId = explode(',', $paramId);
                foreach ($arrId as $item) {
                  $api = ApiToken::find((int)$item);
                  $api->active = 0;
                  $api->save();
                }
            }
        return response()->json($response);
    }
    public function openMoreApi(Request $request)
    {
        $paramId = $request->get('param');
        $response = [];
        if (!empty($paramId)) {
            $arrId = explode(',', $paramId);
            foreach ($arrId as $item) {
                $api = ApiToken::find((int)$item);
                $api->active = 1;
                $api->save();
            }
        }
        return response()->json($response);
    }
}
