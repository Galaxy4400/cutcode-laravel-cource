<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignInFormRequest extends FormRequest
{

	public function authorize(): bool
	{
		return auth()->guest();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'email' => ['required', 'email:dns'],
			'password' => ['required'],
		];
	}
}
