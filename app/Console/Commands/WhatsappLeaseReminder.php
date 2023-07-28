<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Document2020;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;

class WhatsappLeaseReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:lease-reminder';

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
        $document2020 = Document2020::with('conceptor')->where('jenis_persetujuan', 'Sewa')->get();

        $documents = $document2020;

        $today = Carbon::today()->toDateString();

        foreach ($documents as $document) {
            $alertDate = Carbon::parse($document->tanggal_surat_persetujuan_penolakan)
                ->addYears($document->periode_sewa)
                ->subMonths(3)
                ->toDateString();

            if ($today == $alertDate) {
                $client = new Client();
                $satker = [
                    'json' => [
                        'device_id' => env('DEVICE_ID'),
                        'number' => $document->nomor_whatsapp_satker,
                        'message' => 'Ini pesan untuk satker'
                    ]
                ];
                $conceptor = [
                    'json' => [
                        'device_id' => env('DEVICE_ID'),
                        'number' => $document->conceptor->whatsapp_number,
                        'message' => 'Ini pesan untuk konseptor'
                    ]
                ];

                $request = new Request('POST', 'https://app.whacenter.com/api/send');
                // Whatsapp to Satker
                $responseSatker = $client->sendAsync($request, $satker)->wait();
                $this->info($responseSatker->getBody());
                // Whatsapp to Conceptor
                $responseConceptor = $client->sendAsync($request, $conceptor)->wait();
                $this->info($responseConceptor->getBody());
            }
        }
    }
}
