<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();

        return [
            'product_id' => function () {
                return Product::all()->random();
            },
            'customer' => $faker->name,
            'review' => $faker->paragraph,
            'star' => $faker->numberBetween(0, 5),
        ];
    }
}
