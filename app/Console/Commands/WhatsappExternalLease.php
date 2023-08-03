<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\Document2020;
use App\Models\Document2021;
use App\Models\Document2022;
use App\Models\Document2023;
use Illuminate\Console\Command;

class WhatsappExternalLease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:external-lease';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send whatsApp message to satker and related conceptor that the lease period will end in 3 months';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();

        $document2020 = Document2020::with(['user_pkn', 'user_penilai'])
            ->where('jenis_persetujuan', 'Sewa')
            ->whereNotNull('nomor_surat_persetujuan_penolakan')
            ->whereNotNull('tanggal_surat_persetujuan_penolakan')
            ->get();
        $document2021 = Document2021::with(['user_pkn', 'user_penilai'])
            ->where('jenis_persetujuan', 'Sewa')
            ->whereNotNull('nomor_surat_persetujuan_penolakan')
            ->whereNotNull('tanggal_surat_persetujuan_penolakan')
            ->get();
        $document2022 = Document2022::with(['user_pkn', 'user_penilai'])
            ->where('jenis_persetujuan', 'Sewa')
            ->whereNotNull('nomor_surat_persetujuan_penolakan')
            ->whereNotNull('tanggal_surat_persetujuan_penolakan')
            ->get();
        $document2023 = Document2023::with(['user_pkn', 'user_penilai'])
            ->where('jenis_persetujuan', 'Sewa')
            ->whereNotNull('nomor_surat_persetujuan_penolakan')
            ->whereNotNull('tanggal_surat_persetujuan_penolakan')
            ->get();

        $documents = $document2020->concat($document2021)->concat($document2022)->concat($document2023);

        foreach ($documents as $document) {
            $alertDate = Carbon::parse($document->tanggal_surat_persetujuan_penolakan)
                ->addYears($document->periode_sewa)
                ->subMonths(3)
                ->toDateString();

            $number = $document->nomor_surat_persetujuan_penolakan;
            $expirationDate = Carbon::parse($document->tanggal_surat_persetujuan_penolakan)
                ->addYears($document->periode_sewa)
                ->locale('id')
                ->isoFormat('DD MMMM YYYY');

            if ($today == $alertDate) {
                $satker = [
                    'number' => $document->nomor_whatsapp_satker,
                    'message' => $this->satkerMessageTemplate($number, $expirationDate)
                ];
                $conceptor = [
                    'number' => $document->user_pkn->whatsapp_number,
                    'message' => $this->conceptorMessageTemplate($document->satker, $number, $expirationDate),
                ];

                Helper::sendWhatsapp($satker['number'], $satker['message']);
                Helper::sendWhatsapp($conceptor['number'], $conceptor['message']);
            }
        }
    }

    private function satkerMessageTemplate($number, $date)
    {
        return "Pemberitahuan,\n\n" .
            "Surat Persetujuan Sewa BMN Nomor $number akan berakhir, apabila ingin dilakukan perpanjangan, silahkan diusulkan kembali kepada KPKNL Palembang sebelum $date.\n\n" .
            "Terima kasih";
    }

    private function conceptorMessageTemplate($satker, $number, $date)
    {
        $satkerMessage = "*Surat Persetujuan Sewa BMN Nomor $number akan berakhir, apabila ingin dilakukan perpanjangan, silahkan diusulkan kembali kepada KPKNL Palembang sebelum $date*";

        return "Pemberitahuan,\n\n" .
            "Pesan pemberitahuan kepada satker $satker $satkerMessage, telah terkirim.\n\n" .
            "Terima kasih";
    }
}
