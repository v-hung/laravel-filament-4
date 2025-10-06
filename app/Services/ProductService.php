<?php

namespace App\Services;

use App\Models\Product\ProductOption;
use App\Models\Product\ProductOptionValue;
use App\Models\Product\ProductVariant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductService
{

    public function saveOptionsVariants(array $options, array $variants, int $productId)
    {

        DB::transaction(function () use ($productId, $options, $variants) {
            $existingOptions = ProductOption::with('values')
                ->where('product_id', $productId)
                ->get();

            $valueMap = $this->syncOptions($options, $existingOptions, $productId);

            $existingVariants = ProductVariant::with('values')
                ->where('product_id', $productId)
                ->get();

            $this->syncVariants($variants, $existingVariants, $valueMap, $productId);
        });
    }

    private function syncOptions(array $options, Collection $existingOptions, int $productId): array
    {
        $valueMap = [];
        $newOptionIds = [];

        foreach ($options as $optionData) {
            $option = $existingOptions->firstWhere('id', $optionData['id']);
            if ($option) {
                $option->update([
                    'name'     => $optionData['name'],
                    'position' => $optionData['position'] ?? $option->position,
                ]);
                $newOptionIds[] = $option->id;

                $map = $this->syncOptionValues($option, $optionData['values'] ?? []);
                $valueMap = array_merge($valueMap, $map);
            } else {
                $option = ProductOption::create([
                    'product_id' => $productId,
                    'name'       => $optionData['name'],
                    'position'   => $optionData['position'] ?? $existingOptions->count() + 1,
                ]);
                $newOptionIds[] = $option->id;

                if (!empty($optionData['values'])) {
                    foreach ($optionData['values'] as $pos => $valueData) {
                        $val = ProductOptionValue::create([
                            'product_option_id' => $option->id,
                            'label'             => $valueData['label'],
                            'position'          => $valueData['position'] ?? $pos + 1,
                        ]);

                        $valueMap[$valueData['id']] = $val->id;
                    }
                }
            }
        }

        // Delete old options is no longer in input
        foreach ($existingOptions as $oldOption) {
            if (!in_array($oldOption->id, $newOptionIds)) {
                $oldOption->values()->delete();
                $oldOption->delete();
            }
        }

        return $valueMap;
    }

    private function syncOptionValues(ProductOption $option, array $values): array
    {
        $valueMap = [];

        $existingValues = $option->values;
        $newValueIds = [];

        foreach ($values as $pos => $valueData) {
            $val = $existingValues->firstWhere('id', $valueData['id']);
            if ($val) {
                $val->update([
                    'label'      => $valueData['label'],
                    'position'   => $valueData['position'] ?? $pos + 1
                ]);
                $newValueIds[] = $val->id;

                $valueMap[$val->id] = $val->id;
            } else {
                $val = ProductOptionValue::create([
                    'product_option_id' => $option->id,
                    'label'             => $valueData['label'],
                    'position'          => $valueData['position'] ?? $pos + 1,
                ]);
                $newValueIds[] = $val->id;

                $valueMap[$valueData['id']] = $val->id;
            }
        }

        // Old value removal is no longer in input
        foreach ($existingValues as $oldValue) {
            if (!in_array($oldValue->id, $newValueIds)) {
                $oldValue->delete();
            }
        }

        return $valueMap;
    }

    /**
     * @param array $variants
     * @param Collection<int, ProductVariant> $existingVariants
     * @param int|null $productId
     */
    private function syncVariants(array $variants, Collection $existingVariants, array $valueMap, int $productId)
    {
        $newVariantIds = [];

        foreach ($variants as $variantData) {
            $variant = $existingVariants->firstWhere('id', $variantData['id']);
            if ($variant) {
                $variant->update([
                    'sku'        => $variantData['sku'] ?? null,
                    'price'      => $variantData['price'] ?? 0,
                    'stock'      => $variantData['stock'] ?? 0
                ]);
                $newVariantIds[] = $variant->id;

                $variant->values()->sync($this->resolveVariantValueIds($variantData['values'], $valueMap));
            } else {
                $variant = ProductVariant::create([
                    'product_id' => $productId,
                    'sku'        => $variantData['sku'] ?? null,
                    'stock'      => $variantData['stock'] ?? 0,
                    'price'      => $variantData['price'] ?? 0
                ]);
                $newVariantIds[] = $variant->id;

                $variant->values()->sync($this->resolveVariantValueIds($variantData['values'], $valueMap));
            }
        }

        // Delete old options is no longer in input
        foreach ($existingVariants as $oldVariant) {
            if (!in_array($oldVariant->id, $newVariantIds)) {
                $oldVariant->values()->delete();
                $oldVariant->delete();
            }
        }
    }

    private function resolveVariantValueIds(array $values, $valueMap): array
    {
        return collect($values ?? [])
            ->map(fn($v) => $v['option_id'])
            ->map(fn($id) => $valueMap[$id] ?? null)
            ->filter()
            ->all();
    }
}
