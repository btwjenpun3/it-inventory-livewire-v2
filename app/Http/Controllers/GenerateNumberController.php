<?php

namespace App\Http\Controllers;

use App\Models\Marketing\Marketing;
use App\Models\Purchasing\PoSupplier;
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
            case('po-supplier') :
                $year = Carbon::now()->year;
                $getLastNumber = PoSupplier::where('po_no', 'LIKE', '%/POSUPP/' . $year)->latest()->first();     
                if(isset($getLastNumber)) {
                    $lastNumber = (int) explode('/', $getLastNumber->po_no)[0];
                    $prefix = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
                } else {
                    $prefix = '00001';
                }   
                return $prefix . '/POSUPP/' . $year;
            break;
        }
    }
}
