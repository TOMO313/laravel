<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::factory()->count(5)->create(); //PostFactoryクラスのdifinition()に従ってpostsデータを5件生成
    }
}
