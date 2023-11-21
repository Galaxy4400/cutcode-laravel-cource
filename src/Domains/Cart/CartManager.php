<?php

namespace Domains\Cart;

use Domains\Cart\Models\Cart;
use Domains\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Domains\Cart\Contracts\CartIdentityStorageContract;
use Domains\Cart\Models\CartItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Supports\ValueObjects\Price;

class CartManager
{
	public function __construct(
		protected CartIdentityStorageContract $identityStorage,
	) {
	}


	private function cacheKey(): string
	{
		return str('cart_'.$this->identityStorage->get())
			->slug('_')
			->value();
	}


	private function forgetCache(): void
	{
		Cache::forget($this->cacheKey());
	}


	private function storedData(string $storageId): array
	{
		$data = [
			'storage_id' => $storageId,
		];

		if (auth()->check()) {
			$data['user_id'] = auth()->id();
		}

		return $data;
	}


	private function stringedOptionValues(array $optionValues = []): string
	{
		sort($optionValues);

		return implode(';', $optionValues);
	}


	public function add(Product $product, int $quantity = 1, array $optionValues = []): Model|Builder
	{
		$cart = Cart::query()
			->updateOrCreate([
				'storage_id' => $this->identityStorage->get(),
			], $this->storedData($this->identityStorage->get())
		);

		$cartItem = $cart->cartItems()->updateOrCreate([
			'product_id' => $product->getKey(),
			'options' => $this->stringedOptionValues($optionValues),
		], [
			'price' => $product->price,
			'quantity' => DB::raw("quantity + {$quantity}"),
			'options' => $this->stringedOptionValues($optionValues),
		]);

		$cartItem->optionValues()->sync($optionValues);

		$this->forgetCache();

		return $cart;
	}


	public function quantity(CartItem $item, int $quantity = 1): void
	{
		$item->update(['quantity' => $quantity]);

		$this->forgetCache();
	}


	public function delete(CartItem $item): void
	{
		$item->delete();

		$this->forgetCache();
	}


	public function truncate(): void
	{
		$this->get()?->delete();

		$this->forgetCache();
	}


	public function items(): Collection
	{
		if (!$this->get()) {
			return collect([]);
		}

		return CartItem::query()
			->with(['product', 'optionValues.option'])
			->whereBelongsTo($this->get())
			->get();
	}


	public function cartItems(): Collection
	{
		return $this->get()?->cartItems ?? collect([]);
	}


	public function count(): int
	{
		return $this->cartItems()->sum(fn($item) => $item->quantity);
	}


	public function total(): Price
	{
		return Price::make(
			$this->cartItems()->sum(fn($item) => $item->amount->raw())
		);
	}


	public function get(): Model|Builder|false
	{
		return Cache::remember($this->cacheKey(), now()->addHour(), function () {
			return Cart::query()
			->with('cartItems')
			->where('storage_id', $this->identityStorage->get())
			->when(auth()->check(), fn(Builder $query) => $query->orWhere('user_id', auth()->id()))
			->first() ?? false;
		});
	}

}
