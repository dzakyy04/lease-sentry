<?php

namespace App\Http\Controllers;

use App\Models\Document2020;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $documents = Document2020::count();
        $penjualan = Document2020::where('jenis_persetujuan', 'Penjualan')->count();
        $penghapusan = Document2020::where('jenis_persetujuan', 'Penghapusan')->count();
        $sewa = Document2020::where('jenis_persetujuan', 'Sewa')->count();
        return view('dashboard.index', compact('title', 'documents', 'penjualan', 'penghapusan', 'sewa'));
    }
}
