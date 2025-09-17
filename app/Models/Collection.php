<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\CategoryStatus;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Collection extends Model
{
    use HasTranslations;

    public array $translatable = [
        'name',
        'slug',
        'description',
    ];

    protected $casts = [
        'status' => CategoryStatus::class,
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
