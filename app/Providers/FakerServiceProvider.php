<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Faker\FakerImageProvider;
use Faker\Factory;
use Faker\Generator;

class FakerServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 */
	public function register(): void
	{
		$this->app->singleton(Generator::class, function () {
			$faker = Factory::create();
			$faker->addProvider(new FakerImageProvider($faker));
			return $faker;
		});
	}

}
