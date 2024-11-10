<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('charts')->insert([
            [
                'amount' => 100,
                'year' => 2020,
            ],
            [
                'amount' => 100,
                'year' => 2020,
            ],
            [
                'amount' => 200,
                'year' => 2021,
            ],
            [
                'amount' => 300,
                'year' => 2022,
            ],
            [
                'amount' => 400,
                'year' => 2023,
            ],
        ]);
    }
}
