<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\CatalogController;
use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class CatalogControllerTest extends TestCase
{
	use RefreshDatabase;


	public function test_price_response_filtered_success(): void
	{
		$products = ProductFactory::new()
			->count(3)
			->create(['price' => 200]);

		$expectedProduct = ProductFactory::new()
			->createOne(['price' => 100000]);

		$request = [
			'filters' => [
				'price' => ['min' => 999, 'max' => 1001],
			],
		];

		$this->get(action([CatalogController::class], $request))
			->assertOk()
			->assertSee($expectedProduct->title)
			->assertDontSee($products->random()->title);
	}


	public function test_brand_response_filtered_success(): void
	{
		$products = ProductFactory::new()
			->count(3)
			->create();

		$brand = BrandFactory::new()->create();

		$expectedProduct = ProductFactory::new()
			->createOne(['brand_id' => $brand->id]);

		$request = [
			'filters' => [
				'brands' => [$brand->id => $brand->id],
			],
		];

		$this->get(action([CatalogController::class], $request))
			->assertOk()
			->assertSee($expectedProduct->title)
			->assertDontSee($products->random()->title);
	}


	public function test_sorted_response_success(): void
	{
		$products = ProductFactory::new()
			->count(3)
			->create();

		$request = [
			'sort' => 'title',
		];

		$this->get(action([CatalogController::class], $request))
			->assertOk()
			->assertSeeInOrder(
				$products->sortBy('title')
					->flatMap(fn($item) => [$item->title])
					->toArray()
			);
	}
}
