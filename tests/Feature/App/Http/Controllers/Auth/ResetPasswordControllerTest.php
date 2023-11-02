<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use Tests\TestCase;
use Domains\Auth\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;

class ResetPasswordControllerTest extends TestCase
{
	use RefreshDatabase;


	private string $token;

	private User $user;


	protected function setUp(): void
	{
		parent::setUp();

		$this->user = UserFactory::new()->create();
		$this->token = Password::createToken($this->user);
	}


	protected function requestData()
	{
		$password = '1234567890';
		$password_confirmation = '1234567890';

		return [
			'email' => $this->user->email,
			'password' => $password,
			'password_confirmation' => $password_confirmation,
			'token' => $this->token,
		];
	}


	/**
	 * @return void
	 */
	public function test_reset_page_success(): void
	{
		$this->get(action([ResetPasswordController::class, 'page'], ['token' => $this->token]))
			->assertOk()
			->assertViewIs('auth.reset-password');
	}


	/**
	 * @return void
	 */
	public function test_reset_password_success(): void
	{
		Password::shouldReceive('reset')
			->once()
			->withSomeOfArgs($this->requestData())
			->andReturn(Password::PASSWORD_RESET);

		$response = $this->post(action([ResetPasswordController::class, 'handle'], $this->requestData()));

		$response->assertRedirect(action([SignInController::class, 'page']));
	}
}

