<?php

use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\Web\admin\Authcontroller;
use App\Http\Controllers\Web\Admin\CategoriesController;
use App\Http\Controllers\Web\admin\CollocationController;
use App\Http\Controllers\Web\admin\Designer\DesignerController;
use App\Http\Controllers\Web\Admin\OrderController;
use App\Http\Controllers\Web\admin\PaymentController;
use App\Http\Controllers\Web\Admin\ProductController;
use App\Http\Controllers\Web\Admin\SubcategoriesController;
use App\Http\Controllers\Web\Admin\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\Content\LandingWebController;
use App\Http\Controllers\Web\Content\CarouselWebController;
use App\Http\Controllers\Web\Content\ShowroomWebController;
use App\Http\Controllers\Web\Content\AboutWebController;
use App\Http\Controllers\Web\Content\InstagridWebController;
use App\Http\Controllers\Web\Content\TestimonialWebController;
use App\Http\Controllers\Web\Content\SocialWebController;
use App\Http\Controllers\Web\Content\DownloadWebController;
use App\Http\Controllers\Web\Content\BlogWebController;
use App\Http\Controllers\Web\Content\ContactWebController;
use App\Http\Controllers\Web\Content\BecomeDesignerController;
use App\Http\Controllers\Web\Content\ShowWebController;
use App\Http\Controllers\Web\Content\DesignLetterWebController;
use App\Http\Controllers\Web\Content\NewsLetterWebController;

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
    Route::get('/admin/payments', [PaymentController::class, 'index'])->name('admin.payments.index');
    Route::put('/admin/payments/update-status/{id}', [PaymentController::class, 'updateStatus'])->name('admin.payments.updateStatus');
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::put('/admin/orders/update-status/{id}', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/delete/{id}', [UserController::class, 'delete'])->name('admin.users.delete');
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

   // Product routes
   Route::prefix('admin/products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/create', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::get('/{id}/show', [ProductController::class, 'show'])->name('admin.products.show');
    Route::put('/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    // Route for fetching subcategories by selected categories
    Route::get('/subcategories', [ProductController::class, 'getSubcategoriesByCategories'])->name('admin.products.getSubcategories');

});


});


// Login route
Route::get('login', function () {
    return view('admin.login');
})->name('login.web');

Route::post('/login', [Authcontroller::class, 'login'])->name('login');
Route::get('callback',[MyFatoorahController::class,'callback'])->name('myfatoorah.callback');

Route::prefix('/admin/web')->group(function ()
{
    //{{ Landing }}
    Route::get('/show_landing', [LandingWebController::class, 'show_landing']);
    Route::post('/add_landing', [LandingWebController::class, 'add_landing']);
    Route::post('/update_landing/{id}', [LandingWebController::class, 'update_landing']);
    Route::get('/delete_landing/{id}', [LandingWebController::class, 'delete_landing']);

    //{{ Carousel }}
    Route::get('/show_carousel', [CarouselWebController::class, 'show_carousel']);
    Route::post('/add_carousel', [CarouselWebController::class, 'add_carousel']);
    Route::get('/delete_carousel/{id}', [CarouselWebController::class, 'delete_carousel']);
    Route::post('/update_carousel/{id}', [CarouselWebController::class, 'update_carousel']);

    //{{ Showroom }}
    Route::get('/show_showroom', [ShowroomWebController::class, 'show_showroom']);
    Route::post('/add_showroom', [ShowroomWebController::class, 'add_showroom']);
    Route::get('/delete_showroom', [ShowroomWebController::class, 'delete_showroom']);

    //{{ About }}
    Route::get('/show_about', [AboutWebController::class, 'show_about']);
    Route::post('/update_about', [AboutWebController::class, 'update_about']);

    //{{ Instagram Grid }}
    Route::get('/show_instagrid', [InstagridWebController::class, 'show_instagrid']);
    Route::post('/add_instagrid', [InstagridWebController::class, 'add_instagrid']);
    Route::get('/delete_instagrid/{id}', [InstagridWebController::class, 'delete_instagrid']);

    //{{ Customer Testimonials & Designers Story }}
    Route::get('/show_testimonial', [TestimonialWebController::class, 'show_testimonial']);
    Route::post('/add_testimonial', [TestimonialWebController::class, 'add_testimonial']);
    Route::post('/update_testimonial/{id}', [TestimonialWebController::class, 'update_testimonial']);
    Route::get('/delete_testimonial/{id}', [TestimonialWebController::class, 'delete_testimonial']);
    Route::get('/show_designer_story', [TestimonialWebController::class, 'show_designer_story']);
    Route::post('/add_designer_story', [TestimonialWebController::class, 'add_designer_story']);
    Route::post('/update_designer_story/{id}', [TestimonialWebController::class, 'update_designer_story']);
    Route::get('/delete_designer_story/{id}', [TestimonialWebController::class, 'delete_designer_story']);

    // {{ App Download Links }}
    Route::get('/show_download', [DownloadWebController::class, 'show_download']);
    Route::post('/update_download', [DownloadWebController::class, 'update_download']);

    // {{ Blog }}
    Route::get('/show_blog', [BlogWebController::class, 'show_blog']);
    Route::post('/add_blog', [BlogWebController::class, 'add_blog']);
    Route::get('/update_blog/{id}', [BlogWebController::class, 'update_blog']);
    Route::post('/update_blog_confirm/{id}', [BlogWebController::class, 'update_blog_confirm']);
    Route::get('/delete_blog/{id}', [BlogWebController::class, 'delete_blog']);

    // {{ Contact }}
    Route::get('/show_contact', [ContactWebController::class, 'show_contact']);
    Route::post('/update_contact', [ContactWebController::class, 'update_contact']);

    // {{ Become a Designer Section }}
    Route::get('/show_become_designer', [BecomeDesignerController::class, 'show_become_designer']);
    Route::post('/update_become_designer', [BecomeDesignerController::class, 'update_become_designer']);
    Route::post('/add_become_designer', [BecomeDesignerController::class, 'add_become_designer']);
    Route::get('/delete_become_designer/{id}', [BecomeDesignerController::class, 'delete_become_designer']);

    // {{ NewsLetter }}
    Route::get('/show_newsletter', [NewsLetterWebController::class, 'show_newsletter']);
    Route::get('/delete_newsletter/{id}', [NewsLetterWebController::class, 'delete_newsletter']);
    Route::post('/export-subscriber', [NewsLetterWebController::class, 'export']);

    // {{ Designers Advert  }}
    Route::get('/show_designletter', [DesignLetterWebController::class, 'show_designletter']);
    Route::get('/delete_designletter/{id}', [DesignLetterWebController::class, 'delete_designletter']);
    Route::post('/export-designletter', [DesignLetterWebController::class, 'export']);

    // {{ Social }}
    Route::get('/show_social',[SocialWebController::class,'show_social']);
    Route::post('/update_social_confirm/{id}',[SocialWebController::class,'update_social_confirm']);
    Route::get('/update_social/{id}',[SocialWebController::class,'update_social']);

    // {{ Show }}
    Route::post('/blog_show', [ShowWebController::class, 'blog_show']);
    Route::post('/testimonial_show', [ShowWebController::class, 'testimonial_show']);
    Route::post('/carousel_show', [ShowWebController::class, 'carousel_show']);
    Route::post('/designer_testimonial_show', [ShowWebController::class, 'designer_destimonial_show']);
    Route::post('/showroom_show', [ShowWebController::class, 'showroom_show']);

});
