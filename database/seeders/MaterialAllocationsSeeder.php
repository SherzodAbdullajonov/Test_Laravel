<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MaterialAllocationsSeeder extends Seeder
{
    public function run()
    {
        
        DB::table('material_allocations')->insert([
            [
                'product_id' => 1,  
                'material_id' => 1, 
                'quantity' => 10,  
            ],
            
        ]);
    }
}
