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


/*
//This route to create storage link only
Route::get('/symlink', function () {
   $target =$_SERVER['DOCUMENT_ROOT'].'/../laravel/storage/app/public';
   $link = $_SERVER['DOCUMENT_ROOT'].'/storage';
   echo 'Target '.$target;
   echo 'Link '.$link;
   symlink($target, $link);
   echo "Done";
});

//This route to run passport:install
Route::get('/installpassport', function () {
    Artisan::call('passport:install');
});
*/


Route::get('/', function () {
    return view('layouts.guest');
});

Route::view('/{any}', 'layouts.guest')->where('any', '.*');

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
