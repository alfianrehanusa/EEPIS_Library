<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Peminjaman;
use App\Models\Pengaturan;
use App\Models\Buku;
use App\Models\Type_buku;
use App\Models\User;
use DB;
use Exception;
use DateTime;

class PesanController extends Controller{

    function index(){
        $batas_waktu = Pengaturan::where('id', '=', '1')->first();
        $batas_waktu = $batas_waktu->nilai;
        $list_type_buku = Type_buku::all();
        $data = DB::table('peminjaman AS A')
        ->select('*', 'A.id AS id_pinjam')
        ->join('user as B', 'A.id_user', '=', 'B.id')
        ->join('buku AS C', 'A.id_buku', '=', 'C.id')
        ->where('A.status' , '=', '1')
        ->where('A.tgl_pesan', '>', date('Y-m-d', strtotime("-" . $batas_waktu . " days")))
        ->orderBy('A.tgl_pesan', 'DESC')
        ->get();

        return view('page.peminjaman.pesan', compact('data', 'batas_waktu', 'list_type_buku'));
    }

    function add(Request $request){
        try {
            DB::beginTransaction();

            //cek borrow_date
            $user = User::find($request->input('id_user'));
            $date1 = date_create($user->borrow_date);
            $date2 = date_create(date('Y-m-d'));
            $diff = date_diff($date1, $date2)->format("%R");

            $date = new DateTime($user->borrow_date);
            $date = $date->format('Y-m-d');

            if($diff == '-'){
                return response()->json(array('status' => 'failed', 'reason' => 'Kesalahan, dapat memesan buku kembali tanggal ' . $date));
            }

            //batas buku
            $batas_buku = Pengaturan::where('id', '=', '3')->first();
            $batas_buku = $batas_buku->nilai;
            $jumlah_pinjam = Peminjaman::where('id_user', '=', $request->input('id_user'))
                ->where('status', '=', '3')
                ->count();
            if($jumlah_pinjam >= $batas_buku){
                return response()->json(array('status' => 'failed', 'reason' => 'Batas jumlah peminjaman telah tercapai!'));
            }

            //Pengecekan stok buku
            $data = Buku::find($request->input('id_buku'));
            $buku_pesan = Peminjaman::where('id_buku', '=', $request->input('id_buku'))
                ->where('status', '=', 1)
                ->count();
            $stok_buku = $data->jumlah - $buku_pesan;
            if($stok_buku < 1){
                return response()->json(array('status' => 'failed', 'reason' => 'Stok buku kosong!'));
            }

            $add = new Peminjaman;
            $add->id_user = $request->input('id_user');
            $add->id_buku = $request->input('id_buku');
            $add->tgl_pesan = $request->input('tgl_pesan');
            $add->status = 1;
            $add->save();

            DB::commit();
            return response()->json(array('status' => 'success', 'reason' => 'Sukses pesan buku.'));
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(array('status' => 'failed', 'reason' => 'Kesalahan sistem!'));
        }
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

            //batas buku
            $data = Peminjaman::find($request->input('id'));
            $batas_buku = Pengaturan::where('id', '=', '3')->first();
            $batas_buku = $batas_buku->nilai;
            $jumlah_pinjam = Peminjaman::where('id_user', '=', $request->id_user)
                ->where('status', '=', '3')
                ->count();
            if($jumlah_pinjam >= $batas_buku){
                return response()->json(array('status' => 'failed', 'reason' => 'Batas jumlah peminjaman telah tercapai!'));
            }

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
