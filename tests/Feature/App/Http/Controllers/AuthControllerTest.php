<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use Domains\Auth\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Notifications\NewUserNotification;
use App\Listeners\SendEmailNewUserListener;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;


class AuthControllerTest extends TestCase
{
	use RefreshDatabase;

	/**
	 * @return void
	 */
	public function test_login_page_success(): void{
		$this->get(action([SignInController::class, 'page']))
			->assertOk()
			->assertSee('Вход в аккаунт')
			->assertViewIs('auth.login');
	}


	/**
	 * @return void
	 */
	public function test_sign_up_page_success(): void{
		$this->get(action([SignUpController::class, 'page']))
			->assertOk()
			->assertSee('Регистрация')
			->assertViewIs('auth.sign-up');
	}


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
	public function test_sign_in_success(): void
	{
		$password = '1234567890';

		$user = UserFactory::new()->create(
			[
				'password' => bcrypt($password),
			]
		);

		$request = [
			'email' => $user->email,
			'password' => $password,
		];

		$response = $this->post(action([SignInController::class, 'handle']), $request);

		$response
			->assertValid()
			->assertRedirect(route('home'));

		$this->assertAuthenticatedAs($user);
	}


	/**
	 * @return void
	 */
	public function test_store_success(): void
	{
		Notification::fake();
		Event::fake();
		
		$request = [
			'email' => 'test@test.test',
			'name' => 'test',
			'password' => '1234567890',
			'password_confirmation' => '1234567890',
		];

		$this->assertDatabaseMissing('users', [
			'email' => $request['email'],
		]);
		
		$response = $this->post(action([SignUpController::class, 'handle']), $request);

		$response->assertValid();

		$this->assertDatabaseHas('users', [
			'email' => $request['email'],
		]);

		$user = User::where('email', $request['email'])->first();

		Event::assertDispatched(Registered::class);
		Event::assertListening(Registered::class, SendEmailNewUserListener::class);

		$event = new Registered($user);
		$listener = new SendEmailNewUserListener();

		$listener->handle($event);

		Notification::assertSentTo($user, NewUserNotification::class);

		$this->assertAuthenticatedAs($user);

		$response->assertRedirect(route('home'));
	}


	/**
	 * @return void
	 */
	public function test_log_out_success(): void
	{
		$user = UserFactory::new()->create();

		$this->actingAs($user)
			->delete(action([SignInController::class, 'logout']))
			->assertRedirect(route('home'));

		$this->assertGuest();
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

