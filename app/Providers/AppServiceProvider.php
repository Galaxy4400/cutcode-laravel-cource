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
	public function boot(): void
	{
		Model::shouldBeStrict(!app()->isProduction());

		if (app()->isProduction()) {
			
			DB::listen(function ($query) {
				if ($query->time > 500) {
					logger()->channel('telegram')->debug('Query longer than 5ms: ' . $query->time . ' - ' . $query->sql);
				}
			});
	
			app(Kernel::class)->whenRequestLifecycleIsLongerThan(CarbonInterval::seconds(4), function () {
				logger()->channel('telegram')->debug('whenRequestLifecycleIsLongerThan: ' . request()->url());
			});
		}
	}
	
}
