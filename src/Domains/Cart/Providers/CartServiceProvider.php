<?php

namespace Domains\Cart\Providers;

use Domains\Cart\CartManager;
use Domains\Cart\StorageIdentities\SessionIdentityStorage;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->register(ActionsServiceProvider::class);
	}

	public function boot(): void
	{
		$this->app->singleton(CartManager::class, function() {
			return new CartManager(new SessionIdentityStorage());
		});
	}
}
