<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\ProductController;
use Database\Factories\ProductFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ProductControllerTest extends TestCase
{
	use RefreshDatabase;


	public function test_product_response_success(): void
	{
		$alsoProduct = ProductFactory::new()->createOne();
		$testingProduct = ProductFactory::new()->createOne();

		session()->put('also.'.$alsoProduct->id, $alsoProduct->id);
		session()->put('also.'.$testingProduct->id, $testingProduct->id);

		$this->get(action(ProductController::class, $testingProduct))
			->assertOk()
			->assertSee($alsoProduct->title);
	}

}
