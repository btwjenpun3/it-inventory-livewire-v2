<?php

namespace App\Models\Bom;

use App\Models\Master\MasterMaterialType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomProduction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(BomProductionDetail::class, 'bom_production_id');
    }

    public function material()
    {
        return $this->belongsTo(MasterMaterialType::class, 'material_type_id');
    }
}
