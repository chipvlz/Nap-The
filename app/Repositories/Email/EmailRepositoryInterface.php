<?php
namespace  App\Repositories\Email;

interface  EmailRepositoryInterface
{
    public  function  sendEmail($email, $data, $view, $title);
}
?>