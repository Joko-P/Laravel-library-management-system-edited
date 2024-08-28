<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\App\Models\User::count() == 0) {
            User::create([
                'name' => 'Joko_P',
                'username' => 'Joko_P',
                'password' => Hash::make('password'),
            ]);
            User::create([
                'name' => 'tauseedzaman',
                'username' => 'tauseedzaman',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
