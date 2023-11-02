<?php

namespace Supports\Traits;

trait Makeable
{
	public static function make(mixed ...$arguments): static
	{
		return new static(...$arguments);
	}
}
