<?php

namespace App\Providers;

use Faker\Generator;
use Illuminate\Support\ServiceProvider;
use Services\Telegram\TelegramBotApi;
use Services\Telegram\TelegramBotApiContract;
use Supports\Faker\Providers\FakerImageProvider;

class TestingServiceProvider extends ServiceProvider
{
	
	public array $bindings = [
		TelegramBotApiContract::class => TelegramBotApi::class,
	];


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
