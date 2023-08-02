<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Helpers\Helper;
use App\Models\Document2021;
use Illuminate\Http\Request;
use App\Imports\Document2021Import;
use Maatwebsite\Excel\Facades\Excel;

class Document2021Controller extends Controller
{
    public function sewaIndex()
    {
        $title = 'Dokumen Sewa 2021';
        $documents = Document2021::with(['user_pkn', 'user_penilai'])->where('jenis_persetujuan', 'Sewa')->get();

        $documents = $documents->map(function ($document) {
            if ($document->jenis_persetujuan == 'Sewa') {
                $remainingMonths = $this->checkRemainingMonths($document->tanggal_surat_persetujuan_penolakan, $document->periode_sewa);

                $document->status_masa_aktif = $remainingMonths > 3 ? 'Aktif' : ($remainingMonths > 0 ? 'Tenggang' : 'Non-aktif');
            } else {
                $document->status_masa_aktif = '-';
            }
            $document->update(['status_masa_aktif' => $document->status_masa_aktif]);

            $document->formatted_tanggal_surat_masuk = $this->formatDate($document->tanggal_surat_masuk);
            $document->formatted_tanggal_surat_diterima = $this->formatDate($document->tanggal_surat_diterima);
            $document->formatted_tanggal_nd_permohonan_penilaian = $this->formatDate($document->tanggal_nd_permohonan_penilaian);
            $document->formatted_tanggal_ndr_diterima_penilaian = $this->formatDate($document->tanggal_ndr_diterima_penilaian);
            $document->formatted_tanggal_surat_persetujuan_penolakan = $this->formatDate($document->tanggal_surat_persetujuan_penolakan);

            return $document;
        });

        return view('dokumen.dokumen2021.sewa-index', compact('title', 'documents'));
    }

    public function penjualanIndex()
    {
        $title = 'Dokumen Penjualan 2021';
        $documents = Document2021::with(['user_pkn', 'user_penilai'])->where('jenis_persetujuan', 'Penjualan')->get();

        $documents = $documents->map(function ($document) {

            $document->formatted_tanggal_surat_masuk = $this->formatDate($document->tanggal_surat_masuk);
            $document->formatted_tanggal_surat_diterima = $this->formatDate($document->tanggal_surat_diterima);
            $document->formatted_tanggal_nd_permohonan_penilaian = $this->formatDate($document->tanggal_nd_permohonan_penilaian);
            $document->formatted_tanggal_ndr_diterima_penilaian = $this->formatDate($document->tanggal_ndr_diterima_penilaian);
            $document->formatted_tanggal_surat_persetujuan_penolakan = $this->formatDate($document->tanggal_surat_persetujuan_penolakan);

            return $document;
        });

        return view('dokumen.dokumen2021.penjualan-index', compact('title', 'documents'));
    }

    public function penghapusanIndex()
    {
        $title = 'Dokumen Penghapusan 2021';
        $documents = Document2021::with(['user_pkn', 'user_penilai'])->where('jenis_persetujuan', 'Penghapusan')->get();

        $documents = $documents->map(function ($document) {

            $document->formatted_tanggal_surat_masuk = $this->formatDate($document->tanggal_surat_masuk);
            $document->formatted_tanggal_surat_diterima = $this->formatDate($document->tanggal_surat_diterima);
            $document->formatted_tanggal_nd_permohonan_penilaian = $this->formatDate($document->tanggal_nd_permohonan_penilaian);
            $document->formatted_tanggal_ndr_diterima_penilaian = $this->formatDate($document->tanggal_ndr_diterima_penilaian);
            $document->formatted_tanggal_surat_persetujuan_penolakan = $this->formatDate($document->tanggal_surat_persetujuan_penolakan);

            return $document;
        });

        return view('dokumen.dokumen2021.penghapusan-index', compact('title', 'documents'));
    }

    private function formatDate($date)
    {
        if ($date === null) {
            return null;
        }

        $carbonDate = Carbon::parse($date);
        $formattedDate = $carbonDate->locale('id')->isoFormat('D MMM Y');

        return $formattedDate;
    }

    private function checkRemainingMonths($startDate, $period)
    {
        $start = Carbon::parse($startDate);
        $today = Carbon::now();

        $monthsPassed = $start->diffInMonths($today);

        $totalLeaseMonths = $period * 12;

        $remainingMonths = $totalLeaseMonths - $monthsPassed;

        return $remainingMonths;
    }

    public function create()
    {
        $this->authorize('admin-pkn-super-admin');
        $title = 'Tambah Dokumen 2021';
        $pkn_conceptors = User::where('role', 'Admin Pkn')->orderBy('name')->get();
        $penilai_conceptors = User::where('role', 'Admin Penilai')->orderBy('name')->get();
        return view('dokumen.dokumen2021.create', compact('title', 'pkn_conceptors', 'penilai_conceptors'));
    }

    public function store(Request $request)
    {
        $this->authorize('admin-pkn-super-admin');
        $data = $request->validate([
            'satker' => 'required',
            'nomor_whatsapp_satker' => 'required',
            'nomor_surat_masuk' => 'required',
            'tanggal_surat_masuk' => 'required',
            'tanggal_surat_diterima' => 'required',
            'jenis_persetujuan' => 'required',
            'user_id_pkn' => 'required',
            'user_id_penilai' => 'required',
            'nomor_nd_permohonan_penilaian' => 'nullable',
            'tanggal_nd_permohonan_penilaian' => 'nullable'
        ]);

        $totalDays = Helper::dayDifference($request->tanggal_surat_diterima, now()->toDateString());
        if ($request->jenis_persetujuan == 'Sewa') {
            $totalDays = min($totalDays, 2);
        } else {
            $totalDays = min($totalDays, 3);
        }
        if ($request->nomor_nd_permohonan_penilaian && $request->tanggal_nd_permohonan_penilaian) {
            $data['progress'] = json_encode([
                'masuk' => ['day' => $totalDays, 'isCompleted' => true, 'completion_date' => now()->toDateString()],
                'dinilai' => ['day' => 0, 'isCompleted' => false, 'completion_date' => null],
                'selesai' => ['day' => 0, 'isCompleted' => false, 'completion_date' => null],
            ]);
        }

        Document2021::create($data);
        $type = strtolower($request->jenis_persetujuan);
        $path = env('APP_URL') . "/dokumen/$type/2021";

        return redirect($path)->with('success', 'Dokumen berhasil ditambahkan');
    }

    public function edit($id)
    {
        $title = 'Edit Dokumen 2021';
        $document = Document2021::with(['user_pkn', 'user_penilai'])->findOrFail($id);
        $progress = json_decode($document->progress);
        $pkn_conceptors = User::where('role', 'Admin Pkn')->orderBy('name')->get();
        $penilai_conceptors = User::where('role', 'Admin Penilai')->orderBy('name')->get();
        return view('dokumen.dokumen2021.edit', compact('title', 'document', 'progress', 'pkn_conceptors', 'penilai_conceptors'));
    }

    public function update($id, Request $request)
    {
        $data = $request->validate([
            // Progress Masuk
            'satker' => 'nullable',
            'nomor_whatsapp_satker' => 'nullable',
            'nomor_surat_masuk' => 'nullable',
            'tanggal_surat_masuk' => 'nullable',
            'tanggal_surat_diterima' => 'nullable',
            'jenis_persetujuan' => 'nullable',
            'user_id_pkn' => 'nullable',
            'user_id_penilai' => 'nullable',
            'nomor_nd_permohonan_penilaian' => 'nullable',
            'tanggal_nd_permohonan_penilaian' => 'nullable',
            // Progress penilaian
            'nomor_ndr_penilaian' => 'nullable',
            'tanggal_ndr_diterima_penilaian' => 'nullable',
            // Progress penyelesaian
            'nomor_surat_persetujuan_penolakan' => 'nullable',
            'tanggal_surat_persetujuan_penolakan' => 'nullable',
            'nilai_proporsional_harga_perolehan_nilai_bmn' => 'nullable',
            'nilai_persetujuan' => 'nullable',
            'periode_sewa' => 'nullable'
        ]);

        $document = Document2021::with(['user_pkn', 'user_penilai'])->findOrFail($id);
        $progress = json_decode($document->progress);
        $today = now()->toDateString();

        $completed1 = $request->nomor_nd_permohonan_penilaian && $request->tanggal_nd_permohonan_penilaian;
        $completed2 = $request->nomor_ndr_penilaian && $request->tanggal_ndr_diterima_penilaian;
        $completed3 = $request->nomor_surat_persetujuan_penolakan &&
            $request->tanggal_surat_persetujuan_penolakan && $request->nilai_proporsional_harga_perolehan_nilai_bmn;

        if ($completed1) {
            if ($progress->masuk->completion_date == null) {
                $progress->masuk->completion_date = $today;
            }
            $progress->masuk->isCompleted = true;
        } else {
            $progress->masuk->completion_date = null;
            $progress->masuk->isCompleted = false;
        }

        if ($completed2) {
            if ($progress->dinilai->completion_date == null) {
                $progress->dinilai->completion_date = $today;
            }
            $progress->dinilai->isCompleted = true;
        } else {
            $progress->dinilai->completion_date = null;
            $progress->dinilai->isCompleted = false;
        }

        if ($completed3) {
            if ($progress->selesai->completion_date == null) {
                $progress->selesai->completion_date = $today;
            }
            $progress->selesai->isCompleted = true;
        } else {
            $progress->selesai->completion_date = null;
            $progress->selesai->isCompleted = false;
        }

        $data['progress'] = json_encode($progress);

        $document->update($data);
        $type = strtolower($request->jenis_persetujuan);
        $path = env('APP_URL') . "/dokumen/$type/2021";

        return redirect($path)->with('success', 'Dokumen berhasil diedit');
    }

    public function delete($id)
    {
        $document = Document2021::with(['user_pkn', 'user_penilai'])->findorFail($id);

        $document->delete();

        return back()->with('success', "Dokumen berhasil dihapus");
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $file->move('Document2021', $fileName);

        Excel::import(new Document2021Import, public_path('Document2021/' . $fileName));
        return back()->with('success', "Dokumen berhasil diimport");
    }
}
