<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
	use HasFactory;
	use HasSlug;

	protected $fillable = [
		'slug',
		'title',
		'brand_id',
		'price',
		'thumbnail',
	];


	/**
	 * @return BelongsTo
	 */
	public function brand(): BelongsTo
	{
		return $this->belongsTo(Brand::class);
	}


	/**
	 * @return BelongsToMany
	 */
	public function categories(): BelongsToMany
	{
		return $this->belongsToMany(Category::class);
	}
}
