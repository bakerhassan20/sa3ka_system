<?php

use App\Http\Controllers\DocumentController;
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


Route::group(['middleware' => ['auth']], function() {
    Route::get('/', function () {
        return view('home');
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
    Route::post('/update-profile', [App\Http\Controllers\HomeController::class, 'profile_update'])->name('profile.update');
    Route::post('/update-password', [App\Http\Controllers\HomeController::class, 'update_password'])->name('profile.update-password');


    Route::resource('roles','App\Http\Controllers\RoleController');
    Route::resource('users','App\Http\Controllers\UserController');
    Route::resource('documents','App\Http\Controllers\DocumentController');
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::resource('entities','App\Http\Controllers\EntitieController');

    Route::get('/getEntities/{type}', [DocumentController::class, 'getEntities']);



    });
require __DIR__.'/auth.php';
