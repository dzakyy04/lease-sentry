<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Kiagus Efan Fitriyan',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'Super Admin',
        ]);

        User::create([
            'name' => 'Iman Carrazi Syamsidi',
            'email' => 'adminpkn@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'Admin Pkn',
        ]);

        User::create([
            'name' => 'Iman Carrazi Syamsidi',
            'email' => 'adminpenilai@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'Admin Penilai',
        ]);
    }
}
