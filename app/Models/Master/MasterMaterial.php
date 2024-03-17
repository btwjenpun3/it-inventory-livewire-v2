<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMaterial extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function satuan()
    {
        return $this->belongsTo(MasterSatuan::class);
    }

    public function materialType()
    {
        return $this->belongsTo(MasterMaterialType::class);
    }
}
