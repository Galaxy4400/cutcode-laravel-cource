<?php

use Supports\Flash\Flash;

if (!function_exists('flash')) {
	function flash(): Flash
	{
		return app(Flash::class);
	}
}