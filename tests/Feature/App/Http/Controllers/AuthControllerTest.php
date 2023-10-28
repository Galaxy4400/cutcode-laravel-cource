<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\AuthController;
use App\Listeners\SendEmailNewUserListener;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Password;

class AuthControllerTest extends TestCase
{
	use RefreshDatabase;


	/**
	 * @return void
	 */
	public function test_login_page_success(): void{
		$this->get(action([AuthController::class, 'index']))
			->assertOk()
			->assertSee('Вход в аккаунт')
			->assertViewIs('auth.index');
	}


	/**
	 * @return void
	 */
	public function test_sign_up_page_success(): void{
		$this->get(action([AuthController::class, 'signUp']))
			->assertOk()
			->assertSee('Регистрация')
			->assertViewIs('auth.sign-up');
	}


	/**
	 * @return void
	 */
	public function test_forgot_page_success(): void{
		$this->get(action([AuthController::class, 'forgot']))
			->assertOk()
			->assertSee('Забыли пароль')
			->assertViewIs('auth.forgot-password');
	}


	/**
	 * @return void
	 */
	public function test_sigh_in_success(): void
	{
		$password = '1234567890';

		$user = User::factory()->create(
			[
				'password' => bcrypt($password),
			]
		);

		$request = [
			'email' => $user->email,
			'password' => $password,
		];

		$response = $this->post(action([AuthController::class, 'signIn']), $request);

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
		
		$response = $this->post(action([AuthController::class, 'store']), $request);

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
		$user = User::factory()->create();

		$this->actingAs($user)
			->delete(action([AuthController::class, 'logOut']))
			->assertRedirect(route('home'));

		$this->assertGuest();
	}

}
