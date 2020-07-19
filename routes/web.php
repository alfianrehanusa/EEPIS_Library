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
    Route::post('buku/umum/add', 'Buku\UmumController@add');
    Route::post('buku/umum/edit', 'Buku\UmumController@edit');
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
    Route::post('buku/jurnal/add', 'Buku\JurnalController@add');
    Route::post('buku/jurnal/edit', 'Buku\JurnalController@edit');
    //Majalah
    Route::get('buku/majalah', 'Buku\MajalahController@index');
    Route::get('buku/majalah/detail/{id}', 'Buku\MajalahController@detail');
    Route::post('buku/majalah/add', 'Buku\MajalahController@add');
    Route::post('buku/majalah/edit', 'Buku\MajalahController@edit');
    //Proyek Akhir/Tugas Akhir
    Route::get('buku/pa_ta', 'Buku\PaTaController@index');
    Route::get('buku/pa_ta/detail/{id}', 'Buku\PaTaController@detail');
    Route::post('buku/pa_ta/add', 'Buku\PaTaController@add');
    Route::post('buku/pa_ta/edit', 'Buku\PaTaController@edit');

    //PEMINJAMAN
    //Daftar Pemesanan
    Route::get('peminjaman/pesan', 'Peminjaman\PesanController@index');
    Route::post('peminjaman/pesan/add', 'Peminjaman\PesanController@add');
    Route::post('peminjaman/pesan/edit', 'Peminjaman\PesanController@edit');
    Route::post('peminjaman/pesan/pinjam', 'Peminjaman\PesanController@pinjam');
    //Daftar Peminjaman
    Route::get('peminjaman/pinjam', 'Peminjaman\PinjamController@index');
    Route::post('peminjaman/pinjam/add', 'Peminjaman\PinjamController@add');
    Route::post('peminjaman/pinjam/edit', 'Peminjaman\PinjamController@edit');
    Route::post('peminjaman/pinjam/kembali', 'Peminjaman\PinjamController@kembali');

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
    //Karyawan
    Route::get('user/karyawan', 'User\KaryawanController@index');
    Route::post('user/karyawan/read', 'User\KaryawanController@read');
    Route::post('user/karyawan/add', 'User\KaryawanController@add');
    Route::post('user/karyawan/edit', 'User\KaryawanController@edit');
    Route::post('user/karyawan/delete', 'User\KaryawanController@delete');

    //User Admin
    Route::get('useradmin', 'UseradminController@index');
    Route::post('useradmin/read', 'UseradminController@read');
    Route::post('useradmin/add', 'UseradminController@add');
    Route::post('useradmin/edit', 'UseradminController@edit');
    Route::post('useradmin/delete', 'UseradminController@delete');

    //Laporan
    Route::get('laporan', 'LaporanController@index');

    //Pengaturan
    Route::get('pengaturan', 'PengaturanController@index');
    Route::post('pengaturan/read', 'PengaturanController@read');
    Route::post('pengaturan/edit', 'PengaturanController@edit');

    //GET FILE
    //Cover Buku
    Route::get('file/cover_buku/{filename}', 'FileController@coverBuku');
    //File Ebook
    Route::get('file/ebook/{filename}', 'FileController@ebook');

    //UTIL BOOK
    Route::post('buku/read', 'Buku\UtilController@read');
    Route::post('buku/delete', 'Buku\UtilController@delete');
    Route::post('buku/list_buku', 'Buku\UtilController@listBuku');
    Route::get('buku/list_kategori', 'Buku\UtilController@listKategori');

    //UTIL USER
    Route::post('user/list_user', 'User\UtilController@list');
    Route::get('user/list_prodi', 'User\UtilController@listProdi');

    //UTIL PINJAM
    Route::post('peminjaman/read', 'Peminjaman\UtilController@read');
    Route::post('peminjaman/pesan/delete', 'Peminjaman\UtilController@deletePesan');
    Route::post('peminjaman/pinjam/delete', 'Peminjaman\UtilController@deletePinjam');
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
