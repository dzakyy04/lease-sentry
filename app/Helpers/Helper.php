<?php

namespace App\Helpers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Holiday;
use GuzzleHttp\Psr7\Request;

class Helper
{
    public static function isHoliday($date)
    {
        $holiday = Holiday::where('date', $date)->first();
        return $holiday ? true : false;
    }

    public static function isWorkingDay($date)
    {
        $carbonDate = Carbon::parse($date);
        return $carbonDate->isWeekend() || self::isHoliday($date) ? false : true;
    }

    public static function dayDifference($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        $difference = $start->diffInDaysFiltered(
            function (Carbon $date) {
                return !$date->isWeekend() && !Helper::isHoliday($date);
            },
            $end
        );
        return $difference;
    }

    public static function sendWhatsapp($number, $message)
    {
        $client = new Client();
        $options = [
            'json' => [
                'device_id' => env('DEVICE_ID'),
                'number' => $number,
                'message' => $message
            ]
        ];
        $request = new Request('POST', 'https://app.whacenter.com/api/send');
        $res = $client->sendAsync($request, $options)->wait();
        return $res->getBody()->getContents();
    }
}
