<?php

namespace App\Http\Controllers;

use DB;

class LaporanController extends Controller{

    function index(){
        $data = DB::table('peminjaman AS A')
        ->select('*', 'A.id AS id_pinjam')
        ->join('user as B', 'A.id_user', '=', 'B.id')
        ->join('buku AS C', 'A.id_buku', '=', 'C.id')
        ->where('A.status' , '=', '4')
        ->orWhere('A.status' , '=', '5')
        ->orderBy('A.id', 'DESC')
        ->get();

        return view('page.laporan', compact('data'));
    }

}
