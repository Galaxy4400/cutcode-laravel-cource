<?php

namespace App\Providers;

use Domains\Auth\Providers\AuthServiceProvider;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 */
	public function register(): void
	{
		$this->app->register(AuthServiceProvider::class);
	}

}
