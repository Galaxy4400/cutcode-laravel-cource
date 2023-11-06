<?php

namespace Supports\Faker\Providers;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

class FakerImageProvider extends Base
{
	public const BASE_URL = 'https://loremflickr.com/';

	
	public function loremflickr(string $dir = null, int $width = 500, int $height = 500, bool $fullPath = false, $format = 'jpg'): string
	{
		$dir = null === $dir ? sys_get_temp_dir() : $dir;

		$name = md5(uniqid(empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'], true));
		$filename = sprintf('%s.%s', $name, $format);
		$filepath = $dir . '/' . $filename;

		Storage::put(
			$filepath, 
			file_get_contents(self::BASE_URL . $width . '/' . $height)
		);

		return $fullPath ? $filepath : $filename;
	}


	public function fixturesImage(string $fixturesDir, bool $fullPath = true): string
	{
		$storage = Storage::disk('images');

		if (!$storage->exists($fixturesDir)) {
			$storage->makeDirectory($fixturesDir);
		}

		$file = $this->generator->file(
			base_path('/tests/Fixtures/images/' . $fixturesDir),
			$storage->path($fixturesDir),
			false
		);

		return $fullPath ? '/storage/images/' . trim($fixturesDir, '/') . '/' . $file : $file;
	}
}
