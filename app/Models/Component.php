<?php

namespace App\Models;

use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use stdClass;

class Component extends Model
{
    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    public function getDescriptionMdAttribute(): string
    {
        return Markdown::convertToHtml($this->description);
    }

    public function getCodePenCodeAttribute(): string
    {
        $codePenCode = new stdClass();
        $codePenCode->title = $this->name;

        $this->files->each(function (File $file) use ($codePenCode) {
            $codePenCode->{$file->extension} = $file->content;
        });

        $codePenCode->js_external = 'https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.6.0/alpine.js';
        $codePenCode->css_external = 'https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.7.3/tailwind.min.css';

        return json_encode($codePenCode);
    }
}
