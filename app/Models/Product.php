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
use Illuminate\Pipeline\Pipeline;

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
		'thumbnail',
		'on_home_page',
		'sorting',
	];

	protected $casts = [
		'price' => PriceCast::class,
	];


	protected function thumbnailDir(): string
	{
		return 'products';
	}


	public function scopeHomePage(Builder $query): Builder
	{
		$query->where('on_home_page', true)
			->orderBy('sorting')
			->limit(6);

		return $query;
	}


	public function scopeAlso(Builder $query, int $except = null): Builder
	{
		$also = session()->get('also');

		$query->whereIn('id', $also)
			->when($except, function (Builder $query) use ($except) {
				return $query->whereNot('id', $except);
			})
			->inRandomOrder()
			->limit(4);

		return $query;
	}


	public function scopeOfCategory(Builder $query, Category $category): Builder
	{
		$query->when($category->exists, function ($query) use ($category) {
			$query->whereRelation('categories', 'categories.id', $category->id);
		});

		return $query;
	}


	public function scopeFiltered(Builder $query): Builder
	{

		app(Pipeline::class)
			->send($query)
			->through(filters())
			->thenReturn();

		return $query;
	}


	public function scopeSorted(Builder $query): Builder
	{
		$query->when(request('sort'), function (Builder $query) {
			$column = request()->str('sort');

			if ($column->contains(['price', 'title'])) {
				$direction = $column->contains('-') ? 'DESC' : 'ASC';

				$query->orderBy((string) $column->remove('-'), $direction);
			}
		});

		return $query;
	}


	public function scopeSearched(Builder $query): Builder
	{
		$query->when(request('search'), function ($query) {
			$query->whereFullText(['title', 'text'], request('search'));
		});

		return $query;
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
}

