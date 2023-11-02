<?php

namespace Domains\Auth\Actions;

use Domains\Auth\Contracts\RegisterNewUserContract;
use Domains\Auth\DTOs\NewUserDTO;
use Domains\Auth\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterNewUserAction implements RegisterNewUserContract
{
	public function __invoke(NewUserDTO $data): User
	{
		$user = User::query()->create([
			'name' => $data->name,
			'email' => $data->email,
			'password' => bcrypt($data->password),
		]);

		event(new Registered($user));

		return $user;
	}
}
