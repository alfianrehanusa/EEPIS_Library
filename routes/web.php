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

    //BUKU
    //Umum
    Route::get('buku/umum', 'Buku\UmumController@index');
    Route::get('buku/umum/detail/{id}', 'Buku\UmumController@detail');
    Route::post('buku/umum/read', 'Buku\UmumController@read');
    Route::post('buku/umum/add', 'Buku\UmumController@add');
    Route::post('buku/umum/edit', 'Buku\UmumController@edit');
    Route::post('buku/umum/delete', 'Buku\UmumController@delete');
    //Ebook
    Route::get('buku/ebook', 'Buku\EbookController@index');
    Route::get('buku/ebook/detail/{id}', 'Buku\EbookController@detail');
    Route::post('buku/ebook/read', 'Buku\EbookController@read');
    Route::post('buku/ebook/add', 'Buku\EbookController@add');
    Route::post('buku/ebook/edit', 'Buku\EbookController@edit');
    Route::post('buku/ebook/delete', 'Buku\EbookController@delete');
    //Jurnal
    Route::get('buku/jurnal', 'Buku\JurnalController@index');
    Route::get('buku/jurnal/detail/{id}', 'Buku\JurnalController@detail');
    Route::post('buku/jurnal/read', 'Buku\JurnalController@read');
    Route::post('buku/jurnal/add', 'Buku\JurnalController@add');
    Route::post('buku/jurnal/edit', 'Buku\JurnalController@edit');
    Route::post('buku/jurnal/delete', 'Buku\JurnalController@delete');
    //Majalah
    Route::get('buku/majalah', 'Buku\MajalahController@index');
    Route::get('buku/majalah/detail/{id}', 'Buku\MajalahController@detail');
    Route::post('buku/majalah/read', 'Buku\MajalahController@read');
    Route::post('buku/majalah/add', 'Buku\MajalahController@add');
    Route::post('buku/majalah/edit', 'Buku\MajalahController@edit');
    Route::post('buku/majalah/delete', 'Buku\MajalahController@delete');
    //Proyek Akhir/Tugas Akhir
    Route::get('buku/pa_ta', 'Buku\PaTaController@index');
    Route::get('buku/pa_ta/detail/{id}', 'Buku\PaTaController@detail');
    Route::post('buku/pa_ta/read', 'Buku\PaTaController@read');
    Route::post('buku/pa_ta/add', 'Buku\PaTaController@add');
    Route::post('buku/pa_ta/edit', 'Buku\PaTaController@edit');
    Route::post('buku/pa_ta/delete', 'Buku\PaTaController@delete');

    //PEMINJAMAN
    //Daftar Pemesanan
    Route::get('peminjaman/pesan', 'Peminjaman\PesanController@index');
    //Daftar Peminjaman
    Route::get('peminjaman/pinjam', 'Peminjaman\PinjamController@index');

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

    //GET FILE
    //Cover Buku
    Route::get('file/cover_buku/{filename}', 'FileController@index');
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
