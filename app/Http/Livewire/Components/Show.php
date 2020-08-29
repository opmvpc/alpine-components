<?php

namespace App\Http\Livewire\Components;

use App\Models\Component;
use Livewire\Component as LivewireComponent;

class Show extends LivewireComponent
{
    public $slug;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        return view('livewire.components.show', [
            'alpineComponent' => Component::where('slug', $this->slug)->get()->first(),
        ]);
    }
}
