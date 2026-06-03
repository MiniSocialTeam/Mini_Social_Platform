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
    \App\Models\User::firstOrCreate(
        ['user_id' => 1],
        [
            'first_name' => 'Alice',
            'last_name' => 'Johnson',
            'email' => 'alice@example.com',
            'password' => bcrypt('password'),
        ]
    );

    \App\Models\User::firstOrCreate(
        ['user_id' => 2],
        [
            'first_name' => 'Bob',
            'last_name' => 'Smith',
            'email' => 'bob@example.com',
            'password' => bcrypt('password'),
        ]
    );
}
}
