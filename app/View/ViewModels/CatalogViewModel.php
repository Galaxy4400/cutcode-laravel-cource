<?php

namespace App\View\ViewModels;

use Spatie\ViewModels\ViewModel;
use Domains\Product\Models\Product;
use Domains\Catalog\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Supports\Traits\Makeable;


/**
 * @method static static make($category)
 */
class CatalogViewModel extends ViewModel
{
	use Makeable;

	public function __construct(
		public Category $category,
	) {
	}

	public function categories(): Collection
	{
		return Category::query()
			->select(['id', 'title', 'slug'])
			->has('products')
			->get();
	}

	public function products(): LengthAwarePaginator
	{
		return Product::query()
			->select(['id', 'brand_id', 'title', 'slug', 'price', 'thumbnail', 'json_properties'])
			->ofCategory($this->category)
			->searched()
			->filtered()
			->sorted()
			->paginate(6);
	}
}
