<?php

namespace Domains\Auth\Contracts;

use Domains\Auth\DTOs\NewUserDTO;

interface RegisterNewUserContract
{
	public function __invoke(NewUserDTO $data);
}
