<x-layouts.container>

    <a class="absolute inline-flex items-center top-0 bg-yellow-200 border-2 border-yellow-400 text-yellow-700 px-4 py-2 rounded-lg text-sm font-bold mt-4 transform hover:translate-x-2 transition-transform duration-200 ease-in-out" href="{{route('components.create') }}">
        <svg class="inline h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>create component</span>
    </a>

    <form action="">
        <input type="text" wire:model.debounce.200ms="searchQuery" class="w-full bg-white border-4 border-yellow-300 rounded-lg px-6 py-3" placeholder="Type to search for a component">
    </form>

    <div class="flex items-end justify-between mt-12 mb-8">
        <h1 class="text-3xl font-extrabold">Categories</h1>
        <a class="inline-flex items-center top-0 bg-yellow-200 border-2 border-yellow-400 text-yellow-700 px-4 py-2 rounded-lg text-sm font-bold transform hover:-translate-x-2 transition-transform duration-200 ease-in-out" href="{{route('categories.index') }}">
            <svg class="inline h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            edit categories
        </a>
    </div>
    <div class="bg-yellow-50 border-4 border-yellow-300 rounded-lg p-6">
        @forelse ($categories as $category)
            @if ($category->components->isNotEmpty())
                <h2 class="text-xl font-extrabold capitalize">{{$category->name}}</h2>
                <ul class="my-4 ml-4">
                    @forelse ($category->components as $component)
                        <a class="block py-2 font-bold transform hover:translate-x-2 transition-transform duration-200 ease-in-out" href="{{ route('components.show', $component->slug) }}">{{$component->name}}</a>
                    @empty
                        <li>No components yet!</li>
                    @endforelse
                </ul>
            @endif
        @empty
            <div class="text-center">No components matched your query</div>
        @endforelse

        @unless ($componentsWithoutCategory->isEmpty())
            <h2 class="text-xl font-extrabold capitalize">Without category</h2>
            <ul class="my-4 ml-4">
            @forelse ($componentsWithoutCategory as $component)
                <a class="block py-2 font-bold transform hover:translate-x-2 transition-transform duration-200 ease-in-out" href="{{ route('components.edit', $component->id) }}">{{$component->name ?? 'no-name'}}</a>
            @empty
            @endforelse
            </ul>
        @endunless
    </div>
</x-layouts.container>
