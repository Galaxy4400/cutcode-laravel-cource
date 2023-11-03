<?php

namespace Domains\Catalog\Providers;


use Illuminate\Support\ServiceProvider;
use Domains\Catalog\Providers\ActionsServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{

	
	public function register(): void
	{
		$this->app->register(ActionsServiceProvider::class);
	}


	public function boot(): void
	{
		//
	}
}
