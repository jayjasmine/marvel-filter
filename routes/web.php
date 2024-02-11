<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('app');
});

// Place this at the end of your web.php file
Route::get('/{any}', function () {
  return view('app'); // Replace 'your_main_view' with the name of your main Blade view
})->where('any', '.*');