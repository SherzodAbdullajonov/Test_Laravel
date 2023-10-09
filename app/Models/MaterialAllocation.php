<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialAllocation extends Model
{
    use HasFactory;
    protected $table = 'material_allocations';

    protected $fillable = [
        'product_id',
        'material_id',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function material()
    {
        return $this->belongsTo(RawMaterial::class, 'material_id');
    }
}

