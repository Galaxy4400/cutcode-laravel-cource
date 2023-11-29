<?php

namespace Domains\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PaymentMethod extends Model
{
	use HasFactory;

	protected $fillable = [
		'title',
		'redirect_to_pay',
	];

}
