<?php
 namespace  App\Repositories\Phone;

 interface  PhoneRepositoryInterface
 {
     public function all();

     public function save($data);

     public function update($id, $data);

     public function delete($id);
 }
?>