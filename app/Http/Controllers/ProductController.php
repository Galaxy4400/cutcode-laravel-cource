<?php

namespace App\Http\Controllers;

use App\View\ViewModels\ProductViewModel;
use Domains\Product\Models\Product;


class ProductController extends Controller
{
	public function __invoke(Product $product): ProductViewModel
	{
		return ProductViewModel::make($product)->view('product.show');
	}
}
