<?php

namespace Database\Seeders;

use App\Models\Document2022;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Document2022Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Document2022::factory(10)->create();
    }
}
