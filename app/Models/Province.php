<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $guarded = [];

    public function wards(): HasMany
    {
        return $this->hasMany(Ward::class, "province_code", "code");
    }
}
