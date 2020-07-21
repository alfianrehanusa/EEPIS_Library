<?php

namespace App\Http\Controllers;

use DB;

class LaporanDendaController extends Controller{

    function index(){
        $data = DB::table('denda_report')
            ->join('user AS A', 'id_user', '=', 'A.id')
            ->join('buku AS B', 'id_buku', '=', 'B.id')
            ->orderBy('tanggal', 'DESC')
            ->get();

        return view('page.laporan_denda', compact('data'));
    }

}
