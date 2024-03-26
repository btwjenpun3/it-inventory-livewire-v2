<?php

namespace App\Models\Marketing;

use App\Livewire\Ppic\MaterialRequest;
use App\Models\Bom\BomProductionDetailSubtotal;
use App\Models\Master\MasterBuyer;
use App\Models\Master\MasterCurrency;
use App\Models\Master\MasterPic;
use App\Models\Master\MasterSatuan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function buyer()
    {
        return $this->belongsTo(MasterBuyer::class, 'buyer_id');
    }

    public function currency()
    {
        return $this->belongsTo(MasterCurrency::class, 'currency_id');
    }

    public function unit()
    {
        return $this->belongsTo(MasterSatuan::class, 'unit_id');
    }

    public function pic()
    {
        return $this->belongsTo(MasterPic::class, 'pic_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'marketing_id', 'id');
    }

    public function subTotals()
    {
        return $this->hasMany(BomProductionDetailSubtotal::class, 'marketing_id');
    }
}
