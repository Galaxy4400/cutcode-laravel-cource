<?php

namespace Database\Factories;

use Domains\Catalog\Models\Brand;
use Domains\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domains\Product\Models\Product>
 */
class ProductFactory extends Factory
{
	protected $model = Product::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'title' => ucfirst($this->faker->words(2, true)),
			'text' => $this->faker->text(),
			'thumbnail' => $this->faker->fixturesImage('products'),
			// 'thumbnail' => $this->faker->loremflickr('images/products', 500, 500),
			'price' => $this->faker->numberBetween(1000, 1000000),
			'brand_id' => Brand::query()->inRandomOrder()->value('id'),
			'on_home_page' => $this->faker->boolean(),
			'sorting' => $this->faker->numberBetween(0, 999),
		];
	}
}
