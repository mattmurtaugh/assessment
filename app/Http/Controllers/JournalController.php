<?php

namespace App\Http\Controllers;

class JournalController extends Controller
{
    public function __invoke()
    {
        return view('journals.index');
    }
}
