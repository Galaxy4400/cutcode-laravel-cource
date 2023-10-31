@if ($flashMessage = flash()->get())
	<div class="{{ $flashMessage->class() }} p-5">
		{{ $flashMessage->message() }}
	</div>
@endif