<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Http\Requests\ForgotPasswordFormRequest;

class AuthController extends Controller
{
	public function index(): View|Factory
	{
		return view('auth.index');
	}


	public function signUp(): View|Factory
	{
		return view('auth.sign-up');
	}


	public function forgot(): View|Factory
	{
		return view('auth.forgot-password');
	}


	public function signIn(SignInFormRequest $request): RedirectResponse
	{
		if (!auth()->attempt($request->validated())) {
			return back()->withErrors([
				'email' => 'The provided credentials do not match our records.',
			])->onlyInput('email');
		};

		$request->session()->regenerate();

		return redirect()->intended(route('home'));
	}


	public function store(SignUpFormRequest $request): RedirectResponse
	{
		$user = User::query()->create([
			'name' => $request->get('name'),
			'email' => $request->get('email'),
			'password' => bcrypt($request->get('password')),
		]);

		event(new Registered($user));

		auth()->login($user);

		$request->session()->regenerate();

		return redirect()->intended(route('home'));
	}


	public function logOut(): RedirectResponse
	{
		auth()->logout();

		request()->session()->invalidate();

		request()->session()->regenerateToken();

		return redirect()->route('home');
	}


	public function forgotPassword(ForgotPasswordFormRequest $request): RedirectResponse
	{
		$status = Password::sendResetLink(
			$request->only('email')
		);

		return $status === Password::RESET_LINK_SENT
			? back()->with(['message' => __($status)])
			: back()->withErrors(['email' => __($status)]);
	}


	public function reset(string $token): View|Factory
	{
		return view('auth.reset-password', compact('token'));
	}


	public function resetPassword(ResetPasswordFormRequest $request): RedirectResponse
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

		return $status === Password::PASSWORD_RESET
			? redirect()->route('login')->with('status', __($status))
			: back()->withErrors(['email' => [__($status)]]);
	}
}
