<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\ApiToken\ApiTokenRepositoryInterface;
use App\Repositories\PayCard\PayCardRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PayCardController extends Controller
{

    public function  __construct(PayCardRepositoryInterface $payCard, ApiTokenRepositoryInterface $api)
    {
        $this->payCard = $payCard;
        $this->api = $api;
    }

    public function index()
    {
        $dataProvider = $this->api->all();
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
}
