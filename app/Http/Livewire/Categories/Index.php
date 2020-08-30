<?php

namespace App\Http\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;

class Index extends Component
{
    public $searchQuery;

    public $selectedCategoryId;

    public $selectedCategoryName;

    public $newCategoryName;

    protected $updatesQueryString = ['searchQuery'];

    public function mount()
    {
        $this->searchQuery = request()->query('searchQuery', $this->searchQuery);
    }

    public function addCategory()
    {
        $this->validate([
            'newCategoryName' => 'required|string',
        ]);

        Category::create([
            'name' => $this->newCategoryName,
            'order' => Category::max('order') + 1,
        ]);
    }

    public function selectCategory(int $id, string $name)
    {
        $this->selectedCategoryId = $id;
        $this->selectedCategoryName = $name;
    }

    public function updateCategory()
    {
        $this->validate([
            'selectedCategoryName' => 'required|string',
        ]);

        Category::find($this->selectedCategoryId)
            ->update([
            'name' => $this->selectedCategoryName,
        ]);
    }

    public function swapWithPrevious(int $id)
    {
        Category::find($id)->swapWithPrevious();
    }

    public function swapWithNext(int $id)
    {
        Category::find($id)->swapWithNext();
    }

    public function deleteCategory()
    {
        Category::find($this->selectedCategoryId)->delete();
        $this->selectedCategoryId = null;
        $this->selectedCategoryName = null;
    }

    public function render()
    {
        return view('livewire.categories.index', [
            'categories' => Category::where('name', 'LIKE', '%' . $this->searchQuery . '%')
                ->orderBy('order')
                ->get(),
        ]);
    }
}
