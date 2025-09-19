<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Enums\ContentStatus;

class Page extends Model
{
    use HasTranslations;

    public array $translatable = [
        'title',
        'slug',
        'description',
    ];

    protected $guarded = [];

    protected $casts = [
        'status' => ContentStatus::class,
        'images' => 'array',
    ];
}
