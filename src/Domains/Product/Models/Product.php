<?php

namespace Domains\Product\Models;

use App\Jobs\ProductJsonProperties;
use Supports\Casts\PriceCast;
use Domains\Catalog\Models\Brand;
use Supports\Traits\Models\HasSlug;
use Domains\Catalog\Models\Category;
use Domains\Product\QueryBuilders\ProductQueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Supports\Traits\Models\HasThumbnail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * @method static Product|ProductQueryBuilder query()
 */
class Product extends Model
{
	use HasFactory;
	use HasSlug;
	use HasThumbnail;


	protected $fillable = [
		'slug',
		'title',
		'text',
		'brand_id',
		'price',
		'quantity',
		'thumbnail',
		'on_home_page',
		'sorting',
		'json_properties',
	];

	protected $casts = [
		'price' => PriceCast::class,
		'json_properties' => 'array',
	];


	public static function boot(): void
	{
		parent::boot();

		static::created(function(Product $product) {
			ProductJsonProperties::dispatch($product)
				->delay(now()->addSeconds(10));
		});
	}


	public function newEloquentBuilder($query): ProductQueryBuilder
	{
		return new ProductQueryBuilder($query);
	}


	public function brand(): BelongsTo
	{
		return $this->belongsTo(Brand::class);
	}


	public function categories(): BelongsToMany
	{
		return $this->belongsToMany(Category::class);
	}


	public function properties(): BelongsToMany
	{
		return $this->belongsToMany(Property::class)->withPivot('value');
	}


	public function optionValues(): BelongsToMany
	{
		return $this->belongsToMany(OptionValue::class);
	}

	
	protected function thumbnailDir(): string
	{
		return 'products';
	}


	// public function seen(): void
	// {
	// 	session()->put('seen.' . $this->id, $this->id);
	// }

}

