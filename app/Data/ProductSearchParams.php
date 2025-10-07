<?php

namespace App\Data;

class ProductSearchParams extends SearchParams
{
    public ?string $name = null;
    public ?float $priceMin = null;
    public ?float $priceMax = null;
}
