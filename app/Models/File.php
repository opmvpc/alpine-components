<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    const JS = 'js';
    const HTML = 'html';
    const CSS = 'css';

    protected $fillable = [
        'path',
        'extension',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    public function getContentAttribute(): string
    {
        return Storage::get($this->path);
    }
}
