<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Domains\Catalog\Models\Category;
use Illuminate\Contracts\View\Factory;

class CatalogController extends Controller
{
	public function __invoke(?Category $category): View|Factory
	{
		$categories = Category::query()
			->select(['id', 'title', 'slug'])
			->has('products')
			->get();
			
		$products = Product::query()
			->select(['id', 'brand_id', 'title', 'slug', 'price', 'thumbnail', 'json_properties'])
			->ofCategory($category)
			->searched()
			->filtered()
			->sorted()
			->paginate(6);

		return view('catalog.index', compact('categories', 'products', 'category'));

	}
}
