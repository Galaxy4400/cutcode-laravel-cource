<?php

namespace Domains\Order\Models;

use Domains\Auth\Models\User;
use Domains\Order\Enums\OrderStatuses;
use Supports\Casts\PriceCast;
use Domains\Order\Models\OrderItem;
use Domains\Order\Models\DeliveryType;
use Domains\Order\Models\OrderCustomer;
use Domains\Order\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
	use HasFactory;

	protected $fillable = [
		'user_id',
		'delivery_type_id',
		'payment_method_id',
		'amount',
		'status',
	];


	protected $casts = [
		'amount' => PriceCast::class,
	];


	protected $attributes = [
		'status' => 'new',
	];


	public function status(): Attribute
	{
		return Attribute::make(
			get: fn(string $value) => OrderStatuses::from($value)->createState($this),
		);
	}


	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}


	public function deliverytype(): BelongsTo
	{
		return $this->belongsTo(DeliveryType::class);
	}


	public function paymentMethod(): BelongsTo
	{
		return $this->belongsTo(PaymentMethod::class);
	}


	public function orderCustomer(): HasOne
	{
		return $this->hasOne(OrderCustomer::class);
	}


	public function orderItems(): HasMany
	{
		return $this->hasMany(OrderItem::class);
	}

}
