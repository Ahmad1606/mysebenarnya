<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\McmcUser;

class McmcUserSeeder extends Seeder
{
    public function run(): void
    {
        McmcUser::insert([
            [
                'MCMCUserName' => 'AdminMCMC1',
                'MCMCEmail' => 'mcmc1@example.com',
                'MCMCPassword' => bcrypt('admin123'),
                'MCMCContact' => '0333333333',
                'RoleID' => 1
            ],
            [
                'MCMCUserName' => 'AdminMCMC2',
                'MCMCEmail' => 'mcmc2@example.com',
                'MCMCPassword' => bcrypt('admin456'),
                'MCMCContact' => '0444444444',
                'RoleID' => 1
            ]
        ]);
    }
}
