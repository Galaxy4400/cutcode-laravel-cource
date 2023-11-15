<?php

namespace App\Providers;

use App\Filters\BrandFilter;
use App\Filters\PriceFilter;
use Domains\Catalog\Filters\FilterManager;
use Domains\Catalog\Sorters\Sorter;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 */
	public function register(): void
	{
		$this->app->singleton(FilterManager::class);
	}

	/**
	 * Bootstrap services.
	 */
	public function boot(): void
	{
		app(FilterManager::class)->registerFilters([
			new PriceFilter(),
			new BrandFilter(),
		]);


		$this->app->bind(Sorter::class, function () {
			return new Sorter(['title', 'price']);
		});
	}
}
