<x-layouts.container>
    <a class="absolute inline-flex items-center top-0 bg-yellow-200 border-2 border-yellow-400 text-yellow-700 px-4 py-2 rounded-lg text-sm font-bold mt-4 transform hover:-translate-x-2 transition-transform duration-200 ease-in-out" href="{{route('components.index') }}">
        <svg class="inline h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        back to categories
    </a>

    <div class="flex justify-between items-end mb-6">
        <div class="inline-flex justify-between items-end ">
            <h1 class="text-2xl font-extrabold">{{ $alpineComponent->category->name ?? 'Without Category'}}</h1>
            <svg class="h-4 w-4 mx-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <h1 class="text-4xl font-extrabold">{{ $alpineComponent->name}}</h1>
        </div>

        <a class="inline-flex items-center bg-yellow-200 border-2 border-yellow-400 text-yellow-700 px-4 py-2 rounded-lg text-sm font-bold mt-4 transform hover:-translate-x-2 transition-transform duration-200 ease-in-out" href="{{route('components.edit', $alpineComponent) }}">
            <svg class="inline h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            edit component
        </a>
    </div>
    <div class="bg-yellow-50 border-4 border-yellow-300 rounded-lg p-6 mb-12">
        <div class="max-w-full prose lg:prose-xl">
            {!! $alpineComponent->descriptionMd !!}
        </div>
    </div>

    @foreach ($alpineComponent->files as $file)
        @switch($file->extension)
            @case(\App\Models\File::HTML)
                <div class="mb-4 flex justify-between items-end">
                    <h2 class="text-xl font-extrabold capitalize">Example</h2>

                    <div class="inline-flex items-end">
                        <form action="https://codepen.io/pen/define" method="POST" target="_blank">
                            <input type="hidden" name="data" value="{{$alpineComponent->codePenCode}}">

                            <button class="inline-flex items-center bg-yellow-200 border-2 border-yellow-400 text-yellow-700 px-4 py-2 rounded-lg text-sm font-bold transform hover:-translate-x-2 transition-transform duration-200 ease-in-out" type="submit">
                                <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Codepen
                            </button>
                        </form>
                    </div>
                </div>
                <div class="bg-yellow-50 border-4 border-yellow-300 rounded-lg p-6 mb-12">
                    {!! $file->content !!}
                </div>
                @break
                @case(\App\Models\File::JS)
                <script>
                    try {
                        {!! $file->content !!}
                    } catch (error) {
                        console.log(error);
                    }
                </script>
                @break
            @case(\App\Models\File::CSS)
                <style>{!! $file->content !!}</style>
                @break
            @default

        @endswitch
    @endforeach

    @foreach ($alpineComponent->files as $file)
        @if ($file->content != '')
            <div x-data="{...copyButton(), ...codeArea()}">

                <div class="mb-4 flex justify-between items-end">
                    <h2 class="text-xl font-extrabold capitalize">{{$file->extension}}</h2>

                    <div class="inline-flex items-end">
                        <button @click="copy" class="bg-yellow-200 border-2 border-yellow-400 text-yellow-700 px-4 py-2 rounded-lg text-sm font-bold transform hover:-translate-x-2 transition-transform duration-200 ease-in-out" x-bind:class="{'bg-green-200': isCopied, 'border-green-400': isCopied, 'text-green-700': isCopied}">
                            <svg x-show="! isCopied" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                            </svg>
                            <svg x-show="isCopied" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <pre x-show="isTextareaHidden" class="code-container h-full my-0 ">
                    <code @click="toggle" class="font-mono bg-yellow-50 border-4 border-yellow-300 rounded-lg w-full h-full overflow-x-auto leading-7 h-full">{{ $file->content }}</code>
                </pre>

                <textarea x-show="! isTextareaHidden" id="code" rows="15" class="w-full p-4 font-mono bg-yellow-50 border-4 border-yellow-300 rounded-lg w-full h-full overflow-x-auto leading-7">{{ $file->content }}</textarea>

            </div>
        @endif

    @endforeach

</x-layouts.container>

@push('js')
    <script>

        function copyButton() {
            return {
                isCopied: false,
                copy() {
                    let componentCode = document.getElementById("code");
                    componentCode.select();
                    componentCode.setSelectionRange(0, 99999); /*For mobile devices*/
                    document.execCommand("copy");

                    this.isCopied = true;
                }
            }
        }

        function codeArea() {
            return {
                isTextareaHidden: true,
                toggle() {
                    this.isTextareaHidden = false;
                }
            }
        }
    </script>
@endpush
