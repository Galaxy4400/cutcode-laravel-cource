<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	public function run(): void
	{
		BrandFactory::new()->count(20)->create();

		$categories = CategoryFactory::new()->count(5)->create();

		Product::factory(20)
			->create()
			->each(
				fn (Product $product) => $product
					->categories()
					->sync($categories->random(rand(1, 5)))
			);
	}
}
