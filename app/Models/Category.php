<?php

namespace App\Models;

use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'order',
    ];

    public function components(): HasMany
    {
        return $this->hasMany(Component::class);
    }


    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function swapWithPrevious(): void
    {
        if ($this->order > 1) {
            $previous = static::where('order', $this->order - 1)
                ->get()
                ->first();

            $previous->order += 1;
            $previous->save();

            $this->order -= 1;
            $this->save();
        }
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function swapWithNext(): void
    {
        if ($this->order < static::max('order')) {
            $next = static::where('order', $this->order + 1)
                ->get()
                ->first();
            $next->order -= 1;
            $next->save();

            $this->order += 1;
            $this->save();
        }
    }
}
