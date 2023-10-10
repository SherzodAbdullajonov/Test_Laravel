<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }


    public function getProducts()
    {
        // Define the product requirements grouped by product name
        $productRequirements = [
            'Koylak' => 30,
            'Shim' => 20,
        ];

        $result = [];

        foreach ($productRequirements as $productName => $quantity) {
            // Find the product by name
            $product = Product::where('product_name', $productName)->first();

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            // Calculate raw material requirements for the product
            $materials = $this->productService->calculateRawMaterialRequirements($product, $quantity);

            // Calculate the total available quantity of raw materials
            $availableRawMaterials = $this->productService->getAvailableQuantity($product);

            // Calculate the total required quantity for the product
            $requiredQuantity = $quantity * count($materials);

            // Check if there are enough raw materials
            if ($availableRawMaterials >= $requiredQuantity) {
                $this->productService->allocateRawMaterials($product, $quantity);

                $productDetails = [
                    'product_name' => $productName,
                    'product_qty' => $quantity,
                    'product_materials' => $materials,
                ];

                $result[] = $productDetails;
            } else {
                // Calculate the shortage of raw materials
                $shortage = $requiredQuantity - $availableRawMaterials;

                $productShortage = [
                    'product_name' => $productName,
                    'product_qty' => $quantity,
                    'shortage_qty' => $shortage,
                ];

                $result[] = $productShortage;
            }
        }

        return response()->json(['result' => $result]);
    }
}
