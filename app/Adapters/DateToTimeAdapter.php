<?php


namespace App\Adapters;


use Illuminate\Support\Carbon;

class DateToTimeAdapter
{

    public static function toDate(string $time) : string
    {
        return Carbon::createFromTimestamp($time)->toDateString();
    }

    public static function toTime(string $date) : int
    {
        return Carbon::createFromFormat('Y-m-d', $date)->timestamp;
    }

}
