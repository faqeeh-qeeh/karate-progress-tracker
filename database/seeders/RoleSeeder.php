<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'Senpai', 'Kohai'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['nama' => $role]);
        }
    }
}
