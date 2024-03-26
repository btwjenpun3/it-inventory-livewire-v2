<?php

namespace App\Models\Purchasing;

use App\Models\Marketing\Marketing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoSupplier extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function op()
    {
        return $this->belongsTo(Marketing::class, 'marketing_id');
    }
}
