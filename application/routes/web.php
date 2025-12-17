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
  /**
     * Route Property Custom
     * key => Group Name
     * title => Route Custom Title
     * show => is it show in any menu (Value: Yes, No)
     * position =>  (Value: Left, Right, Top, Bottom)
     * show_for => Which Show Menu After Request Url
     * show_as => shwo as Routegroup Show as EX: Permission, User, All (Value: Yes, No)
     * param => Set single or multiple parameter As Array
     * icon => use font awesome icon
*/

Route::get('/404', ['uses' => 'App\Http\Controllers\HomeController@error404'])->name('404');
Auth::routes();
Route::get('/', function () {
    return view('welcome');
});

include_once 'backend/backend.php';
include_once 'module.php';


Route::get('/upload/routelist', [App\Http\Controllers\HomeController::class, 'uploadRoutes'])->name('upload_routelist');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
