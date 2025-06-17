<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PublicUser;

class PublicUserSeeder extends Seeder
{
    public function run(): void
    {
        PublicUser::insert([
            [
                'PublicName' => 'Ali Bin Ahmad',
                'PublicEmail' => 'ali@example.com',
                'PublicPassword' => bcrypt('password123'),
                'PublicContact' => '0123456789',
                'PublicStatusVerify' => true,
                'RoleID' => 3
            ],
            [
                'PublicName' => 'Siti Binti Amin',
                'PublicEmail' => 'siti@example.com',
                'PublicPassword' => bcrypt('password456'),
                'PublicContact' => '0198765432',
                'PublicStatusVerify' => false,
                'RoleID' => 3
            ]
        ]);
    }
}
