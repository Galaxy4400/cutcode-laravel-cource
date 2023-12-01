<?php

namespace Domains\Order\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	use HasFactory;
	use HasUuids;

	protected $fillable = [
		'payment_id',
		'payment_gateway',
		'meta',
	];

	public function uniqueIds()
	{
		return ['payment_id'];
	}
}
