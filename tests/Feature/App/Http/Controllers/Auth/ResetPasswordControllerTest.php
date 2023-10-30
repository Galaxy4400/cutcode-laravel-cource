<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Auth\ResetPasswordController;


class ResetPasswordControllerTest extends TestCase
{
	use RefreshDatabase;


	/**
	 * @return void
	 */
	public function test_reset_page_success(): void{
		$this->get(action([ResetPasswordController::class, 'page'], [
			'token' => 'test',
		]))
			->assertOk()
			->assertSee('Восстановление паролья')
			->assertViewIs('auth.reset-password');
	}


	/**
	 * @return void
	 */
	public function test_reset_password_success(): void
	{
		Event::fake();

		$user = UserFactory::new()->create([
			'password' => bcrypt('old_password'),
		]);

		$oldPassword = $user->password;

		$token = Password::createToken($user);

		$request = [
			'email' => $user->email,
			'password' => '1234567890',
			'password_confirmation' => '1234567890',
			'token' => $token,
		];

		$response = $this->post(action([ResetPasswordController::class, 'handle']), $request);

		$newPassword = $user->password;

		$this->assertTrue($oldPassword === $newPassword);

		Event::assertDispatched(PasswordReset::class);

		$response->assertRedirect(route('login'));
	}
}

