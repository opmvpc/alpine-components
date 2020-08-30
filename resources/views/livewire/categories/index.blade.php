<x-layouts.container >
    <a class="absolute inline-flex items-center top-0 bg-yellow-200 border-2 border-yellow-400 text-yellow-700 px-4 py-2 rounded-lg text-sm font-bold mt-4 transform hover:-translate-x-2 transition-transform duration-200 ease-in-out" href="{{route('components.index') }}">
        <svg class="inline h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        back to home
    </a>

    <div x-data="editMode()">

        <form action="">
            <input type="text" wire:model.debounce.200ms="searchQuery" class="w-full bg-white border-4 border-yellow-300 rounded-lg px-6 py-3" placeholder="Type to search for a category">
        </form>

        <div class="flex items-end justify-between mt-12 mb-8">
            <h1 class="text-3xl font-extrabold">Categories</h1>
        </div>
        <div class="bg-yellow-50 border-4 border-yellow-300 rounded-lg px-6 py-2">
            @forelse ($categories as $category)
                <div class="flex justify-between items-center py-4 {{ $loop->last ? '' : 'border-b ' }}">
                    <div @click="editModeOn" wire:click="selectCategory({{$category->id}}, '{{$category->name}}')" class="cursor-pointer text-xl font-extrabold capitalize">{{$category->name}}</div>
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
            <label for="name" class="font-bold px-5">Name:</label>
            <input wire:model="newCategoryName" class="flex-grow px-6 h-12" type="text" placeholder="New category name">
            <button wire:click="addCategory()" class="font-bold px-4 h-10 bg-yellow-200 text-yellow-700 border-4 border-yellow-300 rounded-lg mr-1" >Add</button>
        </div>
        @error('newCategoryName') <div class="mt-2 text-red-600 font-bold text-sm">{{ $message }}</div> @enderror

        <div x-show="isEditModeOn">
            <div class="flex items-end justify-between mt-12 mb-4">
                <h1 class="text-xl font-extrabold">Edit a category</h1>
            </div>
            <div class="flex bg-yellow-50 border-4 border-yellow-300 rounded-lg items-center">
                <label for="name" class="font-bold px-5">Name:</label>
                <input wire:keydown.debounce.200ms="updateCategory()" wire:model="selectedCategoryName" wire: class="flex-grow px-6 h-12" type="text" placeholder="New category name">
            </div>
            @error('selectedCategoryName') <div class="mt-2 text-red-600 font-bold text-sm">{{ $message }}</div> @enderror

            <div class="flex justify-end">
                <button @click="editModeOff" wire:click="deleteCategory()" type="button" class="inline-flex items-center bg-red-200 border-2 border-red-400 text-red-700 px-4 py-2 rounded-lg text-sm font-bold mt-4 transform hover:-translate-x-2 transition-transform duration-200 ease-in-out">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
                </button>
            </div>
        </div>
    </div>
</x-layouts.container>

@push('js')
    <script>
        function editMode() {
            return {
                isEditModeOn: false,
                editModeOn() {
                    this.isEditModeOn = true;
                },
                editModeOff() {
                    this.isEditModeOn = false;
                },
            }
        }
    </script>
@endpush
