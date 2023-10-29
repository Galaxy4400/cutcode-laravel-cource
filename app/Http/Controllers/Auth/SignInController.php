<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\SignInFormRequest;


class SignInController extends Controller
{

	public function page(): View|Factory|RedirectResponse
	{
		return view('auth.login');
	}


	public function handle(SignInFormRequest $request): RedirectResponse
	{
		if (!auth()->attempt($request->validated())) {
			return back()->withErrors([
				'email' => 'The provided credentials do not match our records.',
			])->onlyInput('email');
		};

		$request->session()->regenerate();

		return redirect()->intended(route('home'));
	}


	public function logout(): RedirectResponse
	{
		auth()->logout();

		request()->session()->invalidate();

		request()->session()->regenerateToken();

		return redirect()->route('home');
	}

}
