<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BankManagerController extends Controller
{
    public function index()
    {
        return view('pages.bank-manager.index');
    }
}
