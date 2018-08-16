<?php
namespace  App\Repositories\ApiToken;

interface  ApiTokenRepositoryInterface
{
    public function all();

    public function save($data);

    public function update($id, $data);

    public function delete($id);

    public function  findAttribute($att, $val);
}


?>