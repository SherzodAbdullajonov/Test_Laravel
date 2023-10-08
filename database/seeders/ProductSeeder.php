<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'product_name' => 'Koylak',
                'product_code' => 'KOY001', 
            ],
            [
                'product_name' => 'Shim',
                'product_code' => 'SHI001', 
            ],
        ]);
    }
}
