<?php

namespace Domains\Cart\Models;

use Domains\Cart\Models\Cart;
use Supports\Casts\PriceCast;
use Supports\ValueObjects\Price;
use Domains\Product\Models\Product;
use Domains\Product\Models\OptionValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CartItem extends Model
{
	use HasFactory;

	protected $fillable = [
		'cart_id',
		'product_id',
		'price',
		'quantity',
		'options',
	];

	protected $casts = [
		'price' => PriceCast::class,
	];


	public function amount(): Attribute
	{
		return Attribute::make(
			get: fn() => Price::make(
				$this->price->raw() * $this->quantity
			)
		);
	}


	public function cart(): BelongsTo
	{
		return $this->belongsTo(Cart::class);
	}


	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class);
	}


	public function optionValues(): BelongsToMany
	{
		return $this->belongsToMany(OptionValue::class);
	}
}
