<?php

use App\Models\File;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->xIf();
        $this->lightBox();
    }

    public function xIf(): void
    {
        $introCategory = Category::where('name', 'Directives')->get()->first();

        $xIfComponent = $introCategory->components()->create([
            'name' => 'x-if',
            'description' => <<<'EOD'
**Example:** `<template x-if="true"><div>Some Element</div></template>`

**Structure:** `<template x-if="[expression]"><div>Some Element</div></template>`

For cases where `x-show` isn't sufficient (`x-show` sets an element to `display: none` if it's false), `x-if` can be used to  actually remove an element completely from the DOM.

It's important that `x-if` is used on a `<template></template>` tag because Alpine doesn't use a virtual DOM. This implementation allows Alpine to stay rugged and use the real DOM to work its magic.

> Note: `x-if` must have a single element root inside the `<template></template>` tag.

> Note: When using `template` in a `svg` tag, you need to add a [polyfill](https://github.com/alpinejs/alpine/issues/637#issuecomment-654856538) that should be run before Alpine.js is initialized.
EOD,
]);

        $introCategory->components->last()->files()->createMany([
            [
                'content' => <<<'EOD'
<div x-data="{isActive: false}">
<template x-if="isActive">
    <div class="bg-green-200 p-4 rounded-xl mb-5">I'm in the dom!</div>
</template>
<button
    class="text-gray-800 bg-gray-200 px-4 py-2 border-2 border-gray-400 rounded-lg font-bold"
    @click="isActive = ! isActive"
>
    Click me
</button>
</div>
EOD,
                'extension' => File::HTML,
            ],
        ]);
    }

    public function lightBox(): void
    {
        $introCategory = Category::where('name', 'Images Galery')->get()->first();

        $xIfComponent = $introCategory->components()->create([
            'name' => 'LightBox',
            'description' => <<<'EOD'
## LightBox Component
EOD,
]);

        $introCategory->components->last()->files()->createMany([
            [
                'content' => <<<'EOD'
<div x-data="galery()" x-on:keydown.window.escape="close" x-on:keydown.window.arrow-left="previous" x-on:keydown.window.arrow-right="next">

<h1 class="px-5 font-bold text-xl my-5">Alpinejs image galery</h1>

<div x-ref="galery" class="px-5 grid grid-cols-3 gap-8">

    <img class="object-cover h-64 w-full shadow-lg hover:shadow-xl rounded cursor-pointer" src="https://bigcats.be/images/resized/750x-header-cat.jpg" loading="lazy" @click="open(1)">

    <img class="object-cover h-64 w-full shadow-lg hover:shadow-xl rounded cursor-pointer" src="https://www.cat-etoiles.be/wp-content/uploads/2020/04/Cats_Paws_Glance_449274-scaled.jpg" loading="lazy" @click="open(2)">

    <img class="object-cover h-64 w-full shadow-lg hover:shadow-xl rounded cursor-pointer" src="https://i.pinimg.com/originals/d7/a5/5a/d7a55a41d1825c8e96fc4de420d9585d.jpg" loading="lazy" @click="open(3)">

</div>

<div x-show.transition="show" class="absolute top-0 w-screen h-screen bg-black-transparent">

    <button class="absolute top-0 right-0 rounded-full h-8 w-8 bg-gray-600 hover:bg-gray-400 transition duration-200 text-black p-2 mr-5 mt-5" @click="close">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
    </button>

    <div class="flex h-full w-full items-center justify-center">

    <button class="flex-none rounded-full h-8 w-8 bg-gray-600 hover:bg-gray-400 transition duration-200 text-black p-2 mx-5" @click="previous">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </button>

    <div class="flex-grow">
        <img x-ref="fullscreenImg" class="vh-90 w-full object-contain" src="">
    </div>

    <button class="flex-none rounded-full h-8 w-8 p-2 bg-gray-600 hover:bg-gray-400 transition duration-200 text-black mx-5" @click="next">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
        </svg>
    </button>

    </div>

</div>

</div>
EOD,
                'extension' => File::HTML,
            ],
            [
                'content' => <<<'EOD'
function galery() {
    return {
        show: false,
        showedImgId: null,
        getGaleryLength() {
            return this.$refs.galery.children.length;
        },
        open(imgId) {
            this.show = true;
            this.showedImgId = imgId;
            let imgSrc = this.getShowedImage().getAttribute("src");
            this.setSrc(imgSrc);
        },
        close() {
            this.show = false;
        },
        getShowedImage() {
            return this.$refs.galery.children[this.showedImgId - 1];
        },
        getSrc(imgId) {
            return this.$refs.galery.children[imgId].getAttribute("src");
        },
        setSrc(imgSrc) {
            this.$refs.fullscreenImg.setAttribute("src", imgSrc);
        },
        previous() {
            if (!this.open) { return;}
            let imgSrc = "";
            if (this.showedImgId - 1 < 1) {
                imgSrc = this.getSrc(this.getGaleryLength() - 1);
                this.showedImgId = this.getGaleryLength();
            } else {
                imgSrc = this.getSrc(this.showedImgId - 2);
                this.showedImgId -= 1;
            }
            this.setSrc(imgSrc);
        },
        next() {
            if (!this.open) { return;}
            let imgSrc = "";
            if (this.showedImgId == this.getGaleryLength()) {
                imgSrc = this.getSrc(0);
                this.showedImgId = 1;
            } else {
                imgSrc = this.getSrc(this.showedImgId);
                this.showedImgId += 1;
            }
            this.setSrc(imgSrc);
        }
    };
}
EOD,
                'extension' => File::JS,
            ],
            [
                'content' => <<<'EOD'
.vh-90 {
    height: 90vh;
}

.bg-black-transparent {
    background-color: rgba(0, 0, 0, 0.95);
}
EOD,
                'extension' => File::CSS,
            ],
        ]);
    }
}
