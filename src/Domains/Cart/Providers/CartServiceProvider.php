<?php

namespace Domains\Cart\Providers;

use Domains\Cart\CartManager;
use Domains\Cart\Contracts\CartIdentityStorageContract;
use Domains\Cart\StorageIdentities\SessionIdentityStorage;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->register(ActionsServiceProvider::class);

		$this->app->bind(CartIdentityStorageContract::class, SessionIdentityStorage::class);

		$this->app->singleton(CartManager::class);
	}

	public function boot(): void
	{
	}
}
