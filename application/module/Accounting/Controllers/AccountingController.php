<?php

namespace Module\Accounting\Controllers;

use App\Http\Controllers\Controller;

class AccountingController extends Controller
{
    public function index(){
        return view('module::Accounting.views.index');
    }

    public function sales(){
        return view('module::Accounting.views.sales');
    }
}
