<?php

namespace App\Filters;

use Domains\Catalog\Filters\AbstractFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PriceFilter extends AbstractFilter
{
	public function title(): string
	{
		return 'Цена';
	}
	

	public function key(): string
	{
		return 'price';
	}
	

	public function apply($query): Builder
	{
		return $query->when($this->requestValue(), function ($query) {
			$query->whereBetween('price', [
				$this->requestValue('form', 0) * 100,
				$this->requestValue('to', 100000) * 100,
			]);
		});
	}


	public function values(): array
	{
		return [
			'from' => 0,
			'to' => 100000,
		];
	}

	
	public function view(): string
	{
		return 'catalog.filters.price';
	}
}
