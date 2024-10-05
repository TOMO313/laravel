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
                'number' => 10,
                'yen' => 100,
            ],
            [
                'number' => 20,
                'yen' => 200,
            ],
            [
                'number' => 30,
                'yen' => 300,
            ],
            [
                'number' => 40,
                'yen' => 400,
            ],
        ]);
    }
}
