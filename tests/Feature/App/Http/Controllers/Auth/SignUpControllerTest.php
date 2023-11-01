<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use Tests\TestCase;
use Domains\Auth\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Notifications\NewUserNotification;
use App\Listeners\SendEmailNewUserListener;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Auth\SignUpController;
use Illuminate\Foundation\Testing\RefreshDatabase;


class SignUpControllerTest extends TestCase
{
	use RefreshDatabase;


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

}

