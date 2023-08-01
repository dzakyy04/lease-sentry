<?php

namespace Database\Seeders;

use App\Models\Document2023;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Document2023Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Document2023::factory(10)->create();
    }
}
