<?php

namespace App\Menu;

use Supports\Traits\Makeable;



/**
 * @method static static make(string $label, string $link)
 */
class MenuItem
{
	use Makeable;

	public function __construct(
		protected string $label,
		protected string $link,
	){}

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
