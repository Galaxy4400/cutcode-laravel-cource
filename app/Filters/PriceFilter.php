<?php

namespace App\Filters;

use Domains\Product\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;
use Domains\Catalog\Filters\AbstractFilter;

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
	

	public function apply(Builder $query): Builder
	{
		return $query->when($this->requestValue(), function (Builder $query) {
			$query->whereBetween('price', [
				$this->requestValue('min', $this->values()['min']) * 100,
				$this->requestValue('max', $this->values()['max']) * 100,
			]);
		});
	}


	public function values(): array
	{
		return Cache::rememberForever('min_max_price', function () {
			return [
				'min' => Product::min('price') / 100,
				'max' => Product::max('price') / 100,
			];
		});
	}

	
	public function view(): string
	{
		return 'catalog.filters.price';
	}
	
}
