<?php

namespace App\Models\Bom;

use App\Livewire\Master\MasterProcurement;
use App\Models\Master\MasterBomLevel;
use App\Models\Master\MasterLocation;
use App\Models\Master\MasterMaterial;
use App\Models\Master\MasterProcurement as MasterMasterProcurement;
use App\Models\Master\MasterSatuan;
use App\Models\Ppic\BomMaterialRequest;
use App\Models\Ppic\MaterialRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomProductionDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function material()
    {
        return $this->belongsTo(MasterMaterial::class, 'material_id');
    }

    public function unit()
    {
        return $this->belongsTo(MasterSatuan::class, 'satuan_id');
    }

    public function location()
    {
        return $this->belongsTo(MasterLocation::class, 'location_id');
    }

    public function level()
    {
        return $this->belongsTo(MasterBomLevel::class, 'level_id');
    }

    public function procurement()
    {
        return $this->belongsTo(MasterMasterProcurement::class, 'procurement_id');
    }
    
}
