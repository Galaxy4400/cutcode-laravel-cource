<?php

namespace Database\Factories;

use Domains\Product\Models\Option;
use Domains\Product\Models\OptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OptionValue>
 */
class OptionValueFactory extends Factory
{
	protected $model = OptionValue::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'title' => ucfirst($this->faker->word()),
			'option_id' => Option::inRandomOrder()->value('id'),
		];
	}
}
