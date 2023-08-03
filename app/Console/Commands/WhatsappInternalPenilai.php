<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\Document2020;
use App\Models\Document2021;
use App\Models\Document2022;
use App\Models\Document2023;
use Illuminate\Console\Command;

class WhatsappInternalPenilai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:internal-penilai';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send whatsapp message to admin penilai to quickly follow up on documents';

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
            ->whereJsonContains('progress->dinilai', ['isCompleted' => false])
            ->get();
        $document2021 = Document2021::with(['user_pkn', 'user_penilai'])
            ->whereJsonContains('progress->masuk', ['isCompleted' => true])
            ->whereJsonContains('progress->dinilai', ['isCompleted' => false])
            ->get();
        $document2022 = Document2022::with(['user_pkn', 'user_penilai'])
            ->whereJsonContains('progress->masuk', ['isCompleted' => true])
            ->whereJsonContains('progress->dinilai', ['isCompleted' => false])
            ->get();
        $document2023 = Document2023::with(['user_pkn', 'user_penilai'])
            ->whereJsonContains('progress->masuk', ['isCompleted' => true])
            ->whereJsonContains('progress->dinilai', ['isCompleted' => false])
            ->get();

        $documents = $document2020->concat($document2021)->concat($document2022)->concat($document2023);

        foreach ($documents as $document) {
            $progress = json_decode($document->progress);
            $startDate = $document->tanggal_nd_permohonan_penilaian;
            $totalDays = Helper::dayDifference($startDate, $today);
            $conceptorNumber = $document->user_penilai->whatsapp_number;

            $approval = $document->jenis_persetujuan;
            $number = $document->nomor_nd_permohonan_penilaian;

            if ($totalDays == 14) {
                $deadline = "besok";
                $message = $this->messageTemplate($approval, $number, $deadline);
                Helper::sendWhatsapp($conceptorNumber, $message);
            } elseif ($totalDays == 15) {
                $deadline = "hari ini";
                $message = $this->messageTemplate($approval, $number, $deadline);
                Helper::sendWhatsapp($conceptorNumber, $message);
            }

            $progress->dinilai->day = $totalDays;
            $document->update([
                'progress' => json_encode($progress)
            ]);
        }
    }

    private function messageTemplate($approval, $number, $deadline)
    {
        return "Pemberitahuan,\n\n" .
            "Nota Dinas permohonan penilaian dalam rangka $approval Nomor $number harus segera ditindaklanjuti paling lambat $deadline.\n\n" .
            "Terima kasih";
    }
}
