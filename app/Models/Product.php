<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    public array $translatable = [
        'name',
        'slug',
        'description',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    protected $guarded = [];

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class, "product_collection");
    }
}
