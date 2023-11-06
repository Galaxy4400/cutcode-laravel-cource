<?php

namespace Domains\Catalog\Models;

use App\Models\Product;
use Supports\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Domains\Catalog\Collections\CategoryCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Domains\Catalog\QueryBuilders\CategoryQueryBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * @method static Category|CategoryQueryBuilder query()
 */
class Category extends Model
{
	use HasFactory;
	use HasSlug;


	protected $fillable = [
		'title',
		'on_home_page',
		'sorting',
	];


	public function newEloquentBuilder($query): CategoryQueryBuilder
	{
		return new CategoryQueryBuilder($query);
	}

	public function newCollection(array $models = []): CategoryCollection
	{
		return new CategoryCollection($models);
	}


	public function products(): BelongsToMany
	{
		return $this->belongsToMany(Product::class);
	}

}
