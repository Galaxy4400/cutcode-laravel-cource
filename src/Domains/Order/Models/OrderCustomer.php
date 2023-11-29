<?php

namespace Domains\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class OrderCustomer extends Model
{
	use HasFactory;

	protected $fillable = [
		'order_id',
		'first_name',
		'last_name',
		'email',
		'phone',
		'address',
		'city',
	];

}
