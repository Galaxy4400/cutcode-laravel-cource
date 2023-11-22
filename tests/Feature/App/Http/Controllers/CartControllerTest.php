<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\CartController;
use Database\Factories\ProductFactory;
use Domains\Cart\CartManager;
use Domains\Cart\Models\CartItem;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class CartControllerTest extends TestCase
{
	use RefreshDatabase;


	public function setUp(): void
	{
		parent::setUp();

		CartManager::fake();
	}


	public function createCartItem(): CartItem
	{
		$product = ProductFactory::new()->createOne();

		cart()->add($product);

		return cart()->items()->first();
	}


	public function test_cart_is_empty(): void
	{
		$this->get(action([CartController::class, 'index']))
			->assertOk()
			->assertViewIs('cart.index')
			->assertViewHas('items', collect([]));
	}


	public function test_cart_is_not_empty(): void
	{
		$product = ProductFactory::new()->createOne();

		cart()->add($product);

		$this->get(action([CartController::class, 'index']))
			->assertOk()
			->assertViewIs('cart.index')
			->assertViewHas('items', cart()->items());
	}


	public function test_cart_added_success(): void
	{
		$product = ProductFactory::new()->createOne();

		$this->assertEquals(0, cart()->count());

		$this->post(action([CartController::class, 'add'], $product), ['quantity' => 2]);

		$this->assertEquals(2, cart()->count());
	}


	public function test_cart_quantity_success(): void
	{
		$cartItem = $this->createCartItem();

		$this->assertEquals(1, cart()->count());

		$this->post(action([CartController::class, 'quantity'], $cartItem), ['quantity' => 3]);

		$this->assertEquals(3, cart()->count());
	}


	public function test_cart_delete_success(): void
	{
		$cartItem = $this->createCartItem();

		$this->assertEquals(1, cart()->count());

		$this->delete(action([CartController::class, 'delete'], $cartItem));

		$this->assertEquals(0, cart()->count());
	}


	public function test_cart_truncate_success(): void
	{
		$this->createCartItem();

		$this->assertEquals(1, cart()->count());

		$this->delete(action([CartController::class, 'truncate']));

		$this->assertEquals(0, cart()->count());
	}

}


