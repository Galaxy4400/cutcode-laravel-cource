<?php

namespace App\Menu;

use Supports\Traits\Makeable;

class MenuItem
{
	use Makeable;


	public function __construct(
		protected string $link,
		protected string $label,
	)
	{
	}

	public function link()
	{
		return $this->link;
	}

	public function label()
	{
		return $this->label;
	}

	public function isActive()
	{
		$path = parse_url($this->link(), PHP_URL_PATH) ?? '/';

		if ($path === '/') {
			return request()->path() === $path;
		}

		return request()->fullUrlIs($this->link() . '*');
	}
}
