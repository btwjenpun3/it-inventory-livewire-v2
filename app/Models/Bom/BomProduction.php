<?php

namespace App\Models\Bom;

use App\Models\Marketing\Article;
use App\Models\Master\MasterMaterialType;
use App\Models\Master\MasterSatuan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomProduction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function details()
    {
        return $this->hasMany(BomProductionDetail::class, 'bom_production_id', 'id');
    }

    public function materialType()
    {
        return $this->belongsTo(MasterMaterialType::class, 'material_type_id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }   
    
    public function subTotals()
    {
        return $this->hasMany(BomProductionDetailSubtotal::class, 'bom_production_id', 'id');
    }
}
