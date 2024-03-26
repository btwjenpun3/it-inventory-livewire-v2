<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GenerateNumberController as GenerateNumber;
use Illuminate\Http\Request;

class PurchasingController extends Controller
{
    public function poSupplier()
    {
        $call = new GenerateNumber;
        return view('pages.purchasing.po-supplier', [
            'number' => $call->generateNumber('po-supplier')
        ]);
    }
}
