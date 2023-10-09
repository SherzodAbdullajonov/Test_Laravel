<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MaterialAllocation;
use App\Models\Product;


class ProductService
{
    public function calculateRawMaterialRequirements(Product $product, $quantity)
    {
        $rawMaterials = $product->rawMaterials;
        $requirements = [];

        foreach ($rawMaterials as $rawMaterial) {
            $requiredQuantity = $rawMaterial->pivot->quantity * $quantity;
            $allocatedQuantity = $this->getAllocatedQuantity($product, $rawMaterial);

            // Adjust required quantity based on allocated quantity
            $remainingRequiredQuantity = max(0, $requiredQuantity - $allocatedQuantity);

            $warehouses = $rawMaterial->warehouses;

            $materialInfo = [];

            foreach ($warehouses as $warehouse) {
                $availableQuantity = $warehouse->remainder;

                if ($remainingRequiredQuantity > 0 && $availableQuantity > 0) {
                    $quantityToUse = min($remainingRequiredQuantity, $availableQuantity);

                    $materialInfo[] = [
                        'warehouse_id' => $warehouse->id,
                        'material_name' => $rawMaterial->material_name,
                        'qty' => $quantityToUse,
                        'price' => number_format($warehouse->price, 2),
                    ];

                    $remainingRequiredQuantity -= $quantityToUse;
                }
            }

            if (!empty($materialInfo)) {
                $requirements[] = $materialInfo;
            }
        }

        return [$requirements];
    }


    private function getAllocatedQuantity(Product $product, $rawMaterial)
    {
        return MaterialAllocation::where('product_id', $product->id)
            ->where('material_id', $rawMaterial->id)
            ->sum('quantity');
    }

    private function getAvailableQuantity($rawMaterial)
    {
        $warehouses = $rawMaterial->warehouses;

        $availableQuantity = 0;

        foreach ($warehouses as $warehouse) {
            $availableQuantity += $warehouse->remainder;
        }

        return $availableQuantity;
    }

    public function allocateRawMaterials(Product $product, $quantity)
    {
        $rawMaterials = $product->rawMaterials;

        foreach ($rawMaterials as $rawMaterial) {
            $requiredQuantity = $rawMaterial->pivot->quantity * $quantity;
            $availableQuantity = $this->getAvailableQuantity($rawMaterial);

            $shortage = max(0, $requiredQuantity - $availableQuantity);

            if ($shortage > 0) {
                // Allocate the shortage quantity
                MaterialAllocation::create([
                    'product_id' => $product->id,
                    'material_id' => $rawMaterial->id,
                    'quantity' => $shortage,
                ]);
            }
        }
    }
}
