<?php

namespace App\Http\Controllers;

use Domains\Product\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;

class ProductController extends Controller
{
	public function __invoke(Product $product): View|Factory
	{
		session()->put('also.' . $product->id, $product->id);

		$product->load('optionValues.option');

		return view('product.show', [
			'product' => $product,
			'options' => $product->optionValues->keyValues(),
			'also' => Product::also($product->id)->get()
		]);
	}
}
