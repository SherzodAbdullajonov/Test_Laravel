<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('raw_materials')->insert([
            [
                'material_name' => 'Mato',
            ],
            [
                'material_name' => 'Tugma',
            ],
            [
                'material_name' => 'Ip',
            ],
            [
                'material_name' => 'Zamok',
            ],
        ]);
    }
}
