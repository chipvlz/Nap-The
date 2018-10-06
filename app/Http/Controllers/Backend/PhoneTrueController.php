<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\PhoneTrue\PhoneTrueRepositoryInterface;
use Illuminate\Http\Request;
use App\Support\Helper;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PhoneTrueController extends Controller
{
    public function  __construct(PhoneTrueRepositoryInterface $phoneTrue)
    {
        $this->phoneTrue = $phoneTrue;
    }

    public function index()
    {
        return view('backend.page.phone_true.index');
    }

    public function add()
    {
        return view('backend.page.phone_true.add');
    }

    public function processEnterPhone(Request $request)
    {
        try {
            $phoneInfo = $request->except('_token')['info_phone'];
            $money = $request->except('_token')['money'];
            if (!empty($phoneInfo)) {
                $phoneInfo = preg_replace(array('/\n/', '/\r/'), '#', $phoneInfo);
                $arrPhoneSplit = explode('##', $phoneInfo);
                foreach ($arrPhoneSplit as $item) {
                    $itemInfo = preg_replace(array('/\t/'), '_', $item);
                    $arrItemSplit = explode('_', $itemInfo);
                    $data = [
                        'phone' => $arrItemSplit[0],
                        'money' => (empty($money)) ? $arrItemSplit[1] : $money,
                        'status' => 0,
                        'created_user' => \Auth::user()->name
                    ];
                    $this->phoneTrue->save($data);
                }
                return redirect()->route('phone-true.index')->with('success', 'Thêm mới thành công!');
            } else {
                return redirect()->back()->withErrors('Vui lòng nhập danh sách số điện thoại!');
            }
        }catch (\Exception $ex) {
            return redirect()->back()->withErrors('Lỗi nhập danh sách sim');
        }
    }
    public function processListPhone(Request $request)
    {
        $param = [];
        $param['status'] = (int)($request->has('status')) ? $request->get('status') : 999;
        $param['phone'] = ($request->has('phone')) ? $request->get('phone') : '';

        $dataPhone = $this->phoneTrue->searchAndList($param['status'], $param['phone']);
        $data = [];
        $total['money_total']=0;
        $total['money_total_change']=0;
        foreach ($dataPhone as $item) {
            $aaRow = $item->toArray();
            $aaRow['phone_name']=Helper::formatPhoneNumber($item->phone);
            $aaRow['status'] =config('constant.status_true')[$item->status];
            $aaRow['status_key'] =$item->status;
            $aaRow['money']=number_format($item->money);
            $aaRow['money_change']=number_format($item->money_change);
            $data[]=$aaRow;
            $total['money_total'] +=(int)$item->money ;
            $total['money_total_change'] +=(int)$item->money_change ;
        }
        $total['money_total']=number_format($total['money_total']);
        $total['money_total_change']=number_format($total['money_total_change']);
        return response()->json([
            'total'=>$total,
            'data'=>$data,

        ]);
    }
    public function  simMoneyTrue(Request $request)
    {
        $response = [];
        $paramId = $request->get('param');
        if (!empty($paramId)) {
            $arrId = explode(',', $paramId);
            foreach ($arrId as $item) {
                $param['status'] = 1;
                if ($this->phoneTrue->update((int)$item, $param)) {
                    $response['status'] = 1;
                    $response['message'] = 'Xét sim đúng giá thành công!';
                } else {
                    $response['status'] = 0;
                    $response['message'] = 'Lỗi xử lý !';
                }
            }
        }
        return response()->json($response);
    }
    public function  simMoneyMap(Request $request)
    {
        $response = [];
        $paramId = $request->get('param');
        if (!empty($paramId)) {
            $arrId = explode(',', $paramId);
            foreach ($arrId as $item) {
                $param['status'] = 2;
                if ($this->phoneTrue->update((int)$item, $param)) {
                    $response['status'] = 1;
                    $response['message'] = 'Xét sim đúng giá thành công!';
                } else {
                    $response['status'] = 0;
                    $response['message'] = 'Lỗi xử lý !';
                }
            }
        }
        return response()->json($response);
    }
}
