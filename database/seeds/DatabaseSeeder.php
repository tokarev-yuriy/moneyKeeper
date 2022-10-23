<?php

use Database\Seeders\AccountGrpoupsSeeder;
use Database\Seeders\AccountsSeeder;
use Database\Seeders\CategoriesSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            AccountGrpoupsSeeder::class,
            AccountsSeeder::class,
            CategoriesSeeder::class,
        ]);
    }
}
