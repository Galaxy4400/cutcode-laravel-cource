<div>
	<h5 class="mb-4 text-sm 2xl:text-md font-bold">{{ $filter->title() }}</h5>
	<div class="flex items-center justify-between gap-3 mb-2">
		<span class="text-body text-xxs font-medium">От, ₽</span>
		<span class="text-body text-xxs font-medium">До, ₽</span>
	</div>

	<div class="flex items-center gap-3">
		<input name="{{ $filter->name('min') }}" value="{{ $filter->requestValue('min', $filter->values()['min']) }}" type="number" id="{{ $filter->id('min') }}" class="w-full h-12 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition" placeholder="От" step="0.01">
		<span class="text-body text-sm font-medium">–</span>
		<input name="{{ $filter->name('max') }}" value="{{ $filter->requestValue('max', $filter->values()['max']) }}" type="number" id="{{ $filter->id('max') }}" class="w-full h-12 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition" placeholder="До" step="0.01">
	</div>
</div>