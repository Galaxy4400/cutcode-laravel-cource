<?php

namespace Domains\Catalog\Models;

use Domains\Catalog\QueryBuilders\BrandQueryBuilder;
use Supports\Traits\Models\HasSlug;
use Supports\Traits\Models\HasThumbnail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * @method static Brand|BrandQueryBuilder query()
 */
class Brand extends Model
{
	use HasFactory;
	use HasSlug;
	use HasThumbnail;

	protected $fillable = [
		'slug',
		'title',
		'thumbnail',
		'on_home_page',
		'sorting',
	];


	public function newEloquentBuilder($query)
	{
		return new BrandQueryBuilder($query);
	}


	public function products(): HasMany
	{
		return $this->hasMany(Product::class);
	}


	protected function thumbnailDir(): string
	{
		return 'brands';
	}
}
