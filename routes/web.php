<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

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


Route::get('/', [PageController::class, 'index']);
Route::post('/user/update/{id}', [HomeController::class, 'updateUser']);
Route::post('/user/update-password/{id}', [HomeController::class, 'updatePassword']);

Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => ['admin-auth']], function () {
        Route::get('/', [HomeController::class, 'Adminindex']);
        Route::get('/counsellors/fetch', [HomeController::class, 'displayCounsellors']);
        Route::get('/counsellors', [HomeController::class, 'renderCounsellorsPage']);
        Route::get('/counsellors/add', [HomeController::class, 'renderAddCounsellorsPage']);
        // Route::get('/users', [HomeController::class, 'renderUsersPage']);
        // Route::get('/users/fetch', [HomeController::class, 'displayUsers']);
        Route::get('/counsellor/edit/{id}', [HomeController::class, 'editCounsellor']);
        Route::get('/user/edit/{id}', [HomeController::class, 'editCounsellor']);
        Route::get('/user/view/{id}', [HomeController::class, 'viewUser']);
        Route::post('/counsellors/add', [HomeController::class, 'addCounsellor']);
        Route::post('/counsellor/update', [HomeController::class,'updateCounsellors']);
        Route::post('/counsellor/delete/{id}', [HomeController::class, 'deleteCounsellor']);
        Route::post('/user/delete/{id}', [HomeController::class, 'deleteCounsellor']);        
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/customer', [HomeController::class, 'Customindex']);
Route::get('/customer/users/{domain_id}', [HomeController::class, 'renderUsersPage']);
Route::get('/customer/fetch/users/{domain_id}', [HomeController::class, 'displayUsers']);

Route::get('/customer/user/edit/{id}',[HomeController::class, 'editUsers']);
Route::get('/customer/user/view/{id}',[HomeController::class, 'viewUsers']);
Route::get('/customer/user/add/{domain_id}', [HomeController::class, 'renderAddUsersPage']);

Route::post('/customer/user/update', [HomeController::class, 'updateUsers']);
Route::post('/customer/user/add', [HomeController::class, 'addUser']);
Route::post('/customer/user/delete/{id}',[HomeController::class, 'deleteUsers']);

Route::post('/fetchMessages', [HomeController::class, 'fetch']);
