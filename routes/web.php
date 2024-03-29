<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'surveys'])->name('home');
    Route::get('/survey/{id}', [HomeController::class, 'survey'])->name('survey');
    Route::post('/survey/{id}', [HomeController::class, 'surveySave'])->name('survey.save');
    //Route::get('/surveys', [HomeController::class, 'surveys'])->name('surveys');
});
