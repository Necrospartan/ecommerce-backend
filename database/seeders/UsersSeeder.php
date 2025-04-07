<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'Administrador@example.org',
            'password' => Hash::make('Password#1'),
            'role' => 'Admin',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Cliente1',
            'email' => 'Cliente1@example.org',
            'password' => Hash::make('Password#1'),
            'role' => 'Cliente',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Cliente2',
            'email' => 'Cliente2@example.org',
            'password' => Hash::make('Password#1'),
            'role' => 'Cliente',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
