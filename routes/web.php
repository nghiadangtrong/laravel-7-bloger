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
// :slug => Sử dụng column slug để hiển thị thay cho column id (Mặc định)
Route::get('/story/{activeStory:slug}', 'DashboardController@show')->name('dashboard.show');

Route::get('/mail', 'DashboardController@email')->name('dashboard.email');

Route::namespace('Admin')
    ->prefix('admin')
    ->middleware([
        'auth', 
        \App\Http\Middleware\CheckAdmin::class
    ])
    ->group(function () {
        Route::get('/deleted-stories', 'StoriesController@index')->name('admin.stories.index');
        Route::patch('/restore/{deletedStory}', 'StoriesController@restore')->name('admin.stories.restore');
        Route::delete('/force-delete/{deletedStory}', 'StoriesController@forceDelete')->name('admin.stories.focusDelete');
    });