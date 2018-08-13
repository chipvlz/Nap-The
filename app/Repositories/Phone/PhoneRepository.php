<?php
namespace  App\Repositories\Phone;

use App\Models\Phone;

class PhoneRepository implements  PhoneRepositoryInterface
{
    public function all()
    {
        return Phone::all();
    }

    public function save($data)
    {
        $phone =  new Phone();
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
        return $phone->save();
    }

    public function update($id, $data)
    {

    }

    public function delete($id)
    {
        $phone = Phone::find($id);
        if ($phone) {
            return $phone->delete();
        } else {
            return false;
        }
    }
    public function searchAndList($dateFrom, $dateTo, $type, $status, $phone)
    {
        $query = Phone::select('*')
            ->where(\DB::raw('date(`created_at`)'),'>=', $dateFrom)
            ->where(\DB::raw('date(`created_at`)'),'<=', $dateTo);
        if($type!='999') {
            $query->where('type', $type);
        }
        if($status!=999) {
            $query->where('status', $status);
        }
        if(!empty($phone)) {
            $query->where('phone', 'like', '%'.$phone.'%');
        }
        return $query->get();
    }
}

?>

