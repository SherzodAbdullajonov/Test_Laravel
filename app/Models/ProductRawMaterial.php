<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductRawMaterial extends Pivot
{
    use HasFactory;
    protected $table = 'product_raw_material';

    protected $fillable = ['product_id', 'material_id', 'quantity'];
}
