<?php

use App\Exports\JournalExport;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Run app as user
auth()->loginUsingId(1);

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('stores', [StoreController::class, 'index'])->name('stores.index');
    Route::get('journal', JournalController::class)->name('journals.index');
});
