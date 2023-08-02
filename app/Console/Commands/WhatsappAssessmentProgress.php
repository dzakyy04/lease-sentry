<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use App\Models\Document2020;
use App\Models\Document2021;
use App\Models\Document2022;
use App\Models\Document2023;
use Illuminate\Console\Command;

class WhatsappAssessmentProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:assessment-progress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a reminder message to the penilai admin to quickly complete the document';

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
            ->whereJsonContains('progress->dinilai', ['isCompleted' => false])
            ->get();
        $document2021 = Document2021::with('conceptor')
            ->whereJsonContains('progress->masuk', ['isCompleted' => true])
            ->whereJsonContains('progress->dinilai', ['isCompleted' => false])
            ->get();
        $document2022 = Document2022::with('conceptor')
            ->whereJsonContains('progress->masuk', ['isCompleted' => true])
            ->whereJsonContains('progress->dinilai', ['isCompleted' => false])
            ->get();
        $document2023 = Document2023::with('conceptor')
            ->whereJsonContains('progress->masuk', ['isCompleted' => true])
            ->whereJsonContains('progress->dinilai', ['isCompleted' => false])
            ->get();

        $documents = $document2020->concat($document2021)->concat($document2022)->concat($document2023);

        foreach ($documents as $document) {
            $progress = json_decode($document->progress);
            $startDate = $progress->masuk->completion_date;
            $totalDays = Helper::dayDifference($startDate, $today);
            $number = '082269324126';

            if ($totalDays == 14) {
                $message = 'Pesan H-1';
                Helper::sendWhatsapp($number, $message);
            } elseif ($totalDays == 15) {
                $message = 'Pesan Hari-H';
                Helper::sendWhatsapp($number, $message);
                $progress->dinilai->isCompleted = true;
                $progress->dinilai->completion_date = $today;
            }

            $progress->dinilai->day = $totalDays;
            $document->update([
                'progress' => json_encode($progress)
            ]);
        }
    }
}
