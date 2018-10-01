<?php

namespace App\Http\Controllers\Backend;

use App\Models\ApiToken;
use App\Models\Price;
use App\Repositories\ApiToken\ApiTokenRepositoryInterface;
use App\Repositories\PayCard\PayCardRepositoryInterface;
use App\Repositories\Phone\PhoneRepositoryInterface;
use App\Support\Helper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PayCardController extends Controller
{

    public function  __construct(PayCardRepositoryInterface $payCard,PhoneRepositoryInterface $phone, ApiTokenRepositoryInterface $api, ApiTokenRepositoryInterface $apiToken)
    {
        $this->payCard = $payCard;
        $this->phone = $phone;
        $this->api = $api;
        $this->apiToken = $apiToken;
    }

    public function index()
    {
        if(empty(\Auth::user()->is_admin)) {
            $dataProvider = $this->api->all();
        } else {
            $token = \Auth::user()->token;
            $dataProvider = ApiToken::where('token', $token)->get();
        }
        return view('backend.page.pay_card.index', compact('dataProvider'));
    }

    public  function processReport(Request $request)
    {
        $param = [];
        $param['dateForm'] = ($request->has('dateFrom')) ? date('Y-m-d', strtotime($request->get('dateFrom'))) : date('Y-m-d');
        $param['dateTo'] = ($request->has('dateTo')) ? date('Y-m-d', strtotime($request->get('dateTo'))) : date('Y-m-d');
        $param['status'] = (int)($request->has('status')) ? $request->get('status') : 999;
        $param['provider'] = ($request->has('provider')) ? $request->get('provider') : 999;
        $param['phone'] = ($request->has('phone')) ? $request->get('phone') : '';
        $column = $request->get("columns");
        $order = $request->get('order');
        $index=$order[0]["column"];
        $sort = $order[0]["dir"];
        $start = $request->get('start');
        $length = $request->get('length');
        $columnNameSort = $column[(int)$index]["name"];
        $data = [];
        $data['draw'] = (int)$request->get("draw", "int");
        $dataReport = $this->payCard->searchAndList($param['dateForm'], $param['dateTo'], $param['status'], $param['phone'], $param['provider'],$start, $length, $columnNameSort, $sort);
        $data['recordsTotal'] = (int)$dataReport['count_record'];
        $data['recordsFiltered'] = (int)$dataReport['count_record'];
        $data['total_money_request'] = $dataReport['total_money_request'];
        $data['total_money_response'] = $dataReport['total_money_response'];
        $data['data'] = $dataReport['record']->toArray();

        return response()->json($data);
    }

    public function addCard()
    {
        $price = Price::where('status',1)->orderBy('money', 'ASC')->get();
        return view('backend.page.pay_card.add_card', compact('price'));
    }

    public function processAddCard(Request $request)
    {
        $token = \Auth::user()->token;
        $response=[];

            $param['moneyRequest'] = (int)$request->get('money');
            $param['seriCardRequest'] = $request->get('card_seri', 'string');
            $param['codeCardRequest'] = $request->get('card_code', 'string');
            $param['token'] = $token;
            $checkKeyApi = $this->apiToken->findAttribute('token', $param['token']);
            if ($checkKeyApi) {
                $phoneForMoney = $this->phone->getPhoneForMoney($param['moneyRequest']);
                if ($phoneForMoney) {
                    $dataResponse = Helper::payCard($param['codeCardRequest'], $phoneForMoney->phone);
                    if ($dataResponse['error_code'] == 1) {
                        $response['status'] = 10; // sai mã thẻ
                        $response['message'] = $dataResponse['message'];
                    } else if ($dataResponse['error_code'] == 2) {
                        $response['status'] = 11;// nạp quá 5 lần
                        $response['message'] = $dataResponse['message'];

                    }else if($dataResponse['error_code'] == 4910)  {
                        $response['status'] = 15;
                        $response['message'] = $dataResponse['message'];
                    }
                    else if ($dataResponse['error_code'] == 0) {
                        $param['moneyResponse'] = (int)explode(" ",  $dataResponse['message'])[7];
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
            } else {
                $response['status'] = 12;
                $response['message'] = "Key Api không đúng hoặc đã bị khóa";
            }
            if ($response['status']==1) {
                return redirect()->back()->with('success', $response['message']);

            } else {
                return redirect()->back()->withErrors($response['message']);

            }


    }
}
