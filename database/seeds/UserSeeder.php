<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'test@gmail.com',
                'email' => 'test@gmail.com',
                'password' => Hash::make('password'),
            ],
            [
                'id' => 2,
                'name' => 'test2@gmail.com',
                'email' => 'test2@gmail.com',
                'password' => Hash::make('password'),
            ],
        ]);
    }
}
