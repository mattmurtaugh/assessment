<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Store;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::with('brand')->get();

        return view('stores.index', compact('stores'));

    }
}
