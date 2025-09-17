<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\ContentStatus;

class Post extends Model
{
    use HasTranslations;

    public array $translatable = [
        'title',
        'slug',
        'description',
        'content'
    ];

    protected $casts = [
        'status' => ContentStatus::class,
        'images' => 'array',
    ];

    protected $guarded = [];

    public function blogs(): BelongsToMany
    {
        return $this->belongsToMany(Blog::class, "post_blog");
    }
}
