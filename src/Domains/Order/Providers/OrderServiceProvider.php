<?php

namespace Domains\Order\Providers;

use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->app->register(ActionsServiceProvider::class);
		$this->app->register(PaymentServiceProvider::class);
	}

	public function boot(): void
	{

	}
}
