<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $adminRole = Role::where('nama', 'admin')->first();
        $senpaiRole = Role::where('nama', 'Senpai')->first();
        $kohaiRole = Role::where('nama', 'Kohai')->first();

        User::firstOrCreate(
            ['email' => 'admin@karate.com'],
            [
                'name' => 'Administrator Karate',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'senpai@karate.com'],
            [
                'name' => 'Senpai Kenji Takahashi',
                'password' => Hash::make('password'),
                'role_id' => $senpaiRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'kohai@karate.com'],
            [
                'name' => 'Kohai Budi Pratama',
                'password' => Hash::make('password'),
                'role_id' => $kohaiRole->id,
            ]
        );
    }
}
