<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\Phone\PhoneRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function  __construct(PhoneRepositoryInterface $phone)
    {
        $this->phone = $phone;
    }

    public function addCard(Request $request)
    {
        $param = [];
        $response=[];
        $param['moneyRequest'] = $request->get('money');
        $param['seriCardRequest'] = $request->get('seri');
        $param['codeCardRequest'] = $request->get('code');
        $param['moneyResponse'] = 10000;
        $phoneForMoney = $this->phone->getPhoneForMoney($param['moneyRequest']);
        if($phoneForMoney) {
            $phoneForMoney->money_change+=(int)$param['moneyRequest'];
            $money = (int)$phoneForMoney->money-(int)$phoneForMoney->money_change;
            if($money==0) {
                $phoneForMoney->status=2;
            } else if ($money>0) {
                $phoneForMoney->status=1;
            }
            $data = [
                'money_change'=>$phoneForMoney->money_change,
                'status' => $phoneForMoney->status
            ];
            if($this->phone->update($phoneForMoney->id, $data)) {
                $response['status'] = 1;
                $response['message'] = "Bạn nạp thành công";
            } else {
                $response['status'] = 4;
                $response['message'] = "Lỗi xử lý";
            }
        } else {
            $response['status'] = 5;
            $response['message'] = "Điều kiện không đáp ứng";
        }
        return response()->json($response);
    }
}
