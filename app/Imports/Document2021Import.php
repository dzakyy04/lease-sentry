<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Document2021;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class Document2021Import implements ToModel, WithHeadingRow, WithMapping
{
    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }

    public function map($row): array
    {
        $dateColumns = ['tanggal_surat_masuk', 'tanggal_surat_diterima', 'tanggal_nd_permohonan_penilaian', 'tanggal_ndr_diterima_penilaian', 'tanggal_surat_persetujuan_penolakan'];
        foreach ($row as $column => $value) {
            if (in_array($column, $dateColumns) && isset($value) && is_int($value)) {
                $dateValue = Date::excelToDateTimeObject($value);
                $row[$column] = $dateValue->format('Y-m-d');
            }
        }
        return $row;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Document2021([
            'satker' => $row['satker'],
            'nomor_whatsapp_satker' => $row['nomor_whatsapp_satker'],
            'nomor_surat_masuk' => $row['nomor_surat_masuk'],
            'tanggal_surat_masuk' => $row['tanggal_surat_masuk'],
            'tanggal_surat_diterima' => $row['tanggal_surat_diterima'],
            'jenis_persetujuan' => $row['jenis_persetujuan'],
            'conceptor_id' => $row['conceptor_id'],
            'nomor_nd_permohonan_penilaian' => $row['nomor_nd_permohonan_penilaian'],
            'tanggal_nd_permohonan_penilaian' => $row['tanggal_nd_permohonan_penilaian'],
            'nomor_ndr_penilaian' => $row['nomor_ndr_penilaian'],
            'tanggal_ndr_diterima_penilaian' => $row['tanggal_ndr_diterima_penilaian'],
            'nomor_surat_persetujuan_penolakan' => $row['nomor_surat_persetujuan_penolakan'],
            'tanggal_surat_persetujuan_penolakan' => $row['tanggal_surat_persetujuan_penolakan'],
            'nilai_proporsional_harga_perolehan_nilai_bmn' => $row['nilai_proporsional_harga_perolehan_nilai_bmn'],
            'nilai_persetujuan' => $row['nilai_persetujuan'],
            'periode_sewa' => $row['periode_sewa'],
            'progress' => $row['jenis_persetujuan'] == 'Sewa' ? '{"masuk":{"day":2,"isCompleted":true,"completion_date":"null"},"dinilai":{"day":15,"isCompleted":true,"completion_date":null},"selesai":{"day":2,"isCompleted":true,"completion_date":"null"}}' : '{"masuk":{"day":3,"isCompleted":true,"completion_date":"null"},"dinilai":{"day":15,"isCompleted":true,"completion_date":null},"selesai":{"day":4,"isCompleted":true,"completion_date":"null"}}'
        ]);
    }
}