<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterLocation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function warehouse()
    {
        return $this->belongsTo(MasterWarehouse::class, 'warehouse_id');
    }

    public function rak()
    {
        return $this->belongsTo(MasterRak::class, 'rak_id');
    }
}
