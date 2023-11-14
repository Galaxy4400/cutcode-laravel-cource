<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Contracts\Routing\Registrar;


class ProductRoutes implements RouteRegistrar
{
	public function map(Registrar $router): void
	{
		Route::middleware('web')->group(function() {

			Route::get('/product/{product:slug}', ProductController::class)->name('product');

		});
	}
}
