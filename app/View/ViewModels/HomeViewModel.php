<?php

namespace App\View\ViewModels;

use Supports\Traits\Makeable;
use Spatie\ViewModels\ViewModel;
use Domains\Catalog\Models\Brand;
use Domains\Product\Models\Product;
use Domains\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Collection;


/**
 * @method static static make()
 */
class HomeViewModel extends ViewModel
{
	use Makeable;


	public function products(): Collection
	{
		return Product::homePage()->get();
	}
	

	public function categories(): Collection
	{
		return Category::homePage()->get();
	}


	public function brands(): Collection
	{
		return Brand::homePage()->get();
	}
}
