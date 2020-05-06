<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use DB;

use App\Models\Peminjaman;
use App\Models\Pengaturan;
use App\Models\Buku;

class ApiController extends Controller{

    function pesan(Request $request){
        try {
            DB::beginTransaction();
            //Pengecekan stok buku
            $data = Buku::find($request->input('id_buku'));
            $buku_pesan = Peminjaman::where('id_buku', '=', $request->input('id_buku'))
                ->where('status', '=', 1)
                ->count();
            $stok_buku = $data->jumlah - $buku_pesan;
            if($stok_buku < 1){
                return response()->json(array('status' => 'failed', 'reason' => 'Stok buku habis!'));
            }

            $data = new Peminjaman;
            $data->id_user = $request->input('id_user');
            $data->id_buku = $request->input('id_buku');
            $data->tgl_pesan = date('Y-m-d');
            $data->status = 1;
            $data->save();

            $batas_waktu = Pengaturan::where('id', '=', '1')->first();
            $batas_waktu = $batas_waktu->nilai;

            DB::commit();
            return response()->json(array(
                'status' => 'success',
                'reason' => 'Pesanan berhasil dilakukan. Silahkan ambil buku sebelum tanggal ' . date("Y-m-d", strtotime('+' . $batas_waktu . " days", strtotime(date('Y-m-d'))))
            ));
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(array('status' => 'failed', 'reason' => 'Kesalahan sistem!'));
        }
    }

}
