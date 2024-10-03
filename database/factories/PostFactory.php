<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(5),
            'body' => $this->faker->text(10),
            'user_id' => User::factory(), //UserFactoryクラスのdifinition()に従ってusersデータを生成(今回は5件postsデータを生成しているので5件usersデータを生成)
        ];
    }
}
