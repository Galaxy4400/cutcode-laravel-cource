<?php

namespace Domains\Auth\Providers;

use Domains\Auth\Actions\RegisterNewUserAction;
use Domains\Auth\Contracts\RegisterNewUserContract;
use Illuminate\Support\ServiceProvider;


class ActionsServiceProvider extends ServiceProvider
{
	public array $bindings = [
		RegisterNewUserContract::class => RegisterNewUserAction::class,
	];
}
