<?php

namespace Domains\Cart\StorageIdentities;

use Domains\Cart\Contracts\CartIdentityStorageContract;


class FakeIdentityStorage implements CartIdentityStorageContract
{
	public function get(): string
	{
		return 'tests';
	}
}
