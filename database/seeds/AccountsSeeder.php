<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wallets')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Test 1',
                'sort' => '10',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'Test 3',
                'sort' => '30',
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'name' => 'Test 2',
                'sort' => '20',
            ]
        ]);

        DB::table('wallets')->insert([
            [
                'id' => 4,
                'user_id' => 2,
                'name' => 'Test2 1',
                'sort' => '10',
            ],
        ]);
    }
}
