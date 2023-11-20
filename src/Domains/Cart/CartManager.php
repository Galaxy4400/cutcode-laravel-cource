<?php

namespace Domains\Cart;

use Domains\Cart\Models\Cart;
use Domains\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Domains\Cart\Contracts\CartIdentityStorageContract;

class CartManager
{
	public function __construct(
		protected CartIdentityStorageContract $identityStorage,
	) {
	}


	private function storedData(string $id): array
	{
		$data = [
			'storage_id' => $id,
		];

		if (auth()->check()) {
			$data['user_id'] = auth()->id();
		}

		return $data;
	}


	public function add(Product $product, int $quantity = 1, array $optionValues = []): Model|Builder
	{
		$cart = Cart::query()
			->updateOrCreate([
				'storage_id' => $this->identityStorage->get(),
			], $this->storedData($this->identityStorage->get()));

		// $cartItem = $cart->cartItems()->updateOrCreate()

		return $cart;
	}
}
