@extends('layouts.auth')

@section('content')
	@auth
		<form method="post" action="{{ route('logout') }}">
			@csrf
			@method('delete')
			<button type="submit">Выйти</button>
		</form>
	@endauth

	@guest
		<a href="{{ route('login') }}">Войти</a>
	@endguest

@endsection