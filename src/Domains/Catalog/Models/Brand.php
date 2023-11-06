<?php

namespace Domains\Catalog\Models;

use App\Models\Product;
use Supports\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Supports\Traits\Models\HasThumbnail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Domains\Catalog\QueryBuilders\BrandQueryBuilder;
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
