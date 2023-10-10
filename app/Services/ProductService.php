<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Models\RawMaterial;
use App\Models\MaterialAllocation;


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

    public function getAvailableQuantity($item)
    {
        if ($item instanceof Product) {
            // Calculate available quantity for a product
            $rawMaterials = $item->rawMaterials;
            $availableQuantity = 0;

            foreach ($rawMaterials as $rawMaterial) {
                $warehouses = $rawMaterial->warehouses;

                foreach ($warehouses as $warehouse) {
                    $availableQuantity += $warehouse->remainder;
                }
            }

            return $availableQuantity;
        } elseif ($item instanceof RawMaterial) {
            // Calculate available quantity for a raw material
            $warehouses = $item->warehouses;
            $availableQuantity = 0;

            foreach ($warehouses as $warehouse) {
                $availableQuantity += $warehouse->remainder;
            }

            return $availableQuantity;
        }

        return 0;
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
