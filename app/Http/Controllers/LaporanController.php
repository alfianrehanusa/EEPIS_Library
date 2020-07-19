<?php

namespace App\Http\Controllers;

use DB;
use Request;

class LaporanController extends Controller{

    function index(){
        $data = DB::table('peminjaman AS A')
        ->select('*', 'A.id AS id_pinjam')
        ->join('user as B', 'A.id_user', '=', 'B.id')
        ->join('buku AS C', 'A.id_buku', '=', 'C.id')
        ->join('prodi AS D', 'B.prodi', '=', 'D.id');

        if(Request::get('name') && Request::get('value')){
            if(Request::get('name') == 'kategori_buku'){
                $data = $data->where('C.type_buku', '=', Request::get('value'));
            }
            else if(Request::get('name') == 'prodi'){
                $data = $data->where('B.prodi', '=', Request::get('value'));
            }
        }
        if(Request::get('filter')){
            if(Request::get('filter') == 'all'){
                $data = $data->whereIn('A.status', [4, 5]);
            }
            else{
                $data = $data->where('A.status' , '=', Request::get('filter'));
            }
        }
        else{
            $data = $data->whereIn('A.status', [4, 5]);
        }

        $data = $data->orderBy('A.id', 'DESC')
        ->get();
        return view('page.laporan', compact('data'));
    }

}
