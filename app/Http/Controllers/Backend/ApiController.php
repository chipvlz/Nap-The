<?php

namespace App\Http\Controllers\Backend;

use App\Models\PayCard;
use App\Repositories\ApiToken\ApiTokenRepositoryInterface;
use App\Repositories\PayCard\PayCardRepositoryInterface;
use App\Repositories\Phone\PhoneRepositoryInterface;
use App\Repositories\PhoneTrue\PhoneTrueRepositoryInterface;
use App\Support\Helper;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function  __construct(PhoneRepositoryInterface $phone,
                                 PayCardRepositoryInterface $payCard,
                                 ApiTokenRepositoryInterface $apiToken,
                                PhoneTrueRepositoryInterface $phoneTrue
    )
    {
        $this->phone = $phone;
        $this->PayCard = $payCard;
        $this->apiToken = $apiToken;
        $this->phoneTrue = $phoneTrue;
    }

    public function addCard(Request $request)
    {
        $param = [];
        $response=[];
        try {
            $param['moneyRequest'] = (int)$request->get('money');
            $param['seriCardRequest'] = $request->get('seri', 'string');
            $param['codeCardRequest'] = $request->get('code', 'string');
            $param['token'] = $request->get('token', 'string');
            if ($param['moneyRequest']==20000) {
                if(strlen($param['codeCardRequest'])==14 && strlen($param['seriCardRequest'])==14 ) {
                    return response()->json(Helper::pay($param['codeCardRequest'], $param['seriCardRequest'], $param['moneyRequest']));
                }
            }
            $checkKeyApi = $this->apiToken->findAttribute('token', $param['token']);
            if ($checkKeyApi) {
                if($param['moneyRequest']>=50000 && $param['moneyRequest']%50000==0) {
                    //sim true
                    $phoneMoneyTrue = $this->phoneTrue->getPhoneMoneyTrue($param['moneyRequest']);
                    if ($phoneMoneyTrue) {
                        $dataResponse = Helper::payCard($param['codeCardRequest'], $phoneMoneyTrue->phone);
                        if ($dataResponse['error_code'] == 1) {
                            $response['status'] = 10; // sai mã thẻ
                            $response['message'] = $dataResponse['message'];
                        } else if ($dataResponse['error_code'] == 2) {
                            $response['status'] = 11;// nạp quá 5 lần
                            $response['message'] = $dataResponse['message'];
                        } else if ($dataResponse['error_code'] == 0) {
                            $param['moneyResponse'] = $param['moneyResponse'];
                            $phoneMoneyTrue->money_change += (int)$param['moneyResponse'];
                        }
                        $data = [
                            'money_change' => $phoneMoneyTrue->money_change,
                        ];
                        if ($this->phoneTrue->update($phoneMoneyTrue->id, $data)) {
                            //save log
                            $param['card_seri'] = $param['seriCardRequest'];
                            $param['card_code'] = $param['codeCardRequest'];
                            $param['money_request'] = $param['moneyRequest'];
                            $param['phone'] = $phoneMoneyTrue->phone;
                            $param['provider'] = $checkKeyApi->provider;
                            $param['money_response'] = $param['moneyResponse'];
                            if ($param['money_response'] != $param['money_request']) {
                                $param['status'] = 0;
                            } else {
                                $param['status'] = 1;
                            }
                            if ($this->PayCard->save($param)) {
                                $response['status'] = 1;
                                $response['message'] = $dataResponse['message'];
                            } else {
                                $response['status'] = 4;
                                $response['message'] = "Lỗi xử lý";
                            }

                        } else {
                            $response['status'] = 4;
                            $response['message'] = "Lỗi xử lý";
                        }
                    } else {
                        //sim map
                        $phoneMoneyMap = $this->phoneTrue->getPhoneMoneyMap($param['moneyRequest']);
                        if ($phoneMoneyMap) {
                            $dataResponse = Helper::payCard($param['codeCardRequest'], $phoneMoneyMap->phone);
                            if ($dataResponse['error_code'] == 1) {
                                $response['status'] = 10; // sai mã thẻ
                                $response['message'] = $dataResponse['message'];
                            } else if ($dataResponse['error_code'] == 2) {
                                $response['status'] = 11;// nạp quá 5 lần
                                $response['message'] = $dataResponse['message'];
                            } else if ($dataResponse['error_code'] == 0) {
                                $param['moneyResponse'] = $param['moneyResponse'];
                                $phoneMoneyMap->money_change += (int)$param['moneyResponse'];
                            }

                            $data = [
                                'money_change' => $phoneMoneyMap->money_change,
                            ];

                            if ($this->phoneTrue->update($phoneMoneyMap->id, $data)) {
                                //save log
                                $param['card_seri'] = $param['seriCardRequest'];
                                $param['card_code'] = $param['codeCardRequest'];
                                $param['money_request'] = $param['moneyRequest'];
                                $param['phone'] = $phoneMoneyMap->phone;
                                $param['provider'] = $checkKeyApi->provider;
                                $param['money_response'] = $param['moneyResponse'];
                                if ($param['money_response'] != $param['money_request']) {
                                    $param['status'] = 0;
                                } else {
                                    $param['status'] = 1;
                                }
                                if ($this->PayCard->save($param)) {
                                    $response['status'] = 1;
                                    $response['message'] = $dataResponse['message'];
                                } else {
                                    $response['status'] = 4;
                                    $response['message'] = "Lỗi xử lý";
                                }

                            } else {
                                $response['status'] = 4;
                                $response['message'] = "Lỗi xử lý";
                            }
                        } else {
                            $phoneForMoney = $this->phone->getPhoneForMoney($param['moneyRequest']);
                            if ($phoneForMoney) {
                                $dataResponse = Helper::payCard($param['codeCardRequest'], $phoneForMoney->phone);
                                if ($dataResponse['error_code'] == 1) {
                                    $response['status'] = 10; // sai mã thẻ
                                    $response['message'] = $dataResponse['message'];
                                } else if ($dataResponse['error_code'] == 2) {
                                    $response['status'] = 11;// nạp quá 5 lần
                                    $response['message'] = $dataResponse['message'];
                                } else if ($dataResponse['error_code'] == 0) {
                                    $param['moneyResponse'] = (int)explode(" ", $dataResponse['message'])[7];
                                    $phoneForMoney->money_change += (int)$param['moneyResponse'];
                                    $money = (int)$phoneForMoney->money - (int)$phoneForMoney->money_change;
                                    if ($money == 0) {
                                        $phoneForMoney->status = 2;
                                    } else if ($money > 0) {
                                        if ($phoneForMoney->status != 3) {
                                            $phoneForMoney->status = 1;
                                        }
                                    }
                                    $data = [
                                        'money_change' => $phoneForMoney->money_change,
                                        'status' => $phoneForMoney->status
                                    ];
                                    if ($this->phone->update($phoneForMoney->id, $data)) {
                                        //save log
                                        $param['card_seri'] = $param['seriCardRequest'];
                                        $param['card_code'] = $param['codeCardRequest'];
                                        $param['money_request'] = $param['moneyRequest'];
                                        $param['phone'] = $phoneForMoney->phone;
                                        $param['provider'] = $checkKeyApi->provider;
                                        $param['money_response'] = $param['moneyResponse'];
                                        if ($param['money_response'] != $param['money_request']) {
                                            $param['status'] = 0;
                                        } else {
                                            $param['status'] = 1;
                                        }
                                        if ($this->PayCard->save($param)) {
                                            $response['status'] = 1;
                                            $response['message'] = $dataResponse['message'];
                                        } else {
                                            $response['status'] = 4;
                                            $response['message'] = "Lỗi xử lý";
                                        }

                                    } else {
                                        $response['status'] = 4;
                                        $response['message'] = "Lỗi xử lý";
                                    }
                                }
                            } else {
                                $response['status'] = 5;
                                $response['message'] = "Điều kiện không đáp ứng";
                            }
                        }
                    }
                } else {
                    $phoneForMoney = $this->phone->getPhoneForMoney($param['moneyRequest']);
                    if ($phoneForMoney) {
                        $dataResponse = Helper::payCard($param['codeCardRequest'], $phoneForMoney->phone);
                        if ($dataResponse['error_code'] == 1) {
                            $response['status'] = 10; // sai mã thẻ
                            $response['message'] = $dataResponse['message'];
                        } else if ($dataResponse['error_code'] == 2) {
                            $response['status'] = 11;// nạp quá 5 lần
                            $response['message'] = $dataResponse['message'];
                        } else if ($dataResponse['error_code'] == 0) {
                            $param['moneyResponse'] = (int)explode(" ", $dataResponse['message'])[7];
                            $phoneForMoney->money_change += (int)$param['moneyResponse'];
                            $money = (int)$phoneForMoney->money - (int)$phoneForMoney->money_change;
                            if ($money == 0) {
                                $phoneForMoney->status = 2;
                            } else if ($money > 0) {
                                if ($phoneForMoney->status != 3) {
                                    $phoneForMoney->status = 1;
                                }
                            }
                            $data = [
                                'money_change' => $phoneForMoney->money_change,
                                'status' => $phoneForMoney->status
                            ];
                            if ($this->phone->update($phoneForMoney->id, $data)) {
                                //save log
                                $param['card_seri'] = $param['seriCardRequest'];
                                $param['card_code'] = $param['codeCardRequest'];
                                $param['money_request'] = $param['moneyRequest'];
                                $param['phone'] = $phoneForMoney->phone;
                                $param['provider'] = $checkKeyApi->provider;
                                $param['money_response'] = $param['moneyResponse'];
                                if ($param['money_response'] != $param['money_request']) {
                                    $param['status'] = 0;
                                } else {
                                    $param['status'] = 1;
                                }
                                if ($this->PayCard->save($param)) {
                                    $response['status'] = 1;
                                    $response['message'] = $dataResponse['message'];
                                } else {
                                    $response['status'] = 4;
                                    $response['message'] = "Lỗi xử lý";
                                }

                            } else {
                                $response['status'] = 4;
                                $response['message'] = "Lỗi xử lý";
                            }
                        }
                    } else {
                        $response['status'] = 5;
                        $response['message'] = "Điều kiện không đáp ứng";
                    }
                }
            } else {
                $response['status'] = 12;
                $response['message'] = "Key Api không đúng hoặc đã bị khóa";
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            $response['status'] = 4;
            $response['message'] = "Lỗi xử lý";
        }
        Log::info('Log:'.json_encode($param).'-message'.json_encode($response));
        return response()->json($response);
    }

    public function testAPI(Request $request)
    {

    }

}
