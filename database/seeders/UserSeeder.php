<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed user awal aplikasi.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            [
                'email' => 'admin@simtepra.local',
            ],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $user->syncRoles(['super-admin']);
    }
}