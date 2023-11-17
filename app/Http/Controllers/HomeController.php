<?php

namespace App\Http\Controllers;

use Domains\Product\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Domains\Catalog\ViewModels\BrandViewModel;
use Domains\Catalog\ViewModels\CategoryViewModel;


class HomeController extends Controller
{
	public function __invoke(): View|Factory
	{
		$products = Product::homePage()->get();
		
		return view('index', [
			'categories' => CategoryViewModel::make()->homePage(),
			'brands' => BrandViewModel::make()->homePage(),
			'products' => $products,
		]);
	}
}
