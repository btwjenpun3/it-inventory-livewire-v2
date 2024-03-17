<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Approval extends Controller
{
    public function index()
    {
        return view('pages.approval.order-production');
    }

    public function listApproved()
    {
        return view('pages.approval.list-approved');
    }

    public function listRejected()
    {
        return view('pages.approval.list-rejected');
    }
}
