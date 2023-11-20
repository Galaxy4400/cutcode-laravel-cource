<?php

namespace Domains\Cart\Contracts;

interface CartIdentityStorageContract
{
	public function get(): string;
}
