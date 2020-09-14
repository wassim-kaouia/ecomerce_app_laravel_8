<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'       => $this->faker->sentence(15),
            'slug'        => $this->faker->slug,
            'subtitle'    => $this->faker->sentence(10),
            'description' => $this->faker->text(200),
            'price'       => $this->faker->numberBetween(15,300)*100,
            'image'       => 'https://via.placeholder.com/200x250',
        ];
    }
}
