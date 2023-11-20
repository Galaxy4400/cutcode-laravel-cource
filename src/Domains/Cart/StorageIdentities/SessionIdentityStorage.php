<?php

namespace Domains\Cart\StorageIdentities;

use Domains\Cart\Contracts\CartIdentityStorageContract;


class SessionIdentityStorage implements CartIdentityStorageContract
{
	public function get(): string
	{
		return session()->getId();
	}
}
