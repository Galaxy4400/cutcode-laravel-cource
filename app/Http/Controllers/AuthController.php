<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SignInFormRequest;

class AuthController extends Controller
{
	public function index()
	{
		return view('auth.index');
	}


	public function signUp()
	{
		return view('auth.sign-up');
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
}
