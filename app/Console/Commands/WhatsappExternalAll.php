<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\Document2020;
use App\Models\Document2021;
use App\Models\Document2022;
use App\Models\Document2023;
use Illuminate\Console\Command;

class WhatsappExternalAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:external-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send whatsapp message to satker and conceptor after 5 months from tanggal surat persetujuan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();

        $document2020 = Document2020::with(['user_pkn', 'user_penilai'])
            ->whereNotNull('nomor_surat_persetujuan_penolakan')
            ->whereNotNull('tanggal_surat_persetujuan_penolakan')
            ->get();
        $document2021 = Document2021::with(['user_pkn', 'user_penilai'])
            ->whereNotNull('nomor_surat_persetujuan_penolakan')
            ->whereNotNull('tanggal_surat_persetujuan_penolakan')
            ->get();
        $document2022 = Document2022::with(['user_pkn', 'user_penilai'])
            ->whereNotNull('nomor_surat_persetujuan_penolakan')
            ->whereNotNull('tanggal_surat_persetujuan_penolakan')
            ->get();
        $document2023 = Document2023::with(['user_pkn', 'user_penilai'])
            ->whereNotNull('nomor_surat_persetujuan_penolakan')
            ->whereNotNull('tanggal_surat_persetujuan_penolakan')
            ->get();

        $documents = $document2020->concat($document2021)->concat($document2022)->concat($document2023);

        foreach ($documents as $document) {
            $alertDate = Carbon::createFromFormat('Y-m-d', $document->tanggal_surat_persetujuan_penolakan)
                ->addMonths(5)
                ->toDateString();

            $approval = $document->jenis_persetujuan;
            $number = $document->nomor_surat_persetujuan_penolakan;
            $after6Months = Carbon::parse($document->tanggal_surat_persetujuan_penolakan)
                ->addMonths(6)
                ->locale('id')
                ->isoFormat('DD MMMM YYYY');

            if ($today == $alertDate) {
                $satker = [
                    'number' => $document->nomor_whatsapp_satker,
                    'message' => $this->satkerMessageTemplate($approval, $number, $after6Months),
                ];
                $conceptor = [
                    'number' => $document->user_pkn->whatsapp_number,
                    'message' => $this->conceptorMessageTemplate($document->satker, $approval, $number, $after6Months),
                ];

                Helper::sendWhatsapp($satker['number'], $satker['message']);
                Helper::sendWhatsapp($conceptor['number'], $conceptor['message']);
            }
        }
    }

    private function satkerMessageTemplate($approval, $number, $date)
    {
        return "Pemberitahuan,\n\n" .
            "Jangan lupa untuk melaporkan tindak lanjut Surat Persetujuan $approval Nomor $number sebelum tanggal $date, Apabila sudah melaporkan silahkan diabaikan pemberitahuan ini.\n\n" .
            "Terima kasih";
    }

    private function conceptorMessageTemplate($satker, $approval, $number, $date)
    {
        $satkerMessage = "*Jangan lupa untuk melaporkan tindak lanjut Surat Persetujuan $approval Nomor $number sebelum tanggal $date, Apabila sudah melaporkan silahkan diabaikan pemberitahuan ini*";

        return "Pemberitahuan,\n\n" .
            "Pesan pemberitahuan kepada satker $satker $satkerMessage, telah terkirim.\n\n" .
            "Terima kasih";
    }
}
