<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\SignInFormRequest;
use Supports\SessionRegenerator;

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

		SessionRegenerator::run();

		return redirect()->intended(route('home'));
	}


	public function logout(): RedirectResponse
	{
		SessionRegenerator::run(fn() => auth()->logout());
		
		return redirect()->route('home');
	}

}
