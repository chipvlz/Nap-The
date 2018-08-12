<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\Phone\PhoneRepositoryInterface;
use App\Support\Helper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PhoneController extends Controller
{
    public  function  __construct(PhoneRepositoryInterface $phone)
    {
        $this->phone = $phone;
    }

    public function  index()
    {
        return view('backend.page.phone.add');
    }

    public function processUploadFile(Request $request)
    {
        $dir = 'uploads/phone';
        if ($request->hasFile('file')) {
            $file = $request->file;
            $file->move($dir, $file->getClientOriginalName());
            $pathFile = $dir.'/'.$file->getClientOriginalName();
            dd(Helper::loadFile($pathFile)->get());
        }
    }

    public function processEnterPhone(Request $request)
    {
        $phoneInfo = $request->except('_token')['info_phone'];
        if (!empty($phoneInfo)) {
            $phoneInfo = preg_replace(array('/\n/', '/\r/'), '#', $phoneInfo);
            $arrPhoneSplit = explode('##', $phoneInfo);
            foreach ($arrPhoneSplit as $item) {
                $arrItemSplit = explode('-', $item);
                $data = [
                    'phone' => $arrItemSplit[0],
                    'type' => $arrItemSplit[1],
                    'money' => $arrItemSplit[2],
                    'status' => 0,
                    'created_user' => \Auth::user()->name
                ];
                if ($this->phone->save($data)) {
                    return redirect()->route('phone.index')->with('success', 'Thêm mới thành công!');
                } else {
                    return redirect()->back()->withErrors('Lỗi trong quá trình xử lý!');
                }
            }
        } else {
            return redirect()->back()->withErrors('Vui lòng nhập danh sách số điện thoại!');
        }

    }

    public function listPhone()
    {
        return view('backend.page.phone.index');
    }

    public function processListPhone(Request $request)
    {
            $param = [];
            $param['dateForm'] = ($request->has('dateFrom')) ? date('Y-m-d', strtotime($request->get('dateFrom'))) : date('Y-m-d');
            $param['dateTo'] = ($request->has('dateTo')) ? date('Y-m-d', strtotime($request->get('dateTo'))) : date('Y-m-d');
            $param['type'] = ($request->has('type')) ? $request->get('type') : '999';
            $param['status'] = (int)($request->has('status')) ? $request->get('status') : 999;
            $param['phone'] = ($request->has('phone')) ? $request->get('phone') : '';

            $dataPhone = $this->phone->searchAndList($param['dateForm'], $param['dateTo'], $param['type'], $param['status'], $param['phone']);
           $data = [];
           $total['money_total']=0;
           $total['money_total_change']=0;
           foreach ($dataPhone as $item) {
               $aaRow = $item->toArray();
               $aaRow['phone_name']=Helper::formatPhoneNumber($item->phone);
               $aaRow['phone_type'] =config('constant.phone_type')[$item->type];
               $aaRow['status'] =config('constant.status')[$item->status];
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
}
