<?php
namespace  App\Repositories\Email;
use Illuminate\Support\Facades\Mail;

class  EmailRepository implements EmailRepositoryInterface
{
    public  function  sendEmail($email, $data, $view, $title)
    {
        Mail::send($view,
            compact('data'), function($m) use ($email,$title) {
                $m->to($email)->subject($title);
        });
    }
}