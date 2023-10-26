<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	public function run(): void
	{
		Brand::factory(20)->create();

		$categories = Category::factory(5)->create();

		Product::factory(20)
			->create()
			->each(
				fn (Product $product) => $product
					->categories()
					->sync($categories->random(rand(1, 5)))
			);
	}
}
