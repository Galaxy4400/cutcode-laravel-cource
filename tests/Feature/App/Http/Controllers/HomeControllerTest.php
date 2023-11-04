<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Database\Factories\CategoryFactory;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Testing\RefreshDatabase;


class HomeControllerTest extends TestCase
{
	use RefreshDatabase;


	public function test_home_page_success(): void
	{
		Storage::fake();

		CategoryFactory::new()->count(5)
			->create([
				'on_home_page' => true,
				'sorting' => 999,
			]);

		$category = CategoryFactory::new()
			->createOne([
				'on_home_page' => true,
				'sorting' => 1,
			]);

			
		ProductFactory::new()->count(5)
			->create([
				'on_home_page' => true,
				'sorting' => 999,
			]);

		$product = ProductFactory::new()
			->createOne([
				'on_home_page' => true,
				'sorting' => 1,
			]);


		BrandFactory::new()->count(5)
			->create([
				'on_home_page' => true,
				'sorting' => 999,
			]);

		$brand = BrandFactory::new()
			->createOne([
				'on_home_page' => true,
				'sorting' => 1,
			]);


		$this->get(action([HomeController::class]))
			->assertOk()
			->assertViewHas('categories.0', $category)
			->assertViewHas('products.0', $product)
			->assertViewHas('brands.0', $brand);
	}
}
