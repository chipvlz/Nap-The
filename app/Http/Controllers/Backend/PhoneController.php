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
            $param['dateForm'] = ($request->has('dateFrom')) ? $request->get('dateFrom') : date('Y-m-d');
            $param['dateTo'] = ($request->has('dateTo')) ? $request->get('dateTo') : date('Y-m-d');
            $param['dateForm'] = ($request->has('dateFrom')) ? $request->get('dateFrom') : date('Y-m-d');
            $param['type'] = ($request->has('type')) ? $request->get('type') : '999';
            $param['status'] = (int)($request->has('status')) ? $request->get('status') : 999;
            $param['phone'] = ($request->has('phone')) ? $request->get('phone') : '';
            dd($param);
    }
}
