<?php

namespace Domains\Auth\Providers;


// use Illuminate\Support\Facades\Gate;
use Domains\Auth\Providers\ActionsServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The model to policy mappings for the application.
	 *
	 * @var array<class-string, class-string>
	 */
	protected $policies = [
		//
	];


	public function register(): void
	{
		$this->app->register(ActionsServiceProvider::class);
	}


	public function boot(): void
	{
		//
	}
}
