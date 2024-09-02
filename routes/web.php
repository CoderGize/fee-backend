<?php

use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\Web\admin\Authcontroller;
use App\Http\Controllers\Web\Admin\CategoriesController;
use App\Http\Controllers\Web\admin\CollocationController;
use App\Http\Controllers\Web\admin\Designer\DesignerController;
use App\Http\Controllers\Web\Admin\SubcategoriesController;
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

    Route::get('/', function () {
        return view('admin.home');
    })->name('admin.home');

    Route::get('/admin/designers', [DesignerController::class, 'index'])->name('admin.designer.index');
    Route::get('/admin/designers/create', [DesignerController::class, 'create'])->name('admin.designer.create');
    Route::post('/admin/designers/store', [DesignerController::class,  'store'])->name('admin.designer.store');
    Route::get('admin/designers/copy/{id}', [DesignerController::class, 'copy'])->name('admin.designer.copy');
    Route::prefix('admin/collections')->group(function () {
        Route::get('/', [CollocationController::class, 'index'])->name('admin.collections.index');
        Route::get('/create', [CollocationController::class, 'create'])->name('admin.collections.create');
        Route::post('/create', [CollocationController::class, 'store'])->name('admin.collections.store');
        Route::get('/{id}', [CollocationController::class, 'edit'])->name('admin.collections.edit');
        Route::put('/{id}', [CollocationController::class, 'update'])->name('admin.collections.update');
        Route::delete('/{id}', [CollocationController::class, 'destroy'])->name('admin.collections.destroy');
    });

    // Category routes
    Route::prefix('admin/categories')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('admin.categories.index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('admin.categories.create');
        Route::post('/create', [CategoriesController::class, 'store'])->name('admin.categories.store');
        Route::get('/{id}', [CategoriesController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/{id}', [CategoriesController::class, 'update'])->name('admin.categories.update');
        Route::delete('/{id}', [CategoriesController::class, 'destroy'])->name('admin.categories.destroy');
    });

    // Subcategory routes
    Route::prefix('admin/subcategories')->group(function(){
        Route::get('/', [SubcategoriesController::class, 'index'])->name('admin.subcategories.index');
        Route::get('/create', [SubcategoriesController::class, 'create'])->name('admin.subcategories.create');
        Route::post('/create', [SubcategoriesController::class, 'store'])->name('admin.subcategories.store');
        Route::get('/{id}', [SubcategoriesController::class, 'edit'])->name('admin.subcategories.edit');
        Route::put('/{id}', [SubcategoriesController::class, 'update'])->name('admin.subcategories.update');
        Route::delete('/{id}', [SubcategoriesController::class, 'destroy'])->name('admin.subcategories.destroy');
    });

});


// Login route
Route::get('login', function () {
    return view('admin.login');
})->name('login.web');

Route::post('/login', [Authcontroller::class, 'login'])->name('login');
Route::get('callback',[MyFatoorahController::class,'callback'])->name('myfatoorah.callback');
