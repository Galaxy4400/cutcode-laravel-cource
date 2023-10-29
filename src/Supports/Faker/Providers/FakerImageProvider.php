<?php

namespace Supports\Faker\Providers;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FakerImageProvider extends Base
{
	public const BASE_URL = 'https://loremflickr.com/';

	public function loremflickr(string $dir = '', int $width = 500, int $height = 500): string
	{
		$name = $dir . '/' . Str::random(6) . 'jpg';

		Storage::put($name, file_get_contents(self::BASE_URL.$width.'/'.$height));

		return '/storage/'.$name;
	}
}
