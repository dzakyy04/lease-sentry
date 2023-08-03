<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\Document2020;
use App\Models\Document2021;
use App\Models\Document2022;
use App\Models\Document2023;
use Illuminate\Console\Command;

class WhatsappInternalPkn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:internal-pkn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send whatsapp message to admin pkn to quickly follow up on documents';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();

        if (!Helper::isWorkingDay($today)) {
            return;
        }

        $document2020 = Document2020::with(['user_pkn', 'user_penilai'])
            ->whereJsonContains('progress->masuk', ['isCompleted' => true])
            ->whereJsonContains('progress->dinilai', ['isCompleted' => true])
            ->whereJsonContains('progress->selesai', ['isCompleted' => false])
            ->get();
        $document2021 = Document2021::with(['user_pkn', 'user_penilai'])
            ->whereJsonContains('progress->masuk', ['isCompleted' => true])
            ->whereJsonContains('progress->dinilai', ['isCompleted' => true])
            ->whereJsonContains('progress->selesai', ['isCompleted' => false])
            ->get();
        $document2022 = Document2022::with(['user_pkn', 'user_penilai'])
            ->whereJsonContains('progress->masuk', ['isCompleted' => true])
            ->whereJsonContains('progress->dinilai', ['isCompleted' => true])
            ->whereJsonContains('progress->selesai', ['isCompleted' => false])
            ->get();
        $document2023 = Document2023::with(['user_pkn', 'user_penilai'])
            ->whereJsonContains('progress->masuk', ['isCompleted' => true])
            ->whereJsonContains('progress->dinilai', ['isCompleted' => true])
            ->whereJsonContains('progress->selesai', ['isCompleted' => false])
            ->get();

        $documents = $document2020->concat($document2021)->concat($document2022)->concat($document2023);

        foreach ($documents as $document) {
            $progress = json_decode($document->progress);
            $startDate = $document->tanggal_ndr_diterima_penilaian;
            $totalDays = Helper::dayDifference($startDate, $today);
            $conceptorNumber = $document->user_pkn->whatsapp_number;

            $approval = $document->jenis_persetujuan;
            $satker = $document->jenis_persetujuan;
            $number = $document->jenis_persetujuan;

            if ($approval == 'Sewa') {
                if ($totalDays == 1) {
                    $deadline = 'besok';
                    $message = $this->messageTemplate($approval, $satker, $number, $deadline);
                    Helper::sendWhatsapp($conceptorNumber, $message);
                } else if ($totalDays == 2) {
                    $deadline = 'hari ini';
                    $message = $this->messageTemplate($approval, $satker, $number, $deadline);
                    Helper::sendWhatsapp($conceptorNumber, $message);
                }
            } else {
                if ($totalDays == 3) {
                    $deadline = 'besok';
                    $message = $this->messageTemplate($approval, $satker, $number, $deadline);
                    Helper::sendWhatsapp($conceptorNumber, $message);
                } else if ($totalDays == 4) {
                    $deadline = 'hari ini';
                    $message = $this->messageTemplate($approval, $satker, $number, $deadline);
                    Helper::sendWhatsapp($conceptorNumber, $message);
                }
            }

            $progress->selesai->day = $totalDays;
            $document->update([
                'progress' => json_encode($progress)
            ]);
        }
    }

    private function messageTemplate($approval, $satker, $number, $deadline)
    {
        return "Pemberitahuan,\n\n" .
            "Surat permohonan $approval satker $satker Nomor $number satker harus segera ditindaklanjuti paling lambat $deadline.\n\n" .
            "Terima kasih";
    }
}
