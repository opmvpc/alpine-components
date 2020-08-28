<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * Set le slug quand le nom est modifié
 */
trait Sluggable
{
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
