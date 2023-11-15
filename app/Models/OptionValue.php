<?php

namespace App\Models;

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

	
	public function option(): BelongsTo
	{
		return $this->belongsTo(Option::class);
	}
}
