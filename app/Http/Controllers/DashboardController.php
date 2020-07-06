<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Ebook;
use App\Models\User;

use DB;

class DashboardController extends Controller{

    function index(){

        $buku_dipinjam = Peminjaman::selectRaw('count(id) AS buku_dipinjam')
            ->where('tgl_pinjam', '=', date('Y-m-d'))
            ->where('status', '=', '3')
            ->first()->buku_dipinjam;

        $jumlah_buku = Buku::selectRaw('count(id) AS jumlah_buku')
        ->first()->jumlah_buku;

        $jumlah_ebook = Ebook::selectRaw('count(id) AS jumlah_ebook')
        ->first()->jumlah_ebook;

        $jumlah_user = User::selectRaw('count(id) AS jumlah_user')
        ->first()->jumlah_user;

        $total_pinjam_bulan = array_fill(0, 12, 0);
        $data = Peminjaman::selectRaw('MONTH(tgl_pinjam) AS month, COUNT(tgl_pinjam) AS count')
            ->where(DB::raw('YEAR(tgl_pinjam)'), '=', date('Y'))
            ->groupBy(DB::raw('MONTH(tgl_pinjam)'))
            ->get();
        foreach ($data as $key) {
            $total_pinjam_bulan[($key->month)-1] = $key->count;
        }

        $status_pengembalian = Peminjaman::selectRaw('count(status) AS status_pengembalian')
            ->where('status' ,'=', '4')
            ->orWhere('status' ,'=', '5')
            ->groupBy('status')
            ->orderBy('status', 'DESC')
            ->get();

<<<<<<< HEAD
            if($status_pengembalian->isNotEmpty()){
                $key1 = 0;
                $key2 = 0;
                if (isset($status_pengembalian[0])){
                    $key1 = $status_pengembalian[0]->status_pengembalian;
                }
                if (isset($status_pengembalian[1])){
                    $key2 = $status_pengembalian[1]->status_pengembalian;
                }
                $status_pengembalian = array(
                    $key1, $key2
                );
            }
            else{
                $status_pengembalian = array(0, 0);
            }
=======
        if($status_pengembalian->isNotEmpty()){
            $status_pengembalian = array(
                $status_pengembalian[0]->status_pengembalian, $status_pengembalian[1]->status_pengembalian
            );
        }
        else{
            $status_pengembalian = array(0,0);
        }
>>>>>>> bb407e6b6cc2f424f0f32723da9dee9ad8c1d4a7

        return view('page.dashboard', compact('buku_dipinjam', 'jumlah_buku',
            'jumlah_ebook', 'jumlah_user', 'total_pinjam_bulan', 'status_pengembalian'));
    }

}
