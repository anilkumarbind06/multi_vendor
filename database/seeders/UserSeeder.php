<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::truncate();

        \App\Models\User::create([
            'name'              => 'Anil Bind',
            'email'             => 'anilkumarbind06@gmail.com',
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
            'email_verified_at' => now(),
        ]);

        \App\Models\User::factory()->count(10)->create(); // count(2) means it will loop that much time
    }
}
