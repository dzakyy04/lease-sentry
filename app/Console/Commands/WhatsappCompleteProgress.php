<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\Document2020;
use App\Models\Document2021;
use App\Models\Document2022;
use App\Models\Document2023;
use Illuminate\Console\Command;

class WhatsappCompleteProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:complete-progress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();
        if (!Helper::isWorkingDay($today)) {
            return;
        }

        $document2020 = Document2020::with('conceptor')
            ->whereJsonContains('progress->masuk', ['isCompleted' => true])
            ->whereJsonContains('progress->dinilai', ['isCompleted' => true])
            ->whereJsonContains('progress->selesai', ['isCompleted' => false])
            ->get();
        $document2021 = Document2021::with('conceptor')
            ->whereJsonContains('progress->masuk', ['isCompleted' => true])
            ->whereJsonContains('progress->dinilai', ['isCompleted' => true])
            ->whereJsonContains('progress->selesai', ['isCompleted' => false])
            ->get();
        $document2022 = Document2022::with('conceptor')
            ->whereJsonContains('progress->masuk', ['isCompleted' => true])
            ->whereJsonContains('progress->dinilai', ['isCompleted' => true])
            ->whereJsonContains('progress->selesai', ['isCompleted' => false])
            ->get();
        $document2023 = Document2023::with('conceptor')
            ->whereJsonContains('progress->masuk', ['isCompleted' => true])
            ->whereJsonContains('progress->dinilai', ['isCompleted' => true])
            ->whereJsonContains('progress->selesai', ['isCompleted' => false])
            ->get();

        $documents = $document2020->concat($document2021)->concat($document2022)->concat($document2023);

        foreach ($documents as  $document) {
            $progress = json_decode($document->progress);
            $startDate = $progress->dinilai->completion_date;
            $totalDays = Helper::dayDifference($startDate, $today);
            $conceptorNumber = $document->conceptor->whatsapp_number;

            if ($document->jenis_persetujuan == 'Sewa') {
                if ($totalDays == 1) {
                    $message = 'Pesan H-1';
                    Helper::sendWhatsapp($conceptorNumber, $message);
                } elseif ($totalDays == 2) {
                    $message = 'Pesan Hari-H';
                    Helper::sendWhatsapp($conceptorNumber, $message);
                    $progress->selesai->isCompleted = true;
                    $progress->selesai->completion_date = $today;
                }
            } else {
                if ($totalDays == 3) {
                    $message = 'Pesan H-1';
                    Helper::sendWhatsapp($conceptorNumber, $message);
                } elseif ($totalDays == 4) {
                    $message = 'Pesan Hari-H';
                    Helper::sendWhatsapp($conceptorNumber, $message);
                    $progress->selesai->isCompleted = true;
                    $progress->selesai->completion_date = $today;
                }
            }

            $progress->masuk->day = $totalDays;
            $document->update([
                'progress' => json_encode($progress)
            ]);
        }
    }
}
