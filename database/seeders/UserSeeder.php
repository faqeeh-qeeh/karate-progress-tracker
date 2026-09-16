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
                'birth_place' => 'Indramayu',
                'birth_date' => '1990-01-01',
                'gender' => 'male',
                'address' => 'Jl. Mayor Dasuki No. 12, Indramayu',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'senpai@karate.com'],
            [
                'name' => 'Senpai Kenji Takahashi',
                'birth_place' => 'Cirebon',
                'birth_date' => '1995-08-17',
                'gender' => 'male',
                'address' => 'Jl. Pemuda No. 45, Cirebon',
                'phone' => '081298765432',
                'password' => Hash::make('password'),
                'role_id' => $senpaiRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'kohai@karate.com'],
            [
                'name' => 'Kohai Budi Pratama',
                'birth_place' => 'Indramayu',
                'birth_date' => '2004-03-12',
                'gender' => 'male',
                'address' => 'Jl. Lohbener Timur No. 8, Indramayu',
                'phone' => '085712345671',
                'password' => Hash::make('password'),
                'role_id' => $kohaiRole->id,
            ]
        );
    }
}
