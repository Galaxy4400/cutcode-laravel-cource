<?php

namespace Tests\Feature\App\Jobs;

use App\Jobs\ProductJsonProperties;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;


class ProductJsonPropertiesTest extends TestCase
{
	use RefreshDatabase;

	public function test_created_json_properties_success(): void
	{
		$queue = Queue::getFacadeRoot();

		Queue::fake([ProductJsonProperties::class]);

		$properties = PropertyFactory::new()->count(10)->create();

		$product = ProductFactory::new()
			->hasAttached($properties, fn() => ['value' => fake()->word()])
			->create();

		$this->assertEmpty($product->json_properties);

		Queue::swap($queue);

		ProductJsonProperties::dispatchSync($product);

		$product->refresh();

		$this->assertNotEmpty($product->json_properties);
	}
}
