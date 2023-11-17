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
		$testingProduct = ProductFactory::new()->createOne();

		$this->get(action(ProductController::class, $testingProduct))->assertOk();
	}

}
