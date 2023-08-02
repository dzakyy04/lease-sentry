<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document2021>
 */
class Document2021Factory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'satker' => $this->faker->company,
            'nomor_whatsapp_satker' => $this->faker->phoneNumber,
            'nomor_surat_masuk' => $this->faker->unique()->randomNumber(6),
            'tanggal_surat_masuk' => $this->faker->date(),
            'tanggal_surat_diterima' => $this->faker->date(),
            'jenis_persetujuan' => $this->faker->randomElement(['Penjualan', 'Penghapusan', 'Sewa']),
            'user_id_pkn' => rand(2,7),
            'user_id_penilai' => rand(8, 11),
            'nomor_nd_permohonan_penilaian' => $this->faker->optional()->randomNumber(6),
            'tanggal_nd_permohonan_penilaian' => $this->faker->optional()->date(),
            'nomor_ndr_penilaian' => $this->faker->optional()->randomNumber(6),
            'tanggal_ndr_diterima_penilaian' => $this->faker->optional()->date(),
            'nomor_surat_persetujuan_penolakan' => $this->faker->optional()->randomNumber(6),
            'tanggal_surat_persetujuan_penolakan' => $this->faker->optional()->date(),
            'nilai_proporsional_harga_perolehan_nilai_bmn' => $this->faker->optional()->randomNumber(8),
            'nilai_persetujuan' => $this->faker->optional()->randomFloat(2, 100, 1000),
            'periode_sewa' => $this->faker->optional()->numberBetween(1, 12),
            'status_masa_aktif' => $this->faker->optional()->randomElement(['Aktif', 'Non-aktif', 'Tenggang']),
        ];
    }
}
