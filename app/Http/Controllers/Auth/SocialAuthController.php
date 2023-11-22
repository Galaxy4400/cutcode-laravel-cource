<?php

namespace App\Http\Controllers\Auth;

use Domains\Auth\Models\User;
use Supports\SessionRegenerator;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{

	public function redirect(string $driver): mixed
	{
		try {
			return Socialite::driver($driver)->redirect();
		} catch (\Throwable $th) {
			throw new \DomainException('An error has occurred or the driver is not supported!');
		}
	}


	public function callback(string $driver): RedirectResponse
	{
		if ($driver !== 'github') {
			throw new \DomainException('The driver is not supported!');
		}

		$driverUser = Socialite::driver($driver)->user();

		$user = User::updateOrCreate([
			$driver . '_id' => $driverUser->getId(),
		], [
			'name' => $driverUser->getName(),
			'email' => $driverUser->getEmail(),
			'password' => bcrypt(str()->random(20)),
		]);

		SessionRegenerator::run(fn() => auth()->login($user));

		return redirect()->intended(route('home'));
	}

}
