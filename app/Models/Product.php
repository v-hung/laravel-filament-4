<?php

namespace App\Models;

use App\Models\Product\ProductOption;
use App\Models\Product\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function options(): HasMany
    {
        return $this->hasMany(ProductOption::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
}
