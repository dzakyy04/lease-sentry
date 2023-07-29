<?php

namespace App\Http\Controllers;

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

        $documents = $documents->map(function ($item) {
            $suratMasukDate = Carbon::createFromFormat('Y-m-d', $item->tanggal_surat_masuk)->locale('id')->isoFormat('D MMMM YYYY');
            $suratDiterimaDate = Carbon::createFromFormat('Y-m-d', $item->tanggal_surat_diterima)->locale('id')->isoFormat('D MMMM YYYY');

            $item->surat_masuk_date_formatted = $suratMasukDate;
            $item->surat_diterima_date_formatted = $suratDiterimaDate;

            return $item;
        });

        return view('dokumen.dokumen2020.index', compact('title', 'documents'));
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

        if ($request->nomor_nd_permohonan_penilaian && $request->tanggal_nd_permohonan_penilaian) {
            $data['progress'] = json_encode([
                'masuk' => ['day' => 1, 'isCompleted' => true],
                'dinilai' => ['day' => 0, 'isCompleted' => false],
                'selesai' => ['day' => 0, 'isCompleted' => false],
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
        $progress = json_decode($document->progress, true);

        $completed1 = $request->nomor_nd_permohonan_penilaian && $request->tanggal_nd_permohonan_penilaian;
        $completed2 = $request->nomor_ndr_penilaian && $request->tanggal_ndr_diterima_penilaian;
        $completed3 = $request->nomor_surat_persetujuan_penolakan &&
            $request->tanggal_surat_persetujuan_penolakan && $request->nilai_proporsional_harga_perolehan_nilai_bmn &&
            $request->nilai_persetujuan;

        if ($completed1) {
            $progress['masuk']['isCompleted'] = true;
        }

        if ($completed2) {
            $progress['dinilai']['isCompleted'] = true;
        }

        if ($completed3) {
            $progress['selesai']['isCompleted'] = true;
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