<x-layouts.container>
    <a class="absolute inline-flex items-center top-0 bg-yellow-200 border-2 border-yellow-400 text-yellow-700 px-4 py-2 rounded-lg text-sm font-bold mt-4 transform hover:-translate-x-2 transition-transform duration-200 ease-in-out" href="{{route('components.index') }}">
        <svg class="inline h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        back to categories
    </a>

    <div class="flex justify-between items-end mb-6">
        <div class="inline-flex justify-between items-end ">
            <h1 class="text-2xl font-extrabold">{{ $this->category }}</h1>
            <svg class="h-4 w-4 mx-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <h1 class="text-4xl font-extrabold">{{ $this->name}}</h1>
        </div>

        @unless ($this->alpineComponent->slug === null)
            <a class="inline-flex items-center bg-yellow-200 border-2 border-yellow-400 text-yellow-700 px-4 py-2 rounded-lg text-sm font-bold mt-4 transform hover:-translate-x-2 transition-transform duration-200 ease-in-out" href="{{route('components.show', $this->alpineComponent->slug) }}">
                <svg class="inline h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                show component
            </a>
        @endunless
    </div>

    <div class="flex bg-yellow-50 border-4 border-yellow-300 rounded-lg items-center">
        <label for="name" class="font-bold px-5">Name:</label>
        <input id="name" wire:keydown.debounce.200ms="updateComponent()" wire:model="name" class="flex-grow px-6 h-12" type="text" placeholder="Component name">
    </div>
    @error('name') <div class="mt-2 text-red-600 font-bold text-sm">{{ $message }}</div> @enderror

    <div class="flex bg-yellow-50 border-4 border-yellow-300 rounded-lg items-center mt-6">
        <label for="category" class="font-bold px-5">Category:</label>
        <select wire:model="category" x-data x-on:change="window.livewire.emit('categoryChanged')" id="category" class="flex-grow px-6 h-12" type="text">
            @foreach ($categories as $categoryName)
                <option value="{{$categoryName}}">{{$categoryName}}</option>
            @endforeach
        </select>
    </div>
    @error('category') <div class="mt-2 text-red-600 font-bold text-sm">{{ $message }}</div> @enderror

    <div class="mt-6 mb-4 flex justify-between items-end">
        <h2 class="text-xl font-extrabold capitalize">Description</h2>

        <div class="inline-flex items-end">
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-12">
        <div>
            <textarea wire:keydown.debounce.200ms="updateComponent()" wire:model="description" class="relative bg-white border-4 border-yellow-300 rounded-lg p-6 w-full overflow-x-auto leading-7" rows="20"></textarea>
            @error('description') <div class="absolute mt-2 text-red-600 font-bold text-sm">{{ $message }}</div> @enderror
        </div>

        <div class="h-full flex flex-col bg-yellow-50 border-4 border-yellow-300 rounded-lg p-6 mt-5 lg:mt-0">
            <div class="flex-grow max-w-full prose lg:prose-xl">
                {!! $this->md !!}
            </div>
        </div>
    </div>

    @foreach ($this->alpineComponent->files as $file)
        @switch($file->extension)
            @case(\App\Models\File::HTML)
                <div class="mb-4 flex justify-between items-end">
                    <h2 class="text-xl font-extrabold capitalize">Example</h2>

                    <div class="inline-flex items-end">
                    </div>
                </div>
                <div class="bg-yellow-50 border-4 border-yellow-300 rounded-lg p-6 mb-12">
                    {!! $html !!}
                </div>
                @break
            @case(\App\Models\File::JS)
                <script>
                    try {
                        {!! $js !!}
                    } catch (error) {
                        console.log(error);
                    }
                </script>
                @break
            @case(\App\Models\File::CSS)
                <style>{!! $css !!}</style>
                @break
            @default

        @endswitch
    @endforeach

    @foreach ([\App\Models\File::HTML, \App\Models\File::JS, \App\Models\File::CSS] as $fileType)
        <div class="mb-4">

            <div class="mb-4 flex justify-between items-end">
                <h2 class="text-xl font-extrabold capitalize">{{$fileType}}</h2>

                @if ($fileType === \App\Models\File::JS)
                    <div class="inline-flex items-end">
                        <button x-data @click="document.location.reload()" class="bg-yellow-200 border-2 border-yellow-400 text-yellow-700 px-4 py-2 rounded-lg text-sm font-bold transform hover:-translate-x-2 transition-transform duration-200 ease-in-out">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>

            <textarea onkeydown="if(event.keyCode===9){var v=this.value,s=this.selectionStart,e=this.selectionEnd;this.value=v.substring(0, s)+'\t'+v.substring(e);this.selectionStart=this.selectionEnd=s+1;return false;}" wire:keydown.debounce.200ms="updateCode('{{$fileType}}')" wire:model="{{$fileType}}" rows="15" class="code-editor w-full p-4 font-mono bg-white border-4 border-yellow-300 rounded-lg w-full h-full overflow-x-auto leading-7"></textarea>
            @error($fileType) <div class="mt-2 text-red-600 font-bold text-sm">{{ $message }}</div> @enderror

        </div>
    @endforeach

    <div class="flex justify-end">
        <button wire:click="deleteComponent()" type="button" class="inline-flex items-center bg-red-200 border-2 border-red-400 text-red-700 px-4 py-2 rounded-lg text-sm font-bold mt-4 transform hover:-translate-x-2 transition-transform duration-200 ease-in-out">
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Delete
        </button>
    </div>

</x-layouts.container>

@push('js')
@endpush
