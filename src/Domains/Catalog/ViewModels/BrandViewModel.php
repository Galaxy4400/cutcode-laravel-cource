<?php

namespace Domains\Catalog\ViewModels;

use Domains\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Collection;
use Supports\Traits\Makeable;

class BrandViewModel
{
	use Makeable;


	public function homePage(): Collection|array
	{
		return Brand::homePage()->get();
	}

}
