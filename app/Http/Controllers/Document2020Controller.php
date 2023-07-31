<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Carbon\Carbon;
use App\Models\Conceptor;
use App\Models\Document2020;
use Illuminate\Http\Request;
use App\Imports\Document2020Import;
use Maatwebsite\Excel\Facades\Excel;

class Document2020Controller extends Controller
{
    public function index()
    {
        $title = 'Dokumen 2020';
        $documents = Document2020::with('conceptor')->get();

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

        return view('dokumen.dokumen2020.index', compact('title', 'documents'));
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
        $title = 'Tambah Dokumen 2020';
        $conceptors = Conceptor::get();
        return view('dokumen.dokumen2020.create', compact('title', 'conceptors'));
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
            'conceptor_id' => 'required',
            'nomor_nd_permohonan_penilaian' => 'nullable',
            'tanggal_nd_permohonan_penilaian' => 'nullable'
        ]);

        $totalDays = Helper::dayDifference($request->tanggal_surat_diterima, now()->toDateString());

        if ($request->nomor_nd_permohonan_penilaian && $request->tanggal_nd_permohonan_penilaian) {
            $data['progress'] = json_encode([
                'masuk' => ['day' => $totalDays, 'isCompleted' => true, 'completion_date' => now()->toDateString()],
                'dinilai' => ['day' => 0, 'isCompleted' => false, 'completion_date' => null],
                'selesai' => ['day' => 0, 'isCompleted' => false, 'completion_date' => null],
            ]);
        }

        Document2020::create($data);

        return redirect()->route('document2020.index')->with('success', 'Dokumen berhasil ditambahkan');
    }

    public function edit($id)
    {
        $title = 'Edit Dokumen 2020';
        $document = Document2020::with('conceptor')->findOrFail($id);
        $progress = json_decode($document->progress);
        $conceptors = Conceptor::get();
        return view('dokumen.dokumen2020.edit', compact('title', 'document', 'progress', 'conceptors'));
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
            'conceptor_id' => 'nullable',
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

        $document = Document2020::with('conceptor')->findOrFail($id);
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
        }

        if ($completed2) {
            if ($progress->dinilai->completion_date == null) {
                $progress->dinilai->completion_date = $today;
            }
            $progress->dinilai->isCompleted = true;
        }

        if ($completed3) {
            if ($progress->selesai->completion_date == null) {
                $progress->selesai->completion_date = $today;
            }
            $progress->selesai->isCompleted = true;
        }

        $data['progress'] = json_encode($progress);

        $document->update($data);

        return redirect()->route('document2020.index')->with('success', 'Dokumen berhasil diedit');
    }

    public function delete($id)
    {
        $document = Document2020::with('conceptor')->findorFail($id);

        $document->delete();

        return back()->with('success', "Dokumen berhasil dihapus");
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $file->move('Document2020', $fileName);

        Excel::import(new Document2020Import, public_path('Document2020/' . $fileName));
        return redirect()->route('document2020.index')->with('success', "Dokumen berhasil diimport");
    }
}
