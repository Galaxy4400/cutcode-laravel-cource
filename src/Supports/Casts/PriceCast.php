<?php

namespace Supports\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Supports\ValueObjects\Price;

class PriceCast implements CastsAttributes
{
	/**
	 * Cast the given value.
	 *
	 * @param  array<string, mixed>  $attributes
	 */
	public function get(Model $model, string $key, mixed $value, array $attributes): Price
	{
		return Price::make($value);
	}

	/**
	 * Prepare the given value for storage.
	 *
	 * @param  array<string, mixed>  $attributes
	 */
	public function set(Model $model, string $key, mixed $value, array $attributes): int
	{
		if (!$value instanceof Price) {
			$value = Price::make($value);
		}

		return $value->raw();
	}
}
