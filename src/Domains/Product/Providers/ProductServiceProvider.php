<?php

namespace Domains\Product\Providers;


use Illuminate\Support\ServiceProvider;
use Domains\Product\Providers\ActionsServiceProvider;

class ProductServiceProvider extends ServiceProvider
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
