<?php

namespace App\Helpers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Holiday;
use GuzzleHttp\Psr7\Request;

class Helper
{
    public static function isWorkingDay($date)
    {
        $carbonDate = Carbon::parse($date);
        $holiday = Holiday::where('date', $date)->first();

        return $carbonDate->isWeekend() || $holiday ? false : true;
    }

    public static function dayDifference($startDate, $endDate)
    {
        $start = strtotime($startDate);
        $end = strtotime($endDate);

        $holidays = self::loadHolidays();

        $difference = 0;
        while ($start < $end) {
            $startWeekday = date('N', $start);
            $formattedDate = date('Y-m-d', $start);

            if ($startWeekday <= 5 && !isset($holidays[$formattedDate])) {
                $difference++;
            }
            $start = strtotime('+1 day', $start);
        }
        return $difference;
    }

    public static function loadHolidays()
    {
        $holidays = Holiday::all();
        $formattedHolidays = [];
        foreach ($holidays as $holiday) {
            $formattedHolidays[$holiday->date] = true;
        }
        return $formattedHolidays;
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
