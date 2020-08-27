<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

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

//Route::get('/', function () { return view('welcome'); });

Route::get('/', function () {
    $date = Carbon::now();
    return view('welcome', compact('date'));
});

Route::resource('/projects', 'ProjectsController');
Route::resource('/users', 'UsersController');
Route::resource('/tasks', 'TasksController');

Route::post('/tasks/post', 'TasksController@store');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/paginate', 'TestController@paginate')->name('paginate');

Auth::routes();

// Test
Route::view('/grocery', 'grocery')->name('grocery');
Route::post('/grocery/post', 'GroceriesController@store');
