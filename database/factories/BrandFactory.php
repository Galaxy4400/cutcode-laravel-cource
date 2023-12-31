<?php

namespace Database\Factories;

use Domains\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
	protected $model = Brand::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'title' => $this->faker->company(),
			'thumbnail' => $this->faker->fixturesImage('brands'),
			'on_home_page' => $this->faker->boolean(),
			'sorting' => $this->faker->numberBetween(0, 999),
		];
	}
}
