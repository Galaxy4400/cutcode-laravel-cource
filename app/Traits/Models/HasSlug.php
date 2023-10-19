<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
	
	protected static function bootHasSlug(): void
	{
		static::creating(function (Model $model) {
			$model->slug = $model->slug ?? $model->generateSlug();
		});
	}


	protected function generateSlug(int $level = 0): string
	{
		$suffix = $level ? "-{$level}" : "";

		$slug = str($this->{self::slugFrom()})
			->append($suffix)
			->slug();

		if ($this->isSlugExist($slug)) {
			$slug = $this->generateSlug($level + 1);
		}

		return $slug;
	}


	protected function isSlugExist(string $slug): bool
	{
		$object = $this->where('slug', $slug)->first();

		return $object ? true : false;
	}


	public static function slugFrom()
	{
		return 'title';
	}

}
