<?php

namespace App\Filters;

use Domains\Catalog\Models\Brand;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;
use Domains\Catalog\Filters\AbstractFilter;

class BrandFilter extends AbstractFilter
{
	public function title(): string
	{
		return 'Бренды';
	}

	public function key(): string
	{
		return 'brands';
	}
	
	public function apply(Builder $query): Builder
	{
		return $query->when($this->requestValue(), function(Builder $query) {
			$query->whereIn('brand_id', $this->requestValue());
		});
	}

	public function values(): array
	{
		return Cache::rememberForever('brands_filter', function () {
			return Brand::query()
				->select(['id', 'title'])
				->has('products')
				->get()
				->pluck('title', 'id')
				->toArray();
		});
	}

	public function view(): string
	{
		return 'catalog.filters.brands';
	}
}
