<?php

namespace App\Http\Controllers\Backend;

use App\Models\PayCard;
use App\Models\Phone;
use App\Repositories\PayCard\PayCardRepositoryInterface;
use App\Repositories\Phone\PhoneRepositoryInterface;
use App\Support\Helper;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PhoneController extends Controller
{
    public  function  __construct(PhoneRepositoryInterface $phone, PayCardRepositoryInterface $payCard)
    {
        $this->phone = $phone;
        $this->payCard = $payCard;
    }

    public function  index()
    {
        return view('backend.page.phone.add');
    }

    public function processUploadFile(Request $request)
    {
        try{
        $dir = 'uploads/phone';
        if ($request->hasFile('file')) {
            $file = $request->file;
            $file->move($dir, $file->getClientOriginalName());
            $pathFile = $dir.'/'.$file->getClientOriginalName();
            $dataReadFile = Helper::loadFile($pathFile)->toArray();
          foreach ($dataReadFile as $row) {
                 $data = [
                    'phone' => $row['so_dien_thoai'],
                     'money' => (int)$row['so_tien_can_nap'],
                     'status' => 0,
                     'created_user' => \Auth::user()->name
                 ];
                 $this->phone->save($data);

          }
            unlink($pathFile);
            return redirect()->route('phone.index')->with('success', 'upload số điện thoại thành công!');
        }
            }catch (\Exception $ex) {
        return redirect()->back()->withErrors('Lỗi nhập danh sách sim');
        }
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
                    $this->phone->save($data);
                }
                return redirect()->route('phone.index')->with('success', 'Thêm mới thành công!');
            } else {
                return redirect()->back()->withErrors('Vui lòng nhập danh sách số điện thoại!');
            }
        }catch (\Exception $ex) {
            return redirect()->back()->withErrors('Lỗi nhập danh sách sim');
        }


    }

    public function listPhone()
    {
        return view('backend.page.phone.index');
    }

    public function processListPhone(Request $request)
    {
            $param = [];
            $param['status'] = (int)($request->has('status')) ? $request->get('status') : 999;
            $param['phone'] = ($request->has('phone')) ? $request->get('phone') : '';

            $dataPhone = $this->phone->searchAndList($param['status'], $param['phone']);
           $data = [];
           $total['money_total']=0;
           $total['money_total_change']=0;
           foreach ($dataPhone as $item) {
               $aaRow = $item->toArray();
               $aaRow['phone_name']=Helper::formatPhoneNumber($item->phone);
               $aaRow['status'] =config('constant.status')[$item->status];
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

    public function simSuccess(Request $request)
    {
        $param = [];
        $param['dateForm'] = ($request->has('start_date')) ? date('Y-m-d', strtotime($request->get('start_date'))) : date('Y-m-d');
        $param['dateTo'] = ($request->has('end_date')) ? date('Y-m-d', strtotime($request->get('end_date'))) : date('Y-m-d');
        $dataPhone = Phone::where(\DB::raw('date(`created_at`)'),'>=', $param['dateForm'])
            ->where(\DB::raw('date(`created_at`)'),'<=', $param['dateTo'])
            ->where('status', 2)
            ->get();
        $total['money_total']=0;
        $total['money_total_change']=0;
        foreach ($dataPhone as $item) {
            $total['money_total'] +=(int)$item->money ;
            $total['money_total_change'] +=(int)$item->money_change ;
        }
        return view('backend.page.phone.sim_success', compact('dataPhone', 'total', 'param'));
    }
    public function simDelete()
    {
        $dataPhone = Phone::where('status',4)->get();
        $total['money_total']=0;
        $total['money_total_change']=0;
        foreach ($dataPhone as $item) {
            $total['money_total'] +=(int)$item->money ;
            $total['money_total_change'] +=(int)$item->money_change ;
        }
        return view('backend.page.phone.sim_delete', compact('dataPhone', 'total'));
    }
    public function simReject()
    {
        $dataPhone = Phone::where('status',-1)->get();
        return view('backend.page.phone.sim_reject', compact('dataPhone'));
    }

    public function  rejectSim(Request $request)
    {
        $id = $request->get('id',0);
        $param['status']=-1;
        $response = [];
        if ($this->phone->update($id, $param)) {
            $response['status']=1;
            $response['message']='Dừng nạp  thành công!';
        } else {
            $response['status']=0;
            $response['message']='Lỗi xử lý !';
        }
        return response()->json($response);
    }
    public function  openSim(Request $request)
    {
        $id = $request->get('id',0);
        $phoneFind = $this->phone->find($id);
        $money = (int)$phoneFind->money - (int)$phoneFind->money_change;
        if ($money==0) {
            $param['status']=2;
        } else if ($money==(int)$phoneFind->money) {
            $param['status']=0;
        } else if ($money>0) {
            $param['status']=1;
        }
        $response = [];
        if ($this->phone->update($id, $param)) {
            $response['status']=1;
            $response['message']='Mở nạp thành công!';
        } else {
            $response['status']=0;
            $response['message']='Lỗi xử lý !';
        }
        return response()->json($response);
    }

    public function  logOrder($phone)
    {
        $dataLog = $this->payCard->findAttribute('phone', $phone);
        return view('backend.page.phone.log', compact('phone','dataLog'));
    }

    public function  rejectSimMore(Request $request)
    {
        $response = [];
        $paramId = $request->get('param');
        if (!empty($paramId)) {
            $arrId = explode(',', $paramId);
            foreach ($arrId as $item) {
                $param['status'] = -1;
                if ($this->phone->update((int)$item, $param)) {
                    $response['status'] = 1;
                    $response['message'] = 'Dừng nạp  thành công!';
                } else {
                    $response['status'] = 0;
                    $response['message'] = 'Lỗi xử lý !';
                }
            }
        }
        return response()->json($response);
    }
    public function  openSimMore(Request $request)
    {
        $response = [];
        $paramId = $request->get('param');
        if (!empty($paramId)) {
            $arrId = explode(',', $paramId);
            foreach ($arrId as $item) {
                $phoneFind = $this->phone->find((int)$item);
                $money = (int)$phoneFind->money - (int)$phoneFind->money_change;
                if ($money==0) {
                    $param['status']=2;
                } else if ($money==(int)$phoneFind->money) {
                    $param['status']=0;
                } else if ($money>0) {
                    $param['status']=1;
                }
                $response = [];
                if ($this->phone->update((int)$item, $param)) {
                    $response['status']=1;
                    $response['message']='Mở nạp thành công!';
                } else {
                    $response['status']=0;
                    $response['message']='Lỗi xử lý !';
                }
            }
        }
        return response()->json($response);
    }

    public function  deleteSimMore(Request $request)
    {
        $response = [];
        $paramId = $request->get('param');
        if (!empty($paramId)) {
            $arrId = explode(',', $paramId);
            foreach ($arrId as $item) {
                $phoneFind = $this->phone->find((int)$item);
                $phoneFind->status = 4;
                $phoneFind->save();
            }
        }
        return response()->json($response);
    }

    //
    public function  successSimMore(Request $request)
    {
        $response = [];
        $paramId = $request->get('param');
        if (!empty($paramId)) {
            $arrId = explode(',', $paramId);
            foreach ($arrId as $item) {
                $phoneFind = $this->phone->find((int)$item);
                $phoneFind->status = 2 ;
                $phoneFind->save();
            }
        }
        return response()->json($response);
    }

    public function openUtSimMore(Request $request)
    {
        $response = [];
        $paramId = $request->get('param');
        if (!empty($paramId)) {
            $arrId = explode(',', $paramId);
            foreach ($arrId as $item) {
                $phoneFind = $this->phone->find((int)$item);
                $phoneFind->status = 3 ;
                $phoneFind->save();
            }
        }
        return response()->json($response);
    }

    public  function rejectUtSimMore(Request $request)
    {
        $response = [];
        $paramId = $request->get('param');
        if (!empty($paramId)) {
            $arrId = explode(',', $paramId);
            foreach ($arrId as $item) {
                $phoneFind = $this->phone->find((int)$item);
                $money = (int)$phoneFind->money - (int)$phoneFind->money_change;
                if ($money==0) {
                    $param['status']=2;
                } else if ($money==(int)$phoneFind->money) {
                    $param['status']=0;
                } else if ($money>0) {
                    $param['status']=1;
                }
                $response = [];
                if ($this->phone->update((int)$item, $param)) {
                    $response['status']=1;
                    $response['message']='Mở nạp thành công!';
                } else {
                    $response['status']=0;
                    $response['message']='Lỗi xử lý !';
                }
            }
        }
        return response()->json($response);
    }
}
