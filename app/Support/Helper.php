<?php
namespace App\Support;

class Helper
{


    public static  function loadFile($fileName)
    {
        config([
            'excel.import.startRow' => 7
        ]);
        $excel=\Excel::load($fileName, function($reader) {
            $reader->formatDates(false);
        });
        return $excel;
    }
}
?>