@extends('layouts.auth')

@section('title', 'Восстановление паролья')

@section('content')
	<x-forms.auth-forms title="Восстановление паролья" action="" method="post">

		<x-slot:main>
			<x-forms.text-input name="email" type="email" placeholder="E-mail" required="true" :isError="$errors->has('email')" />
			@error('email')<x-forms.error>{{ $message }}</x-forms.error>@enderror

			<x-forms.text-input name="password" type="password" placeholder="Пароль" required="true" :isError="$errors->has('password')" />
			@error('password')<x-forms.error>{{ $message }}</x-forms.error>@enderror

			<x-forms.text-input name="password_confirmation" type="password" placeholder="Повторите пароль" required="true" :isError="$errors->has('password_confirmation')" />
			@error('password_confirmation')<x-forms.error>{{ $message }}</x-forms.error>@enderror
	
			<x-forms.primary-button>Обновить</x-forms.primary-button>
		</x-slot:main>

	</x-forms.auth-forms>
@endsection
