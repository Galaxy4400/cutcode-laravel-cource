<?php

namespace Domains\Auth\DTOs;

use Illuminate\Http\Request;
use Supports\Traits\Makeable;

class NewUserDTO
{
	use Makeable;


	public function __construct(
		public readonly string $name,
		public readonly string $email,
		public readonly string $password
	)
	{
	}


	public static function fromRequest(Request $request): static
	{
		return self::make(...$request->only(['name', 'email', 'password']));
	}
}
