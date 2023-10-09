<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
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
        // Define the product requirements
        $productRequirements = [
            [
                'product_name' => 'Koylak',
                'quantity' => 30,
            ],
            [
                'product_name' => 'Shim',
                'quantity' => 20,
            ],
        ];

        $result = [];

        foreach ($productRequirements as $requirement) {
            // Find the product by name
            $product = Product::where('product_name', $requirement['product_name'])->first();

            // Check if the product exists
            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            $quantity = $requirement['quantity'];

            // Calculate raw material requirements for the product
            $materials = $this->productService->calculateRawMaterialRequirements($product, $quantity);

            // Construct the product details array
            $productDetails = [
                'product_name' => $product->product_name,
                'product_qty' => $quantity,
                'product_materials' => $materials,
            ];

            // Add the product details to the result array
            $result[] = $productDetails;

            // Allocate raw materials for the requested quantity of the product
            $this->productService->allocateRawMaterials($product, $quantity);
        }

        return response()->json(['result' => $result]);
    }
}
