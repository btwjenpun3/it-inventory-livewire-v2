<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterController extends Controller
{    
    public function buyer()
    {
        return view('pages.master.master-buyer');
    }

    public function material()
    {
        return view('pages.master.master-material');
    }

    public function materialType()
    {
        return view('pages.master.master-material-type');
    }

    public function satuan()
    {
        return view('pages.master.master-satuan');
    }

    public function account()
    {
        return view('pages.master.master-account');
    }

    public function jenisBc()
    {
        return view('pages.master.master-jenis-bc');
    }

    public function group()
    {
        return view('pages.master.master-group');
    }

    public function purchaseOrder()
    {
        return view('pages.master.master-purchase-order');
    }

    public function tujuan()
    {
        return view('pages.master.master-tujuan');
    }

    public function currency()
    {
        return view('pages.master.master-currency');
    }

    public function pic()
    {
        return view('pages.master.master-pic');
    }

    public function supplier()
    {
        return view('pages.master.master-supplier');
    }
}