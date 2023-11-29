<?php

namespace App\Exceptions;

use DomainException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
	/**
	 * The list of the inputs that are never flashed to the session on validation exceptions.
	 *
	 * @var array<int, string>
	 */
	protected $dontFlash = [
		'current_password',
		'password',
		'password_confirmation',
	];

	/**
	 * Register the exception handling callbacks for the application.
	 */
	public function register(): void
	{
		$this->reportable(function (Throwable $e) {
			if (app()->bound('sentry')) {
				app('sentry')->captureException($e);
			}
		});


		$this->renderable(function (DomainException $e) {
			flash()->alert($e->getMessage());

			return session()->previousUrl()
				? back()
				: redirect()->route('home');
		});
	}
}
