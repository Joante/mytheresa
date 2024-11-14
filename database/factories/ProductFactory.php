<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'sku' => $this->faker->unique()->numberBetween(100000, 999999),
            'name' => $this->faker->word,
            'category' => $this->faker->word,
            'price' => $this->faker->randomNumber(5), 
            'currency' => 'EUR',
        ];
    }
}
