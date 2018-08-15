<?php
namespace  App\Repositories\User;

interface  UserRepositoryInterface
{
    public function all();

    public function save($data);

    public function update($id, $data);

    public function delete($id);

    public function countUser();

    public  function  findAbtribute($att, $val);
}
?>