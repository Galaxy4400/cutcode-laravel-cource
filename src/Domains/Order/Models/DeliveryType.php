<?php

namespace Domains\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Supports\Casts\PriceCast;

class DeliveryType extends Model
{
	use HasFactory;


	protected $fillable = [
		'title',
		'price',
		'with_address',
	];


	protected $casts = [
		'prece' => PriceCast::class,
	];

	
}
