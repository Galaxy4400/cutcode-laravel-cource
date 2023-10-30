<?php

namespace App\Providers;

use RuntimeException;
use Illuminate\Http\Request;
use App\Routing\AppRoutes;
use App\Contracts\RouteRegistrar;
use Domains\Auth\Routing\AuthRoutes;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
	/**
	 * The path to your application's "home" route.
	 *
	 * Typically, users are redirected here after authentication.
	 *
	 * @var string
	 */
	public const HOME = '/';


	protected array $registrars = [
		AppRoutes::class,
		AuthRoutes::class,
	];


	/**
	 * Define your route model bindings, pattern filters, and other route configuration.
	 */
	public function boot(): void
	{
		$this->configureRateLimiting();

		$this->routes(function(Registrar $router) {
			$this->mapRoutes($router, $this->registrars);
		});
	}


	public function configureRateLimiting()
	{
		RateLimiter::for('global', function (Request $request) {
			return Limit::perMinute(500)
				->by($request->user()?->id ?: $request->ip())
				->response(function (Request $request, array $headers) {
					return response('Take it easy', Response::HTTP_TOO_MANY_REQUESTS, $headers);
				});
		});

		RateLimiter::for('auth', function (Request $request) {
			return Limit::perMinute(3)->by($request->ip());
		});

		RateLimiter::for('api', function (Request $request) {
			return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
		});
	}


	protected function mapRoutes(Registrar $router, array $registrars): void
	{
		foreach ($registrars as $registrar) {
			if (!class_exists($registrar) || !is_subclass_of($registrar, RouteRegistrar::class)) {
				throw new RuntimeException(sprintf(
					'Cannot map routes \'%s\', it is not a valid routes class',
					$registrar
				));
			}

			(new $registrar)->map($router);
		}
	}
}
