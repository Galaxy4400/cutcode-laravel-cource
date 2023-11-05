<?php

namespace App\Http\Controllers;

use Domains\Catalog\Models\Brand;
use App\Models\Product;
use Domains\Catalog\ViewModels\CategoryViewModel;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;


class HomeController extends Controller
{
	public function __invoke(): View|Factory
	{
		$categories = CategoryViewModel::make()->homePage();
		
		$products = Product::homePage()->get();
		
		$brands = Brand::homePage()->get();

		return view('index', compact('categories', 'products', 'brands'));
	}
}
