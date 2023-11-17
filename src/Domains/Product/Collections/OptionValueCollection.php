<?php

namespace Domains\Product\Collections;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class OptionValueCollection extends Collection
{
	public function keyValues(): SupportCollection
	{
		return $this->mapToGroups(function ($item) {
			return [$item->option->title => $item];
		});
	}
}
