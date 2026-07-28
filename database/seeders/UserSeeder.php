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
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Rofilia',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'rofiliaragil@gmail.com'],
            [
                'name' => 'Rofilia Ragil Azzahro',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        // Direktur
        User::updateOrCreate(
            ['email' => 'direktur@gmail.com'],
            [
                'name' => 'Direktur Fazri',
                'role' => 'direktur',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'fazrikurniawan@gmail.com'],
            [
                'name' => 'Fazri Kurniawan',
                'role' => 'direktur',
                'password' => Hash::make('password'),
            ]
        );
    }
}
