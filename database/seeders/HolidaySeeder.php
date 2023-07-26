<?php

namespace Database\Seeders;

use GuzzleHttp\Client;
use App\Models\Holiday;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = new Client();
        $response = $client->get('https://api-harilibur.vercel.app/api');
        $data = json_decode($response->getBody(), true);

        $holidays = array_filter($data, function ($item) {
            return isset($item['is_national_holiday']) && $item['is_national_holiday'] === true;
        });

        foreach ($holidays as $holiday) {
            Holiday::create([
                'date' => $holiday['holiday_date'],
                'name' => $holiday['holiday_name'],
            ]);
        }
    }
}
