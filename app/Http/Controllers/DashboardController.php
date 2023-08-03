<?php

namespace App\Http\Controllers;

use App\Models\Document2020;
use App\Models\Document2021;
use App\Models\Document2022;
use App\Models\Document2023;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $document2020s = Document2020::count();
        $penjualan2020s = Document2020::where('jenis_persetujuan', 'Penjualan')->count();
        $penghapusan2020s = Document2020::where('jenis_persetujuan', 'Penghapusan')->count();
        $sewa2020s = Document2020::where('jenis_persetujuan', 'Sewa')->count();

        $document2021s = Document2021::count();
        $penjualan2021s = Document2021::where('jenis_persetujuan', 'Penjualan')->count();
        $penghapusan2021s = Document2021::where('jenis_persetujuan', 'Penghapusan')->count();
        $sewa2021s = Document2021::where('jenis_persetujuan', 'Sewa')->count();

        $document2022s = Document2022::count();
        $penjualan2022s = Document2022::where('jenis_persetujuan', 'Penjualan')->count();
        $penghapusan2022s = Document2022::where('jenis_persetujuan', 'Penghapusan')->count();
        $sewa2022s = Document2022::where('jenis_persetujuan', 'Sewa')->count();

        $document2023s = Document2023::count();
        $penjualan2023s = Document2023::where('jenis_persetujuan', 'Penjualan')->count();
        $penghapusan2023s = Document2023::where('jenis_persetujuan', 'Penghapusan')->count();
        $sewa2023s = Document2023::where('jenis_persetujuan', 'Sewa')->count();
        
        return view('dashboard.index', compact('title', 'document2020s', 'penjualan2020s', 'penghapusan2020s', 'sewa2020s'
        , 'document2021s', 'penjualan2021s', 'penghapusan2021s', 'sewa2021s', 'document2022s', 'penjualan2022s', 'penghapusan2022s', 'sewa2022s', 'document2023s', 'penjualan2023s', 'penghapusan2023s', 'sewa2023s'));
    }
}
