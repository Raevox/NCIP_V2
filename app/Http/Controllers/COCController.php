<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class COCController extends Controller
{

    public function showForm()
    {
        return view('applicant.coc.coc_application-form');
    }
}
