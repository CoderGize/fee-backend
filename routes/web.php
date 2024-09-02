<?php

use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\Web\admin\Authcontroller;
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
    Route::post('/update_landing', [LandingWebController::class, 'update_landing']);

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
