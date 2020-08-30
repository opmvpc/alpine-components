<?php

namespace App\Http\Livewire\Components;

use App\Models\File;
use App\Models\Category;
use App\Models\Component;
use Livewire\Component as LivewireComponent;
use GrahamCampbell\Markdown\Facades\Markdown;

class Edit extends LivewireComponent
{
    public $alpineComponentId;

    public $name;

    public $categories;

    public $category;

    public $description;

    public $html;

    public $js;

    public $css;

    protected $listeners = ['categoryChanged' => 'updateComponent'];

    public function mount($id)
    {
        $this->alpineComponentId = $id;
        $this->alpineComponent = $this->getAlpineComponentProperty();
        $this->name = $this->alpineComponent->name;
        $this->categories = Category::pluck('name')->toArray();
        $this->category = $this->alpineComponent->category->name ?? $this->categories[0];
        $this->description = $this->alpineComponent->description;
        $this->html = $this->alpineComponent->files->where('extension', File::HTML)->first()->content ?? '';
        $this->js = $this->alpineComponent->files->where('extension', File::JS)->first()->content ?? '';
        $this->css = $this->alpineComponent->files->where('extension', File::CSS)->first()->content ?? '';
    }

    public function getAlpineComponentProperty()
    {
        return Component::find($this->alpineComponentId);
    }

    public function getMdProperty()
    {
        if ($this->description === null) {
            return '';
        }

        return Markdown::convertToHtml($this->description);
    }

    public function updateComponent()
    {
        $this->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'category' => 'nullable|string',
        ]);

        $this->alpineComponent
            ->update([
                'name' => $this->name,
                'description' => $this->description,
                'category_id' => Category::where('name', $this->category)->first()->id,
            ]);
    }

    public function updateCode(string $fileType)
    {
        $this->validate([
            $fileType => 'nullable|string',
        ]);

        $file = $this->alpineComponent
            ->files()
            ->UpdateOrCreate([
                'extension' => $fileType
            ], [
                'content' => $this->{$fileType},
            ]);
    }

    public function deleteComponent()
    {
        $this->alpineComponent->delete();

        return redirect()->route('components.index');
    }

    public function render()
    {
        return view('livewire.components.edit');
    }
}
