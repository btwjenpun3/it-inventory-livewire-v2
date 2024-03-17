<?php

namespace App\Http\Controllers;

use App\Models\Marketing\Marketing;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class GenerateNumberController extends Controller
{
    public function generateNumber($code)
    {        
        $year = Carbon::now()->format('Y');
        switch($code) {
            case('op') :
                $lastId = Marketing::orderby('id', 'desc')->first();
                $prefix = sprintf('%05d', $lastId->id + 1);
                $generate = $prefix . '/' . 'OP/' . $year;
                return $generate;
            break;
        }
    }
}
