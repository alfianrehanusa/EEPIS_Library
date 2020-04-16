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
Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', 'DashboardController@index');

    //User
    Route::get('user/mahasiswa', 'User\MahasiswaController@index');
    Route::get('user/dosen', 'User\DosenController@index');
    Route::get('user/pustakawan', 'User\PustakawanController@index');

});

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    else{
        return redirect('/login');
    }
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
