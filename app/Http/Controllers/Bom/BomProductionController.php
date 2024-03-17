<?php

namespace App\Http\Controllers\Bom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BomProductionController extends Controller
{
    public function bomProduction()
    {
        return view('pages.bom.bom-production');
    }
}
