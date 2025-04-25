<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppHealthMealController extends Controller
{
    public function index()
    {
        return view('pages.health-meal.index');
    }
}
