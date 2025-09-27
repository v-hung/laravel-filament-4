<?php

namespace App\Repositories;

use App\Data\ProductSearchParams;
use App\Enums\ProductOrderType;
use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository
{

    public static function search(ProductSearchParams $params, ?ProductOrderType $orderType = null): LengthAwarePaginator
    {
        $query = Product::query();

        $query->where('status', '!=', ProductStatus::Inactive);

        if ($params->name) {
            $query->where('name', 'like', "%{$params->name}%");
        }

        if ($params->priceMin !== null) {
            $query->where('price', '>=', $params->priceMin);
        }

        if ($params->priceMax !== null) {
            $query->where('price', '<=', $params->priceMax);
        }

        if ($orderType) {
            match ($orderType) {
                ProductOrderType::FEATURED =>
                $query->orderBy('is_featured', 'desc')
                    ->orderBy('featured_position', 'asc'),

                ProductOrderType::BEST_SELLING =>
                $query->orderBy('sales_count', 'desc'),

                ProductOrderType::LATEST =>
                $query->orderBy('created_at', 'desc'),
            };
        } else {
            $query->orderBy($params->sortBy, $params->sortDirection);
        }

        return $query
            ->paginate(
                perPage: $params->perPage,
                page: $params->page
            );
    }
}
