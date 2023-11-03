<?php

namespace App\Providers;

use Domains\Auth\Providers\AuthServiceProvider;
use Domains\Catalog\Providers\CatalogServiceProvider;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 */
	public function register(): void
	{
		$this->app->register(AuthServiceProvider::class);
		$this->app->register(CatalogServiceProvider::class);
	}

}
