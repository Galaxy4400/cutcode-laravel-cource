<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Seo extends Model
{
	use HasFactory;

	protected $fillable = [
		'url',
		'title',
	];


	public function url(): Attribute
	{
		return Attribute::make(
			set: fn (string $url) => parse_url($url, PHP_URL_PATH) ?? '/',
		);
	}


	protected static function boot()
	{
		parent::boot();

		static::created(function (Seo $model) {
			Cache::forget('seo_' . str($model->url)->slug('_'));
		});
		
		static::updated(function (Seo $model) {
			Cache::forget('seo_' . str($model->url)->slug('_'));
		});
		
		static::deleted(function (Seo $model) {
			Cache::forget('seo_' . str($model->url)->slug('_'));
		});
	}
}
