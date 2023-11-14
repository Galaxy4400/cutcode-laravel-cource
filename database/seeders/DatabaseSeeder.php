<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\PropertyFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	public function run(): void
	{
		BrandFactory::new()->count(20)->create();

		OptionFactory::new()->count(2)->create();

		$categories = CategoryFactory::new()->count(5)->create();

		$properties = PropertyFactory::new()->count(10)->create();

		$optionValues = OptionValueFactory::new()->count(10)->create();


		Product::factory(20)
			->hasAttached($optionValues)
			->hasAttached($properties, function () {
				return ['value' => ucfirst(fake()->word())];
			})
			->create()
			->each(
				fn (Product $product) => $product
					->categories()
					->sync($categories->random(rand(1, 5)))
			);
	}
}
