<?php

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

// Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('stories', 'StoriesController');
});

Route::get('/', 'DashboardController@index')->name('dashboard.index');

// Liên kết biến activeStory trong route -> Khai báo App\Providers\
// Chỉ hiển thị story active
Route::get('/story/{activeStory}', 'DashboardController@show')->name('dashboard.show');
