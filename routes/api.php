<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'ApiController@login');
Route::post('/cek_token', 'ApiController@checkToken');

Route::group(['middleware' => ['CheckTokenApi']], function () {
    Route::get('/list_buku', 'ApiController@listBuku');

    Route::post('/pesan', 'ApiController@pesan');
    Route::get('/list_pesan', 'ApiController@listPesan');

    Route::get('/list_pinjam', 'ApiController@listPinjam');

    Route::get('/riwayat', 'ApiController@riwayat');
});

//FILE
Route::get('/file/cover_buku/{token}/{filename}', 'ApiController@coverBuku');
