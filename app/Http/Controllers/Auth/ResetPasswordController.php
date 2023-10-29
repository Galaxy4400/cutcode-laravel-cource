<?php

namespace App\Http\Controllers\Auth;

use Domains\Auth\Models\User;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\ResetPasswordFormRequest;


class ResetPasswordController extends Controller
{

	public function page(string $token): View|Factory
	{
		return view('auth.reset-password', compact('token'));
	}


	public function handle(ResetPasswordFormRequest $request): RedirectResponse
	{
		$status = Password::reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function (User $user, string $password) {
				$user->forceFill([
					'password' => bcrypt($password)
				])->setRememberToken(str()->random(60));

				$user->save();

				event(new PasswordReset($user));
			}
		);

		if ($status === Password::PASSWORD_RESET) {
			flash()->info(__($status));

			return redirect()->route('login');
		}

		back()->withErrors(['email' => [__($status)]]);
	}

}
