<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;

class ProductController extends Controller
{
	public function __invoke(Product $product): View|Factory
	{
		$product->load('optionValues.option');

		$also = Product::also($product->id)->get();

		$options = $product->optionValues->mapToGroups(function ($item) {
			return [$item->option->title => $item];
		});

		session()->put('also.' . $product->id, $product->id);

		return view('product.show', compact('product', 'options', 'also'));
	}
}
