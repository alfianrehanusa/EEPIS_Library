<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Peminjaman;
use App\Models\Pengaturan;
use App\Models\Buku;
use DB;
use Exception;

class PesanController extends Controller{

    function index(){
        $batas_waktu = Pengaturan::where('id', '=', '1')->first();
        $batas_waktu = $batas_waktu->nilai;

        $data = DB::table('peminjaman AS A')
        ->select('*', 'A.id AS id_pinjam')
        ->join('user as B', 'A.id_user', '=', 'B.id')
        ->join('buku AS C', 'A.id_buku', '=', 'C.id')
        ->where('A.status' , '=', '1')
        ->where('A.tgl_pesan', '>', date('Y-m-d', strtotime("-" . $batas_waktu . " days")))
        ->orderBy('A.tgl_pesan', 'DESC')
        ->get();

        return view('page.peminjaman.pesan', compact('data', 'batas_waktu'));
    }

    function pinjam(Request $request){
        try{
            DB::beginTransaction();

            //ubah status menjadi dipinjam
            $data = Peminjaman::find($request->input('id'));
            $id_buku = $data->id_buku;
            $data->tgl_pinjam = date('Y-m-d');
            $data->status = '3';
            $data->save();

            //pengurangan jumlah buku
            $data = Buku::where('id', '=', $id_buku)
                ->where('jumlah', '>', 0)->first();
            if(!$data){
                return response()->json(array('status' => 'failed', 'reason' => 'Stok buku kosong!'));
            }
            $data->jumlah = $data->jumlah - 1;
            $data->save();

            DB::commit();
            return response()->json(array('status' => 'success', 'reason' => 'Proses berhasil.'));
        }catch(Exception $e){
            DB::rollback();
            return response()->json(array('status' => 'failed', 'reason' => 'Kesalahan sistem!'));
        }
    }

}
