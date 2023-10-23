@extends('layouts.auth')

@section('title', 'Восстановление паролья')

@section('content')
	<x-forms.auth-forms title="Восстановление паролья" action="{{ route('password.update') }}" method="post">

		<input type="hidden" name="token" value="{{ $token }}">

		<x-forms.text-input name="email" type="email" value="{{ request('email') }}" placeholder="E-mail" required="true" :isError="$errors->has('email')" />
		@error('email')<x-forms.error>{{ $message }}</x-forms.error>@enderror

		<x-forms.text-input name="password" type="password" placeholder="Пароль" required="true" :isError="$errors->has('password')" />
		@error('password')<x-forms.error>{{ $message }}</x-forms.error>@enderror

		<x-forms.text-input name="password_confirmation" type="password" placeholder="Повторите пароль" required="true" :isError="$errors->has('password_confirmation')" />
		@error('password_confirmation')<x-forms.error>{{ $message }}</x-forms.error>@enderror

		<x-forms.primary-button>Обновить</x-forms.primary-button>

		<x-slot:socialAuth></x-slot:socialAuth>

		<x-slot:buttons></x-slot:buttons>

	</x-forms.auth-forms>
@endsection
