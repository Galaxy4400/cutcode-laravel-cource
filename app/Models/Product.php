<?php

namespace App\Models;

use Supports\Casts\PriceCast;
use Supports\Traits\Models\HasSlug;
use Domains\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Supports\Traits\Models\HasThumbnail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
	use HasFactory;
	use HasSlug;
	use HasThumbnail;


	protected $fillable = [
		'slug',
		'title',
		'brand_id',
		'price',
		'thumbnail',
		'on_home_page',
		'sorting',
	];


	protected $casts = [
		'price' => PriceCast::class,
	];


	public function scopeHomePage(Builder $query)
	{
		return $query->where('on_home_page', true)
			->orderBy('sorting')
			->limit(6);
	}


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


	protected function thumbnailDir(): string
	{
		return 'products';
	}
}
