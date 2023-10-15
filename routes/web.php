<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\homeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\TemporaryController;

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
    return view('welcome');
});


// ********************************
// ************ Admin routes 
// ********************************
Route::group(['prefix' => 'admin'], function () {


    // for guest means customer user 
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    // for authenticated users like who login 
    Route::group(['middleware' =>  'admin.auth'], function () {
        Route::get('/dashboard', [homeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [homeController::class, 'logout'])->name('admin.logout');

        // categories routes 
        Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');


        // temporary uplaoding files 
        Route::post('/temporary', [TemporaryController::class, 'create'])->name('admin.temporaryImage.create');





        // for getting slugs 
        Route::get('/getSlug', function (Request $request) {
            $slug = "";
            if (!empty($request->title)) {
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug,
            ]);
        })->name('getSlug');
    });
});
