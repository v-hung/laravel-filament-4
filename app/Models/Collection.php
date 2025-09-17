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
        'title',
        'slug',
        'description',
    ];

    protected $guarded = [];

    protected $casts = [
        'status' => CategoryStatus::class,
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, "product_collection");
    }
}
