<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductRawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Product: Shirt
        $shirt = Product::where('product_name', 'Koylak')->first();
        $shirt->rawMaterials()->attach([
            1 => ['quantity' => 24],  // Mato
            2 => ['quantity' => 150], // Tugma
            3 => ['quantity' => 300], // Ip
        ]);

        // Product: Pants
        $pants = Product::where('product_name', 'Shim')->first();
        $pants->rawMaterials()->attach([
            1 => ['quantity' => 28],  // Mato
            3 => ['quantity' => 300], // Ip
            4 => ['quantity' => 20],  // Zamok
        ]);
    }
}
