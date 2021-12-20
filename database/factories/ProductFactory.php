<?php

namespace Database\Factories;

use App\Models\Product;
use Carbon\Carbon;
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
            'category_id' => $this->faker->numberBetween(1, 13),
            // 'category_id' => '1',
            'title' => $name,
            'slug' => \Str::slug($name),
            'stok' => '100',
            'price' => '80000000',
            'jumlah_halaman' => '12',
            'penerbit' => 'ppp',
            'tanggal_terbit' => Carbon::now(),
            'berat' => '1',
            'lebar' => '12',
            'bahasa' => 'indo',
            'panjang' => '11',
            'image' => 'dcElj3vVMIOfdX032IEmZoek9aAsJ4u5NkxqGPjn.jpg',
            'deskripsi_product' => $this->faker->word(10)
        ];
    }
}
