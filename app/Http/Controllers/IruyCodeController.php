<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IruyCodeController extends Controller
{
    //Pagina principal de todas as aplicações
    public function welcome()
    {
        return view('pages.iruycode.welcome');
    }
}
