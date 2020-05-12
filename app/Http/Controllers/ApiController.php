<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use DB;

use App\Models\Peminjaman;
use App\Models\Pengaturan;
use App\Models\Buku;
use App\Models\User;

class ApiController extends Controller{

    function login(Request $request){

        $valid = User::where('email', '=', $request->input('email'))
            ->where('password', '=', md5($request->input('password')))
            ->first();
        if(!$valid){
            return response()->json(array('status' => 'error', 'reason' => 'Username atau password salah'));
        }

        try {
            $token = md5(date('Y-m-d') . uniqid(null, true) . $request->input('email'));
            DB::beginTransaction();

            $valid->login_token = $token;
            $valid->save();

            DB::commit();
            return response()->json(array(
                'status' => 'success',
                'reason' => 'Login berhasil',
                'name' => $valid->nama,
                'token' => $token
            ));
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(array('status' => 'error', 'reason' => 'Kesalahan sistem!'));
        }
    }

    function pesan(Request $request){
        try {
            DB::beginTransaction();

            //validasi buku dan user
            $data = Buku::find($request->input('id_buku'));
            if(!$data){
                return response()->json(array('status' => 'failed', 'reason' => 'Buku tidak ditemukan!'));
            }
            $user = User::find($request->input('id_user'));
            if(!$user){
                return response()->json(array('status' => 'failed', 'reason' => 'User tidak ditemukan!'));
            }

            //Pengecekan stok buku
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
