<?php

namespace Domains\Cart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
	use HasFactory;
	use MassPrunable;

	protected $fillable = [
		'storage_id',
		'user_id',
	];


	public function prunable(): Builder
	{
		return static::where('created_at', '<=', now()->subDay());
	}

	
	public function cartItems(): HasMany
	{
		return $this->hasMany(CartItem::class);
	}
}
