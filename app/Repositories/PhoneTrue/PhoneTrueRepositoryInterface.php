<?php
 namespace  App\Repositories\PhoneTrue;

 interface  PhoneTrueRepositoryInterface
 {
     public function all();

     public function save($data);

     public function update($id, $data);

     public function delete($id);

     public function  find($id);

     public function searchAndList($status, $phone);

     public function  getPhoneForMoney($money);

     public  function  countPhoneNow();

     public function getPhoneMoneyTrue($money);
     public function getPhoneMoneyMap($money);
 }
?>