<?php
namespace  App\Repositories\PayCard;

use App\Models\PayCard;

class PayCardRepository implements  PayCardRepositoryInterface
{
    public function all()
    {
        return PayCard::all();
    }

    public function save($data)
    {
        $payCard = new PayCard();

        if (isset($data['card_seri'])) {
            $payCard->card_seri = $data['card_seri'];
        }
        if (isset($data['card_code'])) {
            $payCard->card_code = $data['card_code'];
        }
        if (isset($data['money_request'])) {
            $payCard->money_request = $data['money_request'];
        }
        if (isset($data['money_response'])) {
            $payCard->money_response = $data['money_response'];
        }
        if (isset($data['phone'])) {
            $payCard->phone = $data['phone'];
        }
        if (isset($data['provider'])) {
            $payCard->provider = $data['provider'];
        }
        if (isset($data['status'])) {
            $payCard->status = $data['status'];
        }
        return $payCard->save();

    }

    public function update($id, $data)
    {

    }

    public function delete($id)
    {

    }

    public function findAttribute($att, $val)
    {
        return PayCard::where($att, $val)->get();
    }

    public function searchAndList($dateFrom, $dateTo,$status, $phone, $code, $provider, $start, $length,$column, $sort)
    {
        $query = PayCard::select('*')
            ->where(\DB::raw('date(`created_at`)'),'>=', $dateFrom)
            ->where(\DB::raw('date(`created_at`)'),'<=', $dateTo);
        if($status!=999) {
            $query->where('status', $status);
        }
        if($provider!=999) {
            $query->where('provider', $provider);
        }
        if(!empty($phone)) {
            $query->where('phone', 'like', '%'.$phone.'%');
        }
        if(!empty($code)) {
            $query->where('card_code', 'like', '%'.$code.'%');
        }
        return [
            'count_record' => $query->count(),
            'total_money_request'=>$query->sum('money_request'),
            'total_money_response'=>$query->sum('money_response'),
            'record' => $query->take(1000)->orderBy($column, $sort)->skip($start)->take($length)->get()
        ];
    }

    public function  countPayCardInDateNow($date)
    {
        return PayCard::select(\DB::raw('count(id) as count_order, sum(if(status=0,1,0)) as log_false,sum(if(status=1,1,0)) as log_true'))
                        ->where(\DB::raw('date(`created_at`)'),$date)
                        ->first();
    }
}