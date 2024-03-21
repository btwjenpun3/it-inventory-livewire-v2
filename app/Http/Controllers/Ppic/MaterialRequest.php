<?php

namespace App\Http\Controllers\Ppic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialRequest extends Controller
{
    public function materialRequest()
    {
        return view('pages.ppic.material-request');
    }
}
