<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use Database\Factories\BrandFactory;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ProductControllerTest extends TestCase
{
	use RefreshDatabase;


	public function test_product_response_success(): void
	{
		$propertyName = 'Property name';
		$propertyValueName = 'Property value';
		$optionName = 'Option name';
		$optionValueName = 'Option value';

		$option = OptionFactory::new()->createOne(['title' => $optionName]);
		$optionValue = OptionValueFactory::new()->createOne(['title' => $optionValueName]);

		$property = PropertyFactory::new()->createOne(['title' => $propertyName]);

		$product = ProductFactory::new()->createOne();
		
		$product->properties()->attach($property->id, ['value' => $propertyValueName]);
		$product->optionValues()->attach($optionValue->id);

		$this->get(action(ProductController::class, $product))
			->assertOk()
			->assertSee([$propertyName, $propertyValueName, $optionName, $optionValueName]);
	}

}
