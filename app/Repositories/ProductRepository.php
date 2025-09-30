<?php

namespace App\Repositories;

use App\Data\ProductSearchParams;
use App\Enums\ProductOrderType;
use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository
{

    private const RELATIONS_WITH_OPTIONS_AND_VARIANTS = [
        'options:id,product_id,name',
        'options.values:id,product_option_id,value',
        'variants:id,product_id,sku,price',
        'variants.values:id,product_variant_id,product_option_value_id',
        'variants.values.optionValue:id,product_option_id,value',
    ];

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

    public function withOptionsAndVariants(Product $product): Product
    {
        $product->load(self::RELATIONS_WITH_OPTIONS_AND_VARIANTS);

        return $this->transform($product);
    }

    public function getWithOptionsAndVariants(int $productId): ?Product
    {
        $product = Product::with(self::RELATIONS_WITH_OPTIONS_AND_VARIANTS)->find($productId);

        if ($product != null) {
            $product = $this->transform($product);
        }

        return $product;
    }

    /**
     * @param  int[]  $productIds
     * @return Product[]
     */
    public function listWithOptionsAndVariants(array $productIds): array
    {
        $products = Product::with(self::RELATIONS_WITH_OPTIONS_AND_VARIANTS)->whereIn('id', $productIds)->get();

        return $products->map([$this, 'transform']);
    }

    private function transform(Product $product): Product
    {
        $product->setAttribute('options_raw', $product->options->map(fn($opt) => [
            'id' => $opt->id,
            'name' => $opt->name,
            'values' => $opt->values->map(fn($val) => [
                'id' => $val->id,
                'label' => $val->label,
            ])->toArray(),
        ])->toArray());

        $product->setAttribute('variants_raw', $product->variants->map(fn($variant) => [
            'id' => $variant->id,
            'image' => $variant->image,
            'sku' => $variant->sku,
            'price' => $variant->price,
            'stock' => $variant->stock,
            'values' => $variant->values->map(fn($val) => [
                'id' => $val->id,
                'value' => $val->optionValue->label,
                'option_id' => $val->optionValue->product_option_id,
            ])->toArray(),
        ])->toArray());

        return $product;
    }
}
