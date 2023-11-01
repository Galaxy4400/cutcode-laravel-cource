<?php

namespace Domains\Auth\Actions;

use Domains\Auth\Contracts\RegisterNewUserContract;
use Domains\Auth\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterNewUserAction implements RegisterNewUserContract
{
	public function __invoke(string $name, string $email, string $password): User
	{
		$user = User::query()->create([
			'name' => $name,
			'email' => $email,
			'password' => bcrypt($password),
		]);

		event(new Registered($user));

		return $user;
	}
}
