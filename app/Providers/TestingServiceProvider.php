<?php

namespace App\Providers;

use Faker\Generator;
use Illuminate\Support\ServiceProvider;
use Supports\Faker\Providers\FakerImageProvider;

class TestingServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 */
	public function register(): void
	{
		$this->app->afterResolving(Generator::class, function (Generator $faker) {
			$faker->addProvider(new FakerImageProvider($faker));
		});
	}

}
