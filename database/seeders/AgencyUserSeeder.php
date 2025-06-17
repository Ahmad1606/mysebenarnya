<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AgencyUser;

class AgencyUserSeeder extends Seeder
{
    public function run(): void
    {
        AgencyUser::insert([
            [
                'AgencyUserName' => 'AgencyA',
                'AgencyEmail' => 'agency1@example.com',
                'AgencyPassword' => bcrypt('agency123'),
                'AgencyContact' => '0111111111',
                'AgencyFirstLogin' => true,
                'RoleID' => 2,
                'MCMCID' => 1
            ],
            [
                'AgencyUserName' => 'AgencyB',
                'AgencyEmail' => 'agency2@example.com',
                'AgencyPassword' => bcrypt('agency456'),
                'AgencyContact' => '0222222222',
                'AgencyFirstLogin' => false,
                'RoleID' => 2,
                'MCMCID' => 2
            ]
        ]);
    }
}
