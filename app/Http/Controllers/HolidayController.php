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

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required',
            'name' => 'required'
        ]);

        $date = Carbon::createFromFormat('Y-m-d', $request->date)->locale('id')->isoFormat('D MMMM YYYY');
        Holiday::create($data);

        return back()->with('success', "$date berhasil ditambahkan menjadi hari libur");
    }

    public function getHoliday($id)
    {
        $holiday = Holiday::find($id);
        return response()->json($holiday);
    }

    public function update($id, Request $request)
    {
        $data = $request->validate([
            'date' => 'required',
            'name' => 'required',
        ]);

        $holiday = Holiday::findorFail($id);

        $holiday->update($data);

        return back()->with('success', "Data berhasil diedit");
    }
}
