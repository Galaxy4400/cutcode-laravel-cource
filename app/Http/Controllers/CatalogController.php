<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domains\Catalog\Models\Brand;
use Illuminate\Contracts\View\View;
use Domains\Catalog\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\Factory;


class CatalogController extends Controller
{
	public function __invoke(?Category $category): View|Factory
	{
		$brands = Brand::query()
			->select(['id', 'title'])
			->has('products')
			->get();
			
		$categories = Category::query()
			->select(['id', 'title', 'slug'])
			->has('products')
			->get();
			
		$products = Product::query()
			->select(['id', 'title', 'slug', 'price', 'thumbnail'])
			->when($category->exists, function (Builder $query) use ($category) {
				$query->whereRelation('categories', 'categories.id', '=', $category->id);
			})
			->filtered()
			->sorted()
			->paginate(6);

		return view('catalog.index', compact('brands', 'categories', 'products', 'category'));

	}
}