<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Faker\FakerImageProvider;
use Faker\Generator;

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
