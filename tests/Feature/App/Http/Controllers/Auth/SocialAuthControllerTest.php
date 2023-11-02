<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\SocialAuthController;
use Database\Factories\UserFactory;
use DomainException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Mockery\MockInterface;


class SocialAuthControllerTest extends TestCase
{
	use RefreshDatabase;


	/**
	 * @return TestResponse
	 */
	private function callbackRequest(): TestResponse
	{
		return $this->get(action([SocialAuthController::class, 'callback'], ['driver' => 'github']));
	}


	/**
	 * @param string|int $githubId
	 * 
	 * @return MockInterface
	 */
	private function mockSocialiteCallback(string|int $githubId): MockInterface
	{
		$user = $this->mock(SocialiteUser::class , function (MockInterface $mock) use ($githubId) {
			$mock->shouldReceive('getId')
				->once()
				->andReturn($githubId);

			$mock->shouldReceive('getName')
				->once()
				->andReturn(str()->random(10));

			$mock->shouldReceive('getEmail')
				->once()
				->andReturn('testing@email.ru');
		});

		Socialite::shouldReceive('driver->user')
		 ->once()
		 ->andReturn($user);

		return $user;
	}


	/**
	 * @return void
	 */
	public function test_github_redirect_success(): void
	{
		$this->get(action([SocialAuthController::class, 'redirect'], ['driver' => 'github']))
			->assertRedirectContains('github.com');
	}


	/**
	 * @return void
	 */
	public function test_github_not_found_exception(): void
	{
		$this->expectException(DomainException::class);

		$this->withoutExceptionHandling()
			->get(action([SocialAuthController::class, 'redirect'], ['driver' => 'vk']));

		$this->withoutExceptionHandling()
			->get(action([SocialAuthController::class, 'callback'], ['driver' => 'vk']));
	}


	/**
	 * @return void
	 */
	public function test_github_callback_created_user_success(): void
	{
		$githubId = str()->random(10);

		$this->assertDatabaseMissing('users', ['github_id' => $githubId]);

		$this->mockSocialiteCallback($githubId);

		$this->callbackRequest()->assertRedirect(route('home'));

		$this->assertAuthenticated();

		$this->assertDatabaseHas('users', ['github_id' => $githubId]);
	}


	/**
	 * @return void
	 */
	public function test_authenticated_by_existing_user(): void
	{
		$githubId = str()->random(10);

		UserFactory::new()->create(['github_id' => $githubId]);

		$this->assertDatabaseHas('users', ['github_id' => $githubId]);

		$this->mockSocialiteCallback($githubId);

		$this->callbackRequest()->assertRedirect(route('home'));

		$this->assertAuthenticated();
	}

}

