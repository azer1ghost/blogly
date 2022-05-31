<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
         \App\Models\User::factory(10)
             ->hasPosts(20)
             ->create();

        \App\Models\User::factory(1)
            ->hasPosts(20)
            ->create([
                'email' => 'user@gmail.com',
                'password' => Hash::make('password')

            ]);
    }
}
