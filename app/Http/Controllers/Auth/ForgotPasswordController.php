<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\ForgotPasswordFormRequest;


class ForgotPasswordController extends Controller
{

	public function page(): View|Factory
	{
		return view('auth.forgot-password');
	}

	
	
	public function handle(ForgotPasswordFormRequest $request): RedirectResponse
	{
		$status = Password::sendResetLink(
			$request->only('email')
		);

		if ($status === Password::RESET_LINK_SENT) {
			flash()->info(__($status));

			return back();
		}

		return back()->withErrors(['email' => __($status)]);
	}

}
