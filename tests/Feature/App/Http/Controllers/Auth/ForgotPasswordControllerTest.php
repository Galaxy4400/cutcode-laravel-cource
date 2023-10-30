<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Auth\ForgotPasswordController;


class ForgotPasswordControllerTest extends TestCase
{
	use RefreshDatabase;


	/**
	 * @return void
	 */
	public function test_forgot_page_success(): void{
		$this->get(action([ForgotPasswordController::class, 'page']))
			->assertOk()
			->assertSee('Забыли пароль')
			->assertViewIs('auth.forgot-password');
	}


	/**
	 * @return void
	 */
	public function test_forgot_password_success(): void
	{
		Notification::fake();

		$user = UserFactory::new()->create();

		$request = [
			'email' => $user->email,
		];

		$response = $this->post(action([ForgotPasswordController::class, 'handle']), $request);

		Notification::assertSentTo($user, ResetPassword::class);
	}

}

