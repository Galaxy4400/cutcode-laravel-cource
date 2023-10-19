<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{

	protected static function bootHasSlug(): void
	{
		static::creating(function (Model $item) {
			$item->slug = $item->slug ?? self::generateSlug($item);
		});
	}


	protected static function generateSlug(Model $item, int $level = 0): string
	{
		$suffix = $level ? '-'.$level : '';

		$slug = str($item->{self::slugFrom()})->append($suffix)->slug();

		$modelName = get_class($item);

		if (self::isSlugExist($slug, $modelName) && $level < 10) {
			$slug = self::generateSlug($item, $level+1);
		}

		return $slug;
	}


	protected static function isSlugExist($slug, $modelName): bool
	{
		$object = $modelName::where('slug', $slug)->first();
		
		return $object ? true : false;
	}


	public static function slugFrom()
	{
		return 'title';
	}

}
