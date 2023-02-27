<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $random = mt_rand(3, 5) *  100;

        return [
            'title' => $this->faker->sentence(mt_rand(8, 15)),
            'category_id' => mt_rand(1, 3),
            'user_id' => mt_rand(1, 5),
            'content' => $this->faker->paragraph(10),
            'thumbnail' => 'https://source.unsplash.com/random/' . $random . "x" . $random,
            'viewers' => mt_rand(10, 100)
        ];
    }
}
