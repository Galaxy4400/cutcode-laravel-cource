<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ThumbnailController extends Controller
{
	public function __invoke(string $dir, string $method, string $size, string $file): BinaryFileResponse
	{
		abort_if(!in_array($size, config('thumbnail.allowed_sizes', [])), 403, 'Size not allowed');

		$storage = Storage::disk('images');

		$realPath = "{$dir}/{$file}";
		$newDirPath = "{$dir}/{$method}/{$size}";
		$resultPath = "{$newDirPath}/{$file}";

		abort_if(!$storage->exists($realPath), 403, 'The specified file does not exist');

		if (!$storage->exists($newDirPath)) {
			$storage->makeDirectory($newDirPath);
		}

		if (!$storage->exists($resultPath)) {
			$image = Image::make($storage->path($realPath));

			[$width, $height] = explode('x', $size);

			$image->{$method}($width, $height);

			$image->save($storage->path($resultPath));
		}

		return response()->file($storage->path($resultPath));
	}
}
