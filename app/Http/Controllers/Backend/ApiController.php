<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\PayCard\PayCardRepositoryInterface;
use App\Repositories\Phone\PhoneRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function  __construct(PhoneRepositoryInterface $phone, PayCardRepositoryInterface $payCard)
    {
        $this->phone = $phone;
        $this->PayCard = $payCard;
    }

    public function addCard(Request $request)
    {
        $param = [];
        $response=[];
        $param['moneyRequest'] = (int)$request->get('money');
        $param['seriCardRequest'] = $request->get('seri','string');
        $param['codeCardRequest'] = $request->get('code','string');
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
                //save log
                    $param['card_seri'] = $param['seriCardRequest'];
                    $param['card_code'] = $param['codeCardRequest'];
                    $param['money_request'] = $param['moneyRequest'];
                    $param['phone'] =  $phoneForMoney->phone;
                    $param['money_response'] = $param['moneyResponse'];
                    if($param['money_response']!= $param['money_request']) {
                        $param['status'] =  0;
                    }else {
                        $param['status'] =  1;
                    }
                    if($this->PayCard->save($param)) {
                        $response['status'] = 1;
                        $response['message'] = "Bạn nạp thẻ thành công";
                    } else {
                        $response['status'] = 4;
                        $response['message'] = "Lỗi xử lý";
                    }

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
