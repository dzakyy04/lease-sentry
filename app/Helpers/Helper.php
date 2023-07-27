<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Holiday;

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
}
