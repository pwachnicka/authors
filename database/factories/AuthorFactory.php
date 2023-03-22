<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Author::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'github' => $this->faker->word,
            'twitter' => $this->faker->word,
            'location' => $this->faker->country,
            'latest_article_published' => $this->faker->realText($maxNbChars = 20, $indexSize = 2)
        ];
    }
}
