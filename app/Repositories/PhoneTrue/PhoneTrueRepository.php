<?php
namespace  App\Repositories\PhoneTrue;

use App\Models\PhoneTrue;

class PhoneTrueRepository implements  PhoneTrueRepositoryInterface
{
    public function all()
    {
        return PhoneTrue::all();
    }

    public function save($data)
    {
        $phone =  new PhoneTrue();
        if (isset($data['phone'])) {
            $phone->phone=$data['phone'];
        }
        if (isset($data['type'])) {
            $phone->type=$data['type'];
        }
        if (isset($data['money'])) {
            $phone->money=$data['money'];
        }
        if (isset($data['created_user'])) {
            $phone->created_user=$data['created_user'];
        }
        if (isset($data['status'])) {
            $phone->status=$data['status'];
        }
         $phone->save();
    }

    public function update($id, $data)
    {
        $phone = PhoneTrue::find($id);
        if ($phone) {
            if (isset($data['phone'])) {
                $phone->phone = $data['phone'];
            }
            if (isset($data['money_change'])) {
                $phone->money_change = $data['money_change'];
            }
            if (isset($data['status'])) {
                $phone->status = $data['status'];
            }
            return $phone->save();
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $phone = PhoneTrue::find($id);
        if ($phone) {
            return $phone->delete();
        } else {
            return false;
        }
    }
    public function  find($id)
    {
       return PhoneTrue::find($id);
    }
    public function searchAndList( $status, $phone)
    {
        $query = PhoneTrue::select('*');
        if($status!=999) {
            $query->where('status', $status);
        }
        if(!empty($phone)) {
            $query->where('phone', 'like', '%'.$phone.'%');
        }
        return $query->orderBy('id', 'DESC')->get();
    }

    public function  getPhoneForMoney($money)
    {
        $phoneUT = PhoneTrue::select('id','phone', 'money', 'money_change', 'status')
            ->where(\DB::raw('money-money_change'), '>=', $money)
            ->whereIn('status', [3])
            ->orderBy(\DB::raw('RAND()'))
            ->first();
           if ($phoneUT) {
               return $phoneUT;
           }else {
               $phone = Phone::select('id','phone', 'money', 'money_change', 'status')
                   ->where(\DB::raw('money-money_change'), '>=', $money)
                   ->whereIn('status', [0, 1])
                   ->orderBy(\DB::raw('RAND()'))
                   ->first();
               return $phone;
           }
    }

    public  function  countPhoneNow()
    {
        return PhoneTrue::select(\DB::raw('count(id) as count_phone, sum(if(status=0,1,0)) as phone_new,
                sum(if(status=1,1,0)) as phone_start, sum(if(status=2,1,0)) as phone_success,sum(if(status=-1,1,0)) as phone_stop'))
            ->first();
    }

    public function getPhoneMoneyTrue($money)
    {
        $phone = PhoneTrue::select('id','phone', 'money', 'money_change', 'status')
                ->where('money_change',0)
                ->where('money', $money)
                ->where('status',1)
                ->orderBy(\DB::raw('RAND()'))
                ->first();
        return $phone;

    }
    public function getPhoneMoneyMap($money)
    {
        $phone = PhoneTrue::select('id','phone', 'money', 'money_change', 'status')
            ->where(\DB::raw('money-money_change'), '>=', $money)
            ->where('status',2)
            ->orderBy(\DB::raw('RAND()'))
            ->first();
        return $phone;
    }
}

?>

