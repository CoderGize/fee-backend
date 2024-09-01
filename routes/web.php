<?php

use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\Web\admin\Authcontroller;
use App\Http\Controllers\Web\admin\Designer\DesignerController;
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

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/admin', function () {
        return view('admin.home');
    })->name('admin.home');

    Route::get('/admin/designers', [DesignerController::class, 'index'])->name('admin.designer.index');
    Route::get('/admin/designers/create', [DesignerController::class, 'create'])->name('admin.designer.create');
    Route::post('/admin/designers/store', [DesignerController::class,  'store'])->name('admin.designer.store');
    Route::get('admin/designers/copy/{id}', [DesignerController::class, 'copy'])->name('admin.designer.copy');

});


// Login route
Route::get('login', function () {
    return view('admin.login');
})->name('login.web');

Route::post('/login', [Authcontroller::class, 'login'])->name('login');
Route::get('callback',[MyFatoorahController::class,'callback'])->name('myfatoorah.callback');
