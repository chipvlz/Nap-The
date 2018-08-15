<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\PayCard\PayCardRepositoryInterface;
use App\Repositories\Phone\PhoneRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct(PayCardRepositoryInterface $payCard,
                                PhoneRepositoryInterface $phone,
                                UserRepositoryInterface $user
                                )
    {
        $this->payCard = $payCard;
        $this->phone = $phone;
        $this->user = $user;
    }

    //
    public function  index()
    {
        $dataLogPayCard = $this->payCard->countPayCardInDateNow(date('Y-m-d'));
        $dataPhone = $this->phone->countPhoneNow();
        $dataUser = $this->user->countUser();
        return view('backend.page.report.index', compact('dataLogPayCard', 'dataPhone', 'dataUser'));
    }
}
