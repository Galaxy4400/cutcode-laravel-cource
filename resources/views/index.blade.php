@extends('layouts.auth')

@section('content')
	@auth
		<form method="post" action="{{ route('logOut') }}">
			@csrf
			@method('delete')

			<button type="submit">Выйти</button>
		</form>
	@endauth
@endsection