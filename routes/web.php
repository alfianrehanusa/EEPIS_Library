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

    //USER
    //Mahasiswa
    Route::get('user/mahasiswa', 'User\MahasiswaController@index');
    Route::post('user/mahasiswa/read', 'User\MahasiswaController@read');
    Route::post('user/mahasiswa/add', 'User\MahasiswaController@add');
    Route::post('user/mahasiswa/edit', 'User\MahasiswaController@edit');
    Route::post('user/mahasiswa/delete', 'User\MahasiswaController@delete');
    //Dosen
    Route::get('user/dosen', 'User\DosenController@index');
    Route::post('user/dosen/read', 'User\DosenController@read');
    Route::post('user/dosen/add', 'User\DosenController@add');
    Route::post('user/dosen/edit', 'User\DosenController@edit');
    Route::post('user/dosen/delete', 'User\DosenController@delete');
    //Pustakawan
    Route::get('user/pustakawan', 'User\PustakawanController@index');
    Route::post('user/pustakawan/read', 'User\PustakawanController@read');
    Route::post('user/pustakawan/add', 'User\PustakawanController@add');
    Route::post('user/pustakawan/edit', 'User\PustakawanController@edit');
    Route::post('user/pustakawan/delete', 'User\PustakawanController@delete');

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
