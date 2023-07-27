<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Document2020;
use Illuminate\Http\Request;

class Document2020Controller extends Controller
{
    public function index()
    {
        $title = 'Dokumen 2020';
        $documents = Document2020::with('conceptor')->get();

        $documents = $documents->map(function ($item) {
            $suratMasukDate = Carbon::createFromFormat('Y-m-d', $item->tanggal_surat_masuk)->locale('id')->isoFormat('D MMMM YYYY');
            $suratDiterimaDate = Carbon::createFromFormat('Y-m-d', $item->tanggal_surat_diterima)->locale('id')->isoFormat('D MMMM YYYY');
        
            $item->surat_masuk_date_formatted = $suratMasukDate;
            $item->surat_diterima_date_formatted = $suratDiterimaDate;
        
            return $item;
        });
        
        return view('dokumen.dokumen2020.index', compact('title', 'documents'));
    }
}
