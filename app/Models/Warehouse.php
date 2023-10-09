<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $fillable = ['material_id', 'remainder', 'price'];

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class, 'material_id');
    }
}
