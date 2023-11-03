<?php

namespace App\Http\Controllers;

use Domains\Catalog\Models\Brand;
use App\Models\Product;
use Domains\Catalog\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;


class HomeController extends Controller
{
	public function __invoke(): View|Factory
	{
		$categories = Category::homePage()->get();
		
		$products = Product::homePage()->get();
		
		$brands = Brand::homePage()->get();

		return view('index', compact('categories', 'products', 'brands'));
	}
}
