<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\User::create([
        'user_id' => 1, // Important pour ton MLD
        'first_name' => 'Mohamed',
        'last_name' => 'Test',
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);
}
}
