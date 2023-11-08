<?php

namespace App\Models;

use Supports\Casts\PriceCast;
use Domains\Catalog\Models\Brand;
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
		$query->where('on_home_page', true)
			->orderBy('sorting')
			->limit(6);
	}


	public function scopeFiltered(Builder $query)
	{
		$query
			->when(request('filters.brands'), function (Builder $query) {
				$query->whereIn('brand_id', request('filters.brands'));
			})
			->when(request('filters.price'), function (Builder $query) {
				$query->whereBetween('price', [
					request('filters.price.from', 0) * 100,
					request('filters.price.to', 100000) * 100
				]);
			});
	}


	public function scopeSorted(Builder $query)
	{
		$query->when(request('sort'), function (Builder $query) {
			$column = request()->str('sort');
			
			if ($column->contains(['price', 'title'])) {
				$direction = $column->contains('-') ? 'DESC' : 'ASC';

				$query->orderBy((string) $column->remove('-'), $direction);
			}
		});
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
