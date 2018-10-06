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

    public function  __construct(PayCardRepositoryInterface $payCard, PhoneRepositoryInterface $phone, ApiTokenRepositoryInterface $api, ApiTokenRepositoryInterface $apiToken)
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
        $url ="http://sim4gpro.net/api/v1/nap-the?seri={$param['seriCardRequest']}&code={$param['codeCardRequest']}&money={$param['moneyRequest']}&token={$token}";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($result,true);
        if ($response['status']==1) {
            return redirect()->back()->with('success', $response['message']);
        } else {
            return redirect()->back()->withErrors($response['message']);
        }


    }
}
