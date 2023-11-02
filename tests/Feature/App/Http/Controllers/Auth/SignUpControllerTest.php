<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use Tests\TestCase;
use Domains\Auth\Models\User;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Notifications\NewUserNotification;
use App\Listeners\SendEmailNewUserListener;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Auth\SignUpController;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;


class SignUpControllerTest extends TestCase
{
	use RefreshDatabase;

	protected $request;


	protected function setUp(): void
	{
		parent::setUp();

		$this->request = [
			'email' => 'test@test.test',
			'name' => 'test',
			'password' => '1234567890',
			'password_confirmation' => '1234567890',
		];
	}


	private function request(): TestResponse
	{
		return $this->post(
			action([SignUpController::class, 'handle']),
			$this->request
		);
	}


	protected function findUser()
	{
		return User::where('email', $this->request)->first();
	}


	/**
	 * @return void
	 */
	public function test_page_success(): void
	{
		$this->get(action([SignUpController::class, 'page']))
			->assertOk()
			->assertSee('Регистрация')
			->assertViewIs('auth.sign-up');
	}


	/**
	 * @return void
	 */
	public function test_validation_success(): void
	{
		$this->request()->assertValid();
	}


	/**
	 * @return void
	 */
	public function test_should_fali_validation_on_password_confirm(): void
	{
		$this->request['password'] = '1234567890';
		$this->request['password_confirmation'] = '0987654321';

		$this->request()->assertInvalid('password');
	}


	/**
	 * @return void
	 */
	public function test_user_created_success(): void
	{
		$this->assertDatabaseMissing('users', [
			'email' => $this->request['email']
		]);

		$this->request();

		$this->assertDatabaseHas('users', [
			'email' => $this->request['email']
		]);
	}


	/**
	 * @return void
	 */
	public function test_should_fail_validation_on_unique_email(): void
	{
		UserFactory::new()->create([
			'email' => $this->request['email']
		]);

		$this->assertDatabaseHas('users', [
			'email' => $this->request['email']
		]);

		$this->request()->assertInvalid('email');
	}


	/**
	 * @return void
	 */
	public function test_register_event_and_listeners_dispatched(): void
	{
		Event::fake();

		$this->request();

		Event::assertDispatched(Registered::class);
		Event::assertListening(Registered::class, SendEmailNewUserListener::class);
	}


	/**
	 * @return void
	 */
	public function test_notification_send(): void
	{
		$this->request();

		Notification::assertSentTo($this->findUser(), NewUserNotification::class);
	}


	/**
	 * @return void
	 */
	public function test_user_authenticated_after_and_redirect(): void
	{
		$this->request()->assertRedirect(route('home'));

		$this->assertAuthenticatedAs($this->findUser());
	}

}

