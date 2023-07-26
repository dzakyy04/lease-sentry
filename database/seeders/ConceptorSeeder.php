<?php

namespace Database\Seeders;

use App\Models\Conceptor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ConceptorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Conceptor::create([
            'name' => 'Kiagus Muhammad Efan Fitriyan',
            'whatsapp_number' => '081278612312',
        ]);

        Conceptor::create([
            'name' => 'Iman Carrazi Syamsidi',
            'whatsapp_number' => '081368798772',
        ]);

        Conceptor::create([
            'name' => 'Dewa Sheva Dzaky',
            'whatsapp_number' => '082269324126',
        ]);
    }
}
