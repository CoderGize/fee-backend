<?php

use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\Web\admin\Authcontroller;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('admin.home');
})->middleware('auth');

// Login route
Route::get('login', function () {
    return view('admin.login');
})->name('login.web');

Route::post('/login', [Authcontroller::class, 'login'])->name('login');
Route::get('callback',[MyFatoorahController::class,'callback'])->name('myfatoorah.callback');
