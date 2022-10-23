<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'TestCategory 1',
                'sort' => '10',
                'icon' => 'testIcon',
                'types' => json_encode(['income']),
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'TestCategory 3',
                'sort' => '30',
                'icon' => '',
                'types' => json_encode(['spend', 'transfer', 'income']),
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'name' => 'TestCategory 2',
                'sort' => '20',
                'icon' => '',
                'types' => json_encode(['transfer']),
            ]
        ]);

        DB::table('categories')->insert([
            [
                'id' => 4,
                'user_id' => 2,
                'name' => 'TestCategory 1',
                'sort' => '10',
                'icon' => 'testIcon',
                'types' => json_encode(['income']),
            ],
        ]);
    }
}
