<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Middleware\CatalogViewMiddleware;
use Illuminate\Contracts\Routing\Registrar;


class CatalogRoutes implements RouteRegistrar
{
	public function map(Registrar $router): void
	{
		Route::middleware('web')->group(function() {

			Route::get('/catalog/{category:slug?}', CatalogController::class)
				->middleware([CatalogViewMiddleware::class])
				->name('catalog');
			
		});
	}
}
