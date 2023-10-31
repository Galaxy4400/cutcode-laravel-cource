<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
	use HasFactory;
	use HasSlug;


	protected $fillable = [
		'title',
		'on_home_page',
		'sorting',
	];


	public function scopeHomePage(Builder $query)
	{
		return $query->where('on_home_page', true)
			->orderBy('sorting')
			->limit(6);
	}


	/**
	 * @return BelongsToMany
	 */
	public function products(): BelongsToMany
	{
		return $this->belongsToMany(Product::class);
	}
}
