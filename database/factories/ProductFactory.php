<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $name = $this->faker->name();
        return [
            'category_id' => '1',
            'title' => $name,
            'slug' => \Str::slug($name),
            'stok' => '100',
            'price' => '80000000',
            'image' => 'EUUcv9kcWa6yMEgxevvKQDyclZsWy1hyEYm1tzLB.png',
            'detail_product' => $this->faker->word(10)
        ];
    }
}
