<?php

namespace App\Data;

class ProductSearchParams extends SearchParams
{
    public ?string $name = null;
    public ?float $priceMin = null;
    public ?float $priceMax = null;

    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->name = $data['name'] ?? null;
        $this->priceMin = isset($data['price_min']) ? (float) $data['price_min'] : null;
        $this->priceMax = isset($data['price_max']) ? (float) $data['price_max'] : null;
    }
}
