<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use Tests\TestCase;
use Database\Factories\UserFactory;
use App\Http\Controllers\Auth\SignInController;
use Illuminate\Foundation\Testing\RefreshDatabase;


class SignInControllerTest extends TestCase
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
	public function test_login_success(): void
	{
		$password = '1234567890';

		$user = UserFactory::new()->create([
			'email' => 'test@email.ru',
			'password' => bcrypt($password),
		]);

		$request = [
			'email' => $user->email,
			'password' => $password,
		];

		$response = $this->post(action([SignInController::class, 'handle']), $request);

		$response->assertRedirect(route('home'));

		$this->assertAuthenticatedAs($user);
	}


	/**
	 * @return void
	 */
	public function test_login_fail(): void
	{
		$request = [
			'email' => 'notfound@email.test',
			'password' => str()->random(10),
		];

		$this->post(action([SignInController::class, 'handle'], $request))
			->assertInvalid('email');
		
		$this->assertGuest();
	}


	/**
	 * @return void
	 */
	public function test_logout_success(): void
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
	public function test_logout_guest_middleware_fail(): void
	{
		$this->delete(action([SignInController::class, 'logout']))
			->assertRedirect(route('home'));
	}

}

