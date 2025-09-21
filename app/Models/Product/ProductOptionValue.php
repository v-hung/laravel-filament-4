<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOptionValue extends Model
{
    protected $guarded = [];

    public function option(): BelongsTo
    {
        return $this->belongsTo(ProductOption::class);
    }
}
