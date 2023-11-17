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
		return $this->when(request('search'), fn() =>
			$this->whereFullText(['title', 'text'], request('search'))
		);
	}


	public function seen(int $except = null): ProductQueryBuilder
	{
		return $this->whereIn('id', session()->get('seen', []))
			->when($except, fn() =>
				$this->where('id', '!=', $except)
			);
	}

	// TODO Изоляция категорий через конфиги
	public function ofCategory(Category $category): ProductQueryBuilder
	{
		return $this->when($category->exists, fn() => 
			$this->whereRelation('categories', 'categories.id', $category->id)
		);
	}

}
