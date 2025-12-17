<?php

namespace Module\Inventory\Controllers;

use App\Http\Controllers\Controller;

class AccountingController extends Controller
{
    public function index(){
        return view('module::Accounting.views.index');
    }
}
