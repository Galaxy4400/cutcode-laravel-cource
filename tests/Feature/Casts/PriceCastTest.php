<?php

namespace Tests\Feature\Casts;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Supports\ValueObjects\Price;
use Tests\TestCase;

class PriceCastTest extends TestCase
{
	use RefreshDatabase;

	public Model $model;


	protected function setUp(): void
	{
		parent::setUp();

		$this->model = ProductFactory::new()->create([
			'price' => 10000,
		]);
	}

	
	public function test_get_success(): void
	{
		$this->assertInstanceOf(Price::class, $this->model->price);
	}

	
	public function test_set_success(): void
	{
		$this->expectNotToPerformAssertions();

		$this->model->price = Price::make(99999);
	}

	
	public function test_set_fail(): void
	{
		$this->expectException(InvalidArgumentException::class);
		$this->model->price = -100;
		
		$this->expectExceptionMessageMatches('must be of type int, string given');
		$this->model->price = 'sdfsd';
	}
}
