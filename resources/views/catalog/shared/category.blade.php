<a href="{{ route('catalog', $item->slug) }}" class="@if (isset($category) && $item->id === $category->id) bg-pink @else hover:bg-pink @endif p-3 sm:p-4 2xl:p-6 rounded-xl bg-card text-xxs sm:text-xs lg:text-sm text-white font-semibold">
	{{ $item->title }}
</a>