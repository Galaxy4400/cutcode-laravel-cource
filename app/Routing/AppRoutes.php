<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Contracts\Routing\Registrar;


class AppRoutes implements RouteRegistrar
{
	public function map(Registrar $router): void
	{
		Route::middleware('web')->group(function() {
			Route::get('/', HomeController::class)->name('home');
		});
	}
}
