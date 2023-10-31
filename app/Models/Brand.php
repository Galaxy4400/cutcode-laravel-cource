<?php

namespace App\Models;

use App\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
	use HasFactory;
	use HasSlug;

	protected $fillable = [
		'slug',
		'title',
		'thumbnail',
		'on_home_page',
		'sorting',
	];


	public function scopeHomePage(Builder $query)
	{
		return $query->where('on_home_page', true)
			->orderBy('sorting')
			->limit(6);
	}

	
	public function products(): HasMany
	{
		return $this->hasMany(Product::class);
	}
}
