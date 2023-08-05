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
            'email' => 'agungfitriandi@gmail.com',
            'whatsapp_number' => '085740319698',
            'role' => 'Admin Pkn',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Abdul Rohman Lubis',
            'email' => 'hafanin.official@gmail.com',
            'whatsapp_number' => '082246440726',
            'role' => 'Admin Pkn',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Ruyanto',
            'email' => 'yantokpknl68@gmail.com',
            'whatsapp_number' => '081368333686',
            'role' => 'Admin Pkn',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Akhmad Taupikur Rahman',
            'email' => 'elrahmanfikri@gmail.com',
            'whatsapp_number' => '085287936525',
            'role' => 'Admin Pkn',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Nancy Grace Pasaribu',
            'email' => 'ncy039@gmail.com',
            'whatsapp_number' => '081273035356',
            'role' => 'Admin Pkn',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Wiyana',
            'email' => 'wiyana11@gmail.com',
            'whatsapp_number' => '082136396070',
            'role' => 'Admin Pkn',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Albet Aruan',
            'email' => 'albet.aruan@gmail.com',
            'whatsapp_number' => '085279716286',
            'role' => 'Admin Penilai',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Syamsul Bahri',
            'email' => 'syamsulpn@gmail.com',
            'whatsapp_number' => '081337106430',
            'role' => 'Admin Penilai',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Muhamad Christian',
            'email' => 'muhamadchristian85@gmail.com',
            'whatsapp_number' => '08117209690',
            'role' => 'Admin Penilai',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Romas Fahdiar',
            'email' => 'hitzi29@gmail.com',
            'whatsapp_number' => '081229111988',
            'role' => 'Admin Penilai',
            'password' => Hash::make('password123'),
        ]);
    }
}
