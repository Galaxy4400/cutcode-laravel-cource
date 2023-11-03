<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Domains\Catalog\Models\Brand;
use Domains\Catalog\Models\Category;

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
