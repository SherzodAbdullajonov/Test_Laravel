<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['product_name', 'product_code']; 
    
    public function rawMaterials()
    {
        return $this->belongsToMany(RawMaterial::class, 'product_raw_material', 'product_id', 'material_id')
            ->withPivot('quantity');
    }
}
