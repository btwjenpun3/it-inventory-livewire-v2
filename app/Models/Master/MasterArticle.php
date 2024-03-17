<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterArticle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function buyer()
    {
        return $this->belongsTo(MasterBuyer::class, 'buyer_id');
    }
}
