<?php
namespace  App\Repositories\PayCard;

interface  PayCardRepositoryInterface
{
    public function all();

    public function save($data);

    public function update($id, $data);

    public function delete($id);

    public function findAttribute($att, $val);

    public function searchAndList($dateFrom, $dateTo,$status, $phone, $start, $length, $column, $sort);
}


?>