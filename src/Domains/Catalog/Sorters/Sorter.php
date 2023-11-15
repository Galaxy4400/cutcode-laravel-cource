<?php

namespace Domains\Catalog\Sorters;

use Illuminate\Support\Stringable;
use Illuminate\Database\Eloquent\Builder;

final class Sorter
{
	public const SORT_KEY ='sort';


	public function __construct(
		protected array $columns = [],
	){}


	public function run(Builder $query): Builder
	{
		$sortData = $this->sortData();

		$query->when($sortData->contains($this->columns()), function (Builder $query) use ($sortData) {
			$query->orderBy(
				(string) $sortData->remove('-'),
				$sortData->contains('-') ? 'DESC' : 'ASC',
			);
		});

		return $query;
	}


	public function key(): string
	{
		return self::SORT_KEY;
	}


	public function columns(): array
	{
		return $this->columns;
	}


	public function sortData(): Stringable
	{
		return request()->str($this->key());
	}


	public function isActive(string $column, string $direction = 'ASC'): bool
	{
		$column = trim($column, '-');

		if (strtoupper($direction) === 'DESC') {
			$column = "-{$column}";
		}

		return request($this->key()) === $column;
	}
	
}
