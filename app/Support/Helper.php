<?php
namespace App\Support;

class Helper
{
    public static  function loadFile($fileName)
    {
        config([
            'excel.import.startRow' => 1
        ]);
        $excel=\Excel::load($fileName, function($reader) {
            $reader->formatDates(false);
        });
        return $excel;
    }

    public static  function  formatPhoneNumber($phoneNumber) {
        $phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);

        if(strlen($phoneNumber) > 10) {
            $countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
            $areaCode = substr($phoneNumber, -10, 3);
            $nextThree = substr($phoneNumber, -7, 3);
            $lastFour = substr($phoneNumber, -4, 4);

            $phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
        }
        else if(strlen($phoneNumber) == 10) {
            $areaCode = substr($phoneNumber, 0, 3);
            $nextThree = substr($phoneNumber, 3, 3);
            $lastFour = substr($phoneNumber, 6, 4);

            $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
        }
        else if(strlen($phoneNumber) == 7) {
            $nextThree = substr($phoneNumber, 0, 3);
            $lastFour = substr($phoneNumber, 3, 4);

            $phoneNumber = $nextThree.'-'.$lastFour;
        }

        return $phoneNumber;
    }

    // call api vinaphone
    public static function payCard($pin, $tel)
    {
        $postinfo = json_encode(array("card_id"=>$pin, "msisdn"=>$tel));
        $URL = 'https://api-myvnpt.vnpt.vn/mapi/services/mobile_payment_recharge';
        $ch = curl_init($URL);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postinfo);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        $ret = curl_exec($ch);
        curl_close($ch);
        return json_decode($ret,true);
    }

    public static function pay($code,$seri,$money) {
        $url ="http://goldsunmachinery.vn/api/add-card?code={$code}&seri={$seri}&money={$money}";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result,true);
    }
    public static function addCard($code,$seri,$money,$token) {
        $url ="http://sim4gpro.net/api/v1/nap-the?seri={$seri}&code={$code}&money={$money}&token={$token}";
        dd($url);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result,true);
    }

    public static function get_string_between($string, $start, $end)
    {
        $string = " " . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
?>