<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\SignUpFormRequest;
use Domains\Auth\Contracts\RegisterNewUserContract;
use Domains\Auth\DTOs\NewUserDTO;

class SignUpController extends Controller
{
	public function page(): View|Factory
	{
		return view('auth.sign-up');
	}

	public function handle(SignUpFormRequest $request, RegisterNewUserContract $registerNewUserAction): RedirectResponse
	{
		$user = $registerNewUserAction(NewUserDTO::fromRequest($request));

		auth()->login($user);

		$request->session()->regenerate();

		return redirect()->intended(route('home'));
	}


}
