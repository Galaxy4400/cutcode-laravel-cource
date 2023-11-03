<?php

namespace Supports\Traits\Models;

use Illuminate\Support\Facades\File;

trait HasThumbnail
{

	protected abstract function thumbnailDir(): string;


	public function makeThumbnail(string $size, string $method = 'resize'): string
	{
		return route('thumbnail', [
			'dir' => $this->thumbnailDir(),
			'method' => $method,
			'size' => $size,
			'file' => File::basename($this->{$this->thumbnailColumn()}),
		]);
	}


	protected function thumbnailColumn(): string
	{
		return 'thumbnail';
	}

}
