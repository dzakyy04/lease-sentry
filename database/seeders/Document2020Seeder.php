<?php

namespace Database\Seeders;

use App\Models\Document2020;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Document2020Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Document2020::factory(10)->create();
    }
}
