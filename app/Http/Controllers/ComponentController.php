<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function index()
    {
        return view('front.home');
    }

    public function show(string $slug)
    {
        return view('front.components.show', [
            'slug' => $slug,
        ]);
    }

    public function edit(int $id)
    {
        return view('front.components.edit', [
            'id' => $id,
        ]);
    }

    public function create()
    {
        $component = Component::create();

        return redirect()->route('components.edit', $component->id);
    }
}
