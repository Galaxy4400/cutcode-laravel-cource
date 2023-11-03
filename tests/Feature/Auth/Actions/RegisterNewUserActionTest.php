<?php

namespace Tests\Feature\Auth\Actions;

use Domains\Auth\Contracts\RegisterNewUserContract;
use Domains\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterNewUserActionTest extends TestCase
{
	use RefreshDatabase;

	public function test_success_user_created()
	{
		$this->assertDatabaseMissing('users', ['email' => 'test@email.ru']);

		$action = app(RegisterNewUserContract::class);

		$action(NewUserDTO::make('test', 'test@email.ru', '1234567890'));

		$this->assertDatabaseHas('users', ['email' => 'test@email.ru']);
	}
}
