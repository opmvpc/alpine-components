<x-layouts.container >

    <a class="absolute inline-flex items-center top-0 font-extrabold mt-4 transform hover:-translate-x-2 transition-transform duration-200 ease-in-out" href="{{route('components.index') }}">
        <svg class="inline h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        back to home
    </a>

    <div x-data="{editMode: false}">

        <form action="">
            <input type="text" wire:model.debounce.200ms="searchQuery" class="w-full bg-yellow-50 border-4 border-yellow-300 rounded-lg px-6 py-3" placeholder="Type to search for a category">
        </form>

        <div class="flex items-end justify-between mt-12 mb-8">
            <h1 class="text-3xl font-extrabold">Categories</h1>
        </div>
        <div class="bg-yellow-50 border-4 border-yellow-300 rounded-lg px-6 py-2">
            @forelse ($categories as $category)
                <div class="flex justify-between items-center py-4 {{ $loop->last ? '' : 'border-b ' }}">
                    <div @click="editMode = true" wire:click="selectCategory({{$category->id}}, '{{$category->name}}')" class="cursor-pointer text-xl font-extrabold capitalize">{{$category->name}}</div>
                    <div>
                        <div class="flex flex-col justify-center items-center text-black">
                            <div wire:click="swapWithPrevious({{$category->id}})" class="cursor-pointer">
                                <svg class="h-4 w-4 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            </div>
                            <div wire:click="swapWithNext({{$category->id}})" class="cursor-pointer">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center">No categories matched your query</div>
            @endforelse
        </div>

        <div class="flex items-end justify-between mt-12 mb-4">
            <h1 class="text-xl font-extrabold">Add a category</h1>
        </div>
        <div class="flex bg-yellow-50 border-4 border-yellow-300 rounded-lg items-center">
            <input wire:model="newCategoryName" class="flex-grow px-6 h-12" type="text" placeholder="New category name">
            <button wire:click="addCategory()" class="font-bold px-4 h-10 bg-yellow-200 text-yellow-700 border-4 border-yellow-300 rounded-lg mr-1" >Add</button>
        </div>
        @error('newCategoryName') <div class="mt-2 text-red-600 font-bold text-sm">{{ $message }}</div> @enderror

        <div x-show="editMode">
            <div class="flex items-end justify-between mt-12 mb-4">
                <h1 class="text-xl font-extrabold">Edit a category</h1>
            </div>
            <div class="flex bg-yellow-50 border-4 border-yellow-300 rounded-lg items-center">
                <input wire:keydown.debounce.200ms="updateCategory()" wire:model="selectedCategoryName" wire: class="flex-grow px-6 h-12" type="text" placeholder="New category name">
            </div>
            @error('selectedCategoryName') <div class="mt-2 text-red-600 font-bold text-sm">{{ $message }}</div> @enderror
        </div>
    </div>
</x-layouts.container>
