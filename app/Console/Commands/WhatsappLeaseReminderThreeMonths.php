<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\Document2020;
use App\Models\Document2021;
use App\Models\Document2022;
use App\Models\Document2023;
use Illuminate\Console\Command;

class WhatsappLeaseReminderThreeMonths extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:lease-reminder-three-months';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send WhatsApp messages reminding the lease period to end to the satker and conceptor';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();

        $document2020 = Document2020::with('conceptor')
            ->where('jenis_persetujuan', 'Sewa')
            ->whereNotNull('tanggal_surat_persetujuan_penolakan')
            ->get();
        $document2021 = Document2021::with('conceptor')
            ->where('jenis_persetujuan', 'Sewa')
            ->whereNotNull('tanggal_surat_persetujuan_penolakan')
            ->get();
        $document2022 = Document2022::with('conceptor')
            ->where('jenis_persetujuan', 'Sewa')
            ->whereNotNull('tanggal_surat_persetujuan_penolakan')
            ->get();
        $document2023 = Document2023::with('conceptor')
            ->where('jenis_persetujuan', 'Sewa')
            ->whereNotNull('tanggal_surat_persetujuan_penolakan')
            ->get();

        $documents = $document2020->concat($document2021)->concat($document2022)->concat($document2023);

        foreach ($documents as $document) {
            $alertDate = Carbon::parse($document->tanggal_surat_persetujuan_penolakan)
                ->addYears($document->periode_sewa)
                ->subMonths(3)
                ->toDateString();

            if ($today == $alertDate) {
                $satker = [
                    'number' => $document->nomor_whatsapp_satker,
                    'message' => 'Ini pesan untuk satker',
                ];
                $conceptor = [
                    'number' => $document->conceptor->whatsapp_number,
                    'message' => 'Ini pesan untuk konseptor'
                ];
                $this->info(Helper::sendWhatsapp($satker['number'], $satker['message']));
                $this->info(Helper::sendWhatsapp($conceptor['number'], $conceptor['message']));
            }
        }
    }
}
