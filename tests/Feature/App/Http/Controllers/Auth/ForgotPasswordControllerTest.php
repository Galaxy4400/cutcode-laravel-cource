<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use Tests\TestCase;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Auth\ForgotPasswordController;


class ForgotPasswordControllerTest extends TestCase
{
	use RefreshDatabase;
	

	private function testingCredentials(): array
	{
		return [
			'email' => 'testing@email.test',
		];
	}


	/**
	 * @return void
	 */
	public function test_page_success(): void
	{
		$this->get(action([ForgotPasswordController::class, 'page']))
			->assertOk()
			->assertViewIs('auth.forgot-password');
	}


	/**
	 * @return void
	 */
	public function test_handle_success(): void
	{
		$user = UserFactory::new()->create($this->testingCredentials());

		$this->post(action([ForgotPasswordController::class, 'handle']), $this->testingCredentials());

		Notification::assertSentTo($user, ResetPasswordNotification::class);
	}


	/**
	 * @return void
	 */
	public function test_handle_fail(): void
	{
		$this->assertDatabaseMissing('users', $this->testingCredentials());

		$this->post(action([ForgotPasswordController::class, 'handle']), $this->testingCredentials())
			->assertInvalid('email');
		
		Notification::assertNothingSent();
	}

}

