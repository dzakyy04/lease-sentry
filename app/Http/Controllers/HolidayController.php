<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function index()
    {
        $title = 'Hari libur';
        $holidays = Holiday::orderBy('date', 'asc')->get();

        $holidays->map(function ($item) {
            $formattedDate = Carbon::createFromFormat('Y-m-d', $item->date)->locale('id')->isoFormat('D MMMM YYYY');
            $item->formatted_date = $formattedDate;
            return $item;
        });

        return view('hari-libur.index', compact('title', 'holidays'));
    }
}
