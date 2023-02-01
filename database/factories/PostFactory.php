<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'author_id' => User::factory(),
            'content' => $this->faker->paragraphs(3, true),
            'published_at' => $this->faker->boolean(75) ? $this->faker->dateTime : null,
            'slug' => $this->faker->unique()->slug,
            'title' => $this->faker->words(5, true),
        ];
    }
}
