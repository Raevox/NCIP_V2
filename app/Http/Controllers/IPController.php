<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IPController extends Controller
{
    public function index()
    {
        return view('ip.dashboard'); // Or just return a placeholder
    }
}
