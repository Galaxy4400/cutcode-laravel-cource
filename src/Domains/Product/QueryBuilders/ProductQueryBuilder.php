<?php

namespace Domains\Product\QueryBuilders;

use Illuminate\Pipeline\Pipeline;
use Domains\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class ProductQueryBuilder extends Builder
{

	public function homePage(): ProductQueryBuilder
	{
		return $this->where('on_home_page', true)
			->orderBy('sorting')
			->limit(6);
	}


	public function filtered(): ProductQueryBuilder
	{
		return app(Pipeline::class)
			->send($this)
			->through(filters())
			->thenReturn();
	}


	public function sorted(): ProductQueryBuilder
	{
		return sorter()->run($this);
	}


	public function searched(): ProductQueryBuilder
	{
		$this->when(request('search'), function ($query) {
			$query->whereFullText(['title', 'text'], request('search'));
		});

		return $this;
	}


	public function seen(int $except = null): ProductQueryBuilder
	{
		$also = session()->get('seen') ?: [];

		$this->whereIn('id', $also)
			->when($except, function () use ($except) {
				return $this->where('id', '!=', $except);
			})
			->inRandomOrder()
			->limit(4);

		return $this;
	}

	// TODO Изоляция категорий через конфиги
	public function ofCategory(Category $category): ProductQueryBuilder
	{
		$this->when($category->exists, function ($query) use ($category) {
			$query->whereRelation('categories', 'categories.id', $category->id);
		});

		return $this;
	}

}
