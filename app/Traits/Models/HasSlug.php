<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
	protected static function bootHasSlug(): void
	{
		static::creating(function (Model $item) {
			$item->slug = $item->slug ?? str($item->{self::slugFrom()})->append(str()->random(6))->slug();
		});
	}

	public static function slugFrom()
	{
		return 'title';
	}
}
