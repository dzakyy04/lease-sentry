<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Akun Super Admin',
            'email' => 'pkn.palembang@gmail.com',
            'whatsapp_number' => '0811303743',
            'role' => 'Super Admin',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Agung Fitriandi Nugroho',
            'email' => 'adminpkn1@gmail.com',
            'whatsapp_number' => '085740319698',
            'role' => 'Admin Pkn',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Abdul Rohman Lubis',
            'email' => 'adminpkn2@gmail.com',
            'whatsapp_number' => '082246440726',
            'role' => 'Admin Pkn',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Ruyanto',
            'email' => 'adminpkn3@gmail.com',
            'whatsapp_number' => '081368333686',
            'role' => 'Admin Pkn',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Akhmad Taupikur Rahman',
            'email' => 'adminpkn4@gmail.com',
            'whatsapp_number' => '085287936525',
            'role' => 'Admin Pkn',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Nancy Grace Pasaribu',
            'email' => 'adminpkn5@gmail.com',
            'whatsapp_number' => '081273035356',
            'role' => 'Admin Pkn',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Wiyana',
            'email' => 'adminpkn6@gmail.com',
            'whatsapp_number' => '082136396070',
            'role' => 'Admin Pkn',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Albet Aruan',
            'email' => 'adminpenilai1@gmail.com',
            'whatsapp_number' => '085279716286',
            'role' => 'Admin Penilai',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Syamsul Bahri',
            'email' => 'adminpenilai2@gmail.com',
            'whatsapp_number' => '081337106430',
            'role' => 'Admin Penilai',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Muhamad Christian',
            'email' => 'adminpenilai3@gmail.com',
            'whatsapp_number' => '08117209690',
            'role' => 'Admin Penilai',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Romas Fahdiar',
            'email' => 'adminpenilai4@gmail.com',
            'whatsapp_number' => '081229111988',
            'role' => 'Admin Penilai',
            'password' => Hash::make('password123'),
        ]);
    }
}
