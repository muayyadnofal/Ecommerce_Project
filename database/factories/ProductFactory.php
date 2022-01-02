<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ProductFactory extends Factory
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
            'admin_id' => function () {
                return Admin::all()->random();
            },
            'category_id' => function () {
                return Category::all()->random();
            },
            'name' => $faker->word,
            'detail' => $faker->paragraph,
            'price' => $faker->numberBetween(100, 1000),
            'discount' => $faker->numberBetween(0, 80),
        ];
    }
}
