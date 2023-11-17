<?php

namespace Domains\Product\Models;

use Domains\Product\Collections\OptionValueCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OptionValue extends Model
{
	use HasFactory;

	protected $fillable = [
		'title',
		'option_id',
	];


	public function newCollection(array $models = [])
	{
		return new OptionValueCollection($models);
	}

	
	public function option(): BelongsTo
	{
		return $this->belongsTo(Option::class);
	}
}
