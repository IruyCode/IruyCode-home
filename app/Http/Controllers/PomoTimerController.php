<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PomoTimerController extends Controller
{
    public function index()
    {
        return view('pages.pomo-timer.index');
    }
}
