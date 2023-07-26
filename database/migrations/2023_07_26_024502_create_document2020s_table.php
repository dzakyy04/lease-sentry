<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('document2020s', function (Blueprint $table) {
            $table->id();
            // Progress Masuk
            $table->string('satker');
            $table->string('nomor_whatsapp_satker');
            $table->string('nomor_surat_masuk');
            $table->date('tanggal_surat_masuk');
            $table->date('tanggal_surat_diterima');
            $table->string('jenis_persetujuan');
            $table->foreignId('conceptor_id')->constrained();
            $table->string('nomor_nd_permohonan_penilaian')->nullable();
            $table->date('tanggal_nd_permohonan_penilaian')->nullable();
            // Progress Penilaian
            $table->string('nomor_ndr_penilaian')->nullable();
            $table->date('tanggal_ndr_diterima_penilaian')->nullable();
            // Progress Penyelesaian
            $table->string('nomor_surat_persetujuan_penolakan')->nullable();
            $table->date('tanggal_surat_persetujuan_penolakan')->nullable();
            $table->string('nilai_proporsional_harga_perolehan_nilai_bmn')->nullable();
            $table->string('nilai_persetujuan')->nullable();
            $table->integer('periode_sewa')->nullable();
            // Tambahan
            $table->string('status_masa_aktif')->nullable();
            $table->json('progress')->default(json_encode([
                'progress_masuk' => ['day' => 0, 'isCompleted' => false],
                'progress_dinilai' => ['day' => 0, 'isCompleted' => false],
                'progress_selesai' => ['day' => 0, 'isCompleted' => false],
            ]));
            $table->integer('total_hari')->virtualAs(
                "JSON_UNQUOTE(JSON_EXTRACT(progress, '$.progress_masuk.day')) +
                JSON_UNQUOTE(JSON_EXTRACT(progress, '$.progress_dinilai.day')) +
                JSON_UNQUOTE(JSON_EXTRACT(progress, '$.progress_selesai.day'))"
            );
            $table->string('status_progress')->virtualAs(
                "CASE WHEN 
                JSON_UNQUOTE(JSON_EXTRACT(progress, '$.progress_masuk.isCompleted')) = 'true' AND
                JSON_UNQUOTE(JSON_EXTRACT(progress, '$.progress_dinilai.isCompleted')) = 'true' AND
                JSON_UNQUOTE(JSON_EXTRACT(progress, '$.progress_selesai.isCompleted')) = 'true'
            THEN 'Selesai' ELSE 'Diproses' END"
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document2020s');
    }
};
