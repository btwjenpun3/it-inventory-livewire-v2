<?php

namespace App\Models\Marketing;

use App\Models\Bom\BomProduction;
use App\Models\Master\MasterArticle;
use App\Models\Master\MasterSatuan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function unit()
    {
        return $this->belongsTo(MasterSatuan::class, 'unit_id');
    }

    public function bom()
    {
        return $this->hasOne(BomProduction::class, 'article_id', 'id');
    }    

    public function article()
    {
        return $this->belongsTo(MasterArticle::class, 'master_article_id');
    }
}
