<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class SignUpFormRequest extends FormRequest
{

	public function authorize(): bool
	{
		return auth()->guest();
	}

	protected function prepareForValidation()
	{
		$this->merge([
			'email' => str(request('email'))->squish()->lower()->value(),
		]);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'name' => ['required', 'string', 'min:3'],
			'email' => ['required', 'email', 'unique:users'],
			'password' => ['required', 'confirmed', Password::defaults()],
		];
	}
}
