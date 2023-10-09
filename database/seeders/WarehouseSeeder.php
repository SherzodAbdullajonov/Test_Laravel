<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('warehouses')->insert([
            [
                'material_id' => 1, // Mato
                'remainder' => 12,
                'price' => 1500.00,
            ],
            [
                'material_id' => 1, // Mato
                'remainder' => 12,
                'price' => 1600.00,
            ],
            [
                'material_id' => 3, // Ip
                'remainder' => 40,
                'price' => 500.00,
            ],
            [
                'material_id' => 3, // Ip
                'remainder' => 260,
                'price' => 550.00,
            ],
            [
                'material_id' => 2, // Tugma
                'remainder' => 150,
                'price' => 300.00,
            ],
            [
                'material_id' => 4, // Zamok
                'remainder' => 1000,
                'price' => 2000.00,
            ],
        ]);
    }
}
