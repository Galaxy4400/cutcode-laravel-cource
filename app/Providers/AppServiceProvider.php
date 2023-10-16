<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Events\QueryExecuted;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		//
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		Model::preventLazyLoading(!app()->isProduction());
		Model::preventSilentlyDiscardingAttributes(!app()->isProduction());

		DB::whenQueryingForLongerThan(
			CarbonInterval::millisecond(500),
			function (Connection $connection) {
				logger()->channel('telegram')->debug('whenQueryingForLongerThan: ' . $connection->query()->toSql());
			}
		);

		$kernel = app(Kernel::class);

		$kernel->whenRequestLifecycleIsLongerThan(
			CarbonInterval::seconds(4), 
			function () {
				logger()->channel('telegram')->debug('whenRequestLifecycleIsLongerThan: ' . request()->url());
			}
		);
	}
}
