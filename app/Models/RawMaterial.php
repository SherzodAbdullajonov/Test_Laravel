<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['material_name'];

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class, 'material_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_raw_material', 'material_id', 'product_id')
            ->withPivot('quantity');
    }
}
