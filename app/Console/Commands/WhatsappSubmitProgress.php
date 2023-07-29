<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\Holiday;
use App\Models\Document2020;
use Illuminate\Console\Command;

class WhatsappSubmitProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:submit-progress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a reminder message to the pkn admin to quickly complete the document';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = '2023-07-31';
        $document2020 = Document2020::with('conceptor')
            ->whereJsonContains('progress->masuk', ['isCompleted' => false])
            ->get();

        $documents = $document2020;

        if (!Helper::isWorkingDay($today)) {
            return;
        }

        foreach ($documents as $document) {
            $progress = json_decode($document->progress);
            $startDate = $document->tanggal_surat_diterima;
            $totalDays = Helper::dayDifference($startDate, $today);
            $conceptorNumber = $document->conceptor->whatsapp_number;

            if ($document->jenis_persetujuan == 'Sewa') {
                if ($totalDays == 0) {
                    $progress->masuk->day = $totalDays + 1;
                } elseif ($totalDays == 1) {
                    $message = 'Pesan H-1';
                    Helper::sendWhatsapp($conceptorNumber, $message);
                    $progress->masuk->day = $totalDays + 1;
                } elseif ($totalDays == 2) {
                    $message = 'Pesan Hari-H';
                    Helper::sendWhatsapp($conceptorNumber, $message);
                    $progress->masuk->isCompleted = true;
                }
            } else {
                if ($totalDays < 2) {
                    $progress->masuk->day = $totalDays + 1;
                } elseif ($totalDays == 2) {
                    $message = 'Pesan H-1';
                    Helper::sendWhatsapp($conceptorNumber, $message);
                    $progress->masuk->day = $totalDays + 1;
                } elseif ($totalDays == 3) {
                    $message = 'Pesan Hari-H';
                    Helper::sendWhatsapp($conceptorNumber, $message);
                    $progress->masuk->isCompleted = true;
                }
            }

            $document->update([
                'progress' => json_encode($progress)
            ]);
        }
    }
}
