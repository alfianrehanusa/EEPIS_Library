<?php

namespace App\Http\Controllers\Peminjaman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Peminjaman;
use App\Models\Pengaturan;
use App\Models\Buku;
use App\Models\Type_buku;
use App\Models\User;
use App\Models\Denda_report;
use DB;
use Exception;
use DateTime;

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

        $denda = Pengaturan::where('id', '=', '5')->first();
        $denda = $denda->nilai;

        return view('page.peminjaman.pinjam', compact('data', 'batas_waktu', 'list_type_buku', 'denda'));
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

            //cek borrow_date
            $user = User::find($request->input('id_user'));
            $date1 = date_create($user->borrow_date);
            $date2 = date_create(date('Y-m-d'));
            $diff = date_diff($date1, $date2)->format("%R");

            $date = new DateTime($user->borrow_date);
            $date = $date->format('Y-m-d');

            if($diff == '-'){
                return response()->json(array('status' => 'failed', 'reason' => 'Kesalahan, dapat meminjam buku kembali tanggal ' . $date));
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
            $id_user = $data->id_user;

            $buku = Buku::find($data->id_buku);
            $harga_buku = $buku->harga;

            //increment stok buku jika kondisi buku bagus
            if($request->input('kondisi') == 'bagus'){
                $buku->jumlah = $buku->jumlah + 1;
                $buku->save();
            }
            //isi laporan denda
            else{
                $increment = new Denda_report;
                $increment->id_user = $id_user;
                $increment->id_buku = $data->id_buku;
                $increment->nominal = $harga_buku;
                $increment->tanggal = date('Y-m-d');
                $increment->type_denda = 2;
                $increment->save();
            }

            //cek telat atau tidak
            $date1 = date_create($data->tgl_pinjam);
            $date2 = date_create(date('Y-m-d'));
            $diff = date_diff($date1, $date2)->format("%a");

            //jika telat
            if($diff > $batas_waktu){
                $data->tgl_kembali = date('Y-m-d');
                $data->status = '4';
                $data->save();

                //hukuman terlambat
                $jumlah_hari = Pengaturan::where('id', '=', '4')->first();
                $jumlah_hari = $jumlah_hari->nilai;
                $jumlah_hari = $diff * $jumlah_hari;

                $date = date("Y-m-d", strtotime("+ " . $jumlah_hari . " day"));

                $user = User::find($id_user);
                $user->borrow_date = $date;
                $user->save();

                //isi laporan denda
                $increment = new Denda_report;
                $increment->id_user = $id_user;
                $increment->id_buku = $data->id_buku;
                $increment->nominal = $request->input('denda_terlambat');
                $increment->tanggal = date('Y-m-d');
                $increment->type_denda = 1;
                $increment->save();
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
