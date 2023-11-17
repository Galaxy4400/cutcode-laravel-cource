<?php

namespace App\View\ViewModels;

use Domains\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Supports\Traits\Makeable;
use Spatie\ViewModels\ViewModel;


/**
 * @method static static make($product)
 */
class ProductViewModel extends ViewModel
{
	use Makeable;

	public Product $product;


	public function __construct(Product $product)
	{
		$this->product = $product->load('optionValues.option');
	}


	public function options(): SupportCollection
	{
		return $this->product->optionValues->keyValues();
	}


	public function seen(): Collection
	{
		return Product::seen($this->product->id)->get();
	}
}
