<?php

namespace Domains\Catalog\ViewModels;

use Domains\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Supports\Traits\Makeable;

class CategoryViewModel
{
	use Makeable;


	public function homePage(): Collection|array
	{
		return Category::homePage()->get();
	}

}
