<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Domains\Auth\Providers\AuthServiceProvider;
use Domains\Cart\Providers\CartServiceProvider;
use Domains\Order\Providers\OrderServiceProvider;
use Domains\Catalog\Providers\CatalogServiceProvider;
use Domains\Product\Providers\ProductServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 */
	public function register(): void
	{
		$this->app->register(AuthServiceProvider::class);
		$this->app->register(CatalogServiceProvider::class);
		$this->app->register(ProductServiceProvider::class);
		$this->app->register(CartServiceProvider::class);
		$this->app->register(OrderServiceProvider::class);
	}

}
