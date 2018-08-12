<?php
namespace  App\Repositories\Phone;

use App\Modes\Phone;

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
}

?>

