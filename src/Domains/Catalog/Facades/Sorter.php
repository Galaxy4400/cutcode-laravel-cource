<?php

namespace Domains\Catalog\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static Builder run(Builder $query)
 * 
 * @see \Domains\Catalog\Sorters\Sorter
 */
class Sorter extends Facade
{
	public static function getFacadeAccessor(): string
	{
		return \Domains\Catalog\Sorters\Sorter::class;
	}
}
