<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('role_users')->insert([
            ['RoleID' => 1, 'RoleName' => 'MCMC',       'created_at' => now(), 'updated_at' => now()],
            ['RoleID' => 2, 'RoleName' => 'Agency',     'created_at' => now(), 'updated_at' => now()],
            ['RoleID' => 3, 'RoleName' => 'PublicUser', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
