<?php

namespace Domains\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
	use HasFactory;

	protected $fillable = [
		'payment_gatewey',
		'method',
		'payload',
	];

	protected $casts = [
		'payload' => 'collection',
	];

}
