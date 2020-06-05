<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Peminjaman;
use App\Models\Pengaturan;
use App\Models\Buku;
use App\Models\Type_buku;
use DB;
use Exception;

class PinjamController extends Controller{

    function index(){
        $batas_waktu = Pengaturan::where('id', '=', '2')->first();
        $batas_waktu = $batas_waktu->nilai;
        $list_type_buku = Type_buku::all();
        $data = DB::table('peminjaman AS A')
        ->select('*', 'A.id AS id_pinjam')
        ->join('user as B', 'A.id_user', '=', 'B.id')
        ->join('buku AS C', 'A.id_buku', '=', 'C.id')
        ->join('type_buku AS D', 'C.type_buku', '=', 'D.id')
        ->where('A.status' , '=', '3')
        ->orderBy('A.tgl_pesan', 'DESC')
        ->get();

        return view('page.peminjaman.pinjam', compact('data', 'batas_waktu', 'list_type_buku'));
    }

    function read(Request $request){
        return response()->json(Peminjaman::find($request->input('id')));
    }

    function add(Request $request){
        try{
            DB::beginTransaction();

            $add = new Peminjaman;
            $add->id_user = $request->input('id_user');
            $add->id_buku = $request->input('id_buku');
            $add->tgl_pesan = $request->input('tgl_pesan');
            $add->tgl_pinjam = $request->input('tgl_pinjam');
            $add->status = 3;
            $add->save();

            //pengurangan jumlah buku
            $data = Buku::where('id', '=', $request->input('id_buku'))
                ->where('jumlah', '>', 0)->first();
            if(!$data){
                return response()->json(array('status' => 'failed', 'reason' => 'Stok buku kosong!'));
            }
            $data->jumlah = $data->jumlah - 1;
            $data->save();

            DB::commit();

            return response()->json(array('status' => 'success', 'reason' => 'Sukses pinjam buku.'));
        }catch(Exception $e){
            DB::rollback();
            return response()->json(array('status' => 'failed', 'reason' => 'Kesalahan sistem!'));
        }
    }

    function kembali(Request $request){
        try{
            DB::beginTransaction();
            $batas_waktu = Pengaturan::where('id', '=', '2')->first();
            $batas_waktu = $batas_waktu->nilai;

            $data = Peminjaman::find($request->input('id'));

            //increment stok buku;
            $increment = Buku::find($data->id_buku);
            $increment->jumlah = $increment->jumlah + 1;
            $increment->save();

            //cek telat atau tidak
            $date1 = date_create($data->tgl_pinjam);
            $date2 = date_create(date('Y-m-d'));
            $diff = date_diff($date1, $date2)->format("%a");

            //jika telat
            if($diff > $batas_waktu){
                $data->tgl_kembali = date('Y-m-d');
                $data->status = '4';
                $data->save();
            }
            //jika tepat waktu
            else{
                $data->tgl_kembali = date('Y-m-d');
                $data->status = '5';
                $data->save();
            }

            DB::commit();
            return response()->json(array('status' => 'success', 'reason' => 'Proses berhasil.'));
        }catch(Exception $e){
            DB::rollback();
            return response()->json(array('status' => 'failed', 'reason' => 'Kesalahan sistem!'));
        }
    }

}
