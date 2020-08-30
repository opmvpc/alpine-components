<?php

namespace App\Http\Livewire\Components;

use App\Models\Category;
use App\Models\Component;
use Livewire\Component as LivewireComponent;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Search extends LivewireComponent
{
    public $searchQuery;

    protected $updatesQueryString = ['searchQuery'];

    public function mount()
    {
        $this->searchQuery = request()->query('searchQuery', $this->searchQuery);
    }

    public function render()
    {
        return view('livewire.components.search', [
            'categories' => Category::with(['components' => function (HasMany $query) {
                $query->where('name', 'LIKE', '%' . $this->searchQuery . '%')
                    ->orWhere('description', 'LIKE', '%' . $this->searchQuery . '%')
                    ;
            }])
            ->orderBy('order')
            ->get()
            ->filter(function (Category $category) {
                return $category->components->isNotEmpty();
            }),
            'componentsWithoutCategory' => Component::whereNull('category_id')
                ->get(),
        ]);
    }
}
