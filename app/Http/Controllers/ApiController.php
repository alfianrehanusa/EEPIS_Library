<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Peminjaman;
use App\Models\Pengaturan;
use App\Models\Buku;
use App\Models\User;

use Exception;
use DB;
use Response;
use File;

class ApiController extends Controller{

    function checkToken(Request $request){
        $data = User::where([
            ['email', '=', $request->input('email')],
            ['login_token', '=', $request->input('token')]
        ])->first();
        if(!$data){
            return response()->json(['status' => 'failed', 'reason' => 'Invalid token!']);
        }
        return response()->json(['status' => 'success', 'reason' => 'Token valid!']);

    }

    function login(Request $request){
        $valid = User::where('email', '=', $request->input('email'))
            ->where('password', '=', md5($request->input('password')))
            ->first();
        if(!$valid){
            return response()->json(array('status' => 'failed', 'reason' => 'Username atau password salah!'));
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
                'id_user' => $valid->id,
                'name' => $valid->nama,
                'token' => $token
            ));
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(array('status' => 'failed', 'reason' => 'Kesalahan sistem!'));
        }
    }

    function listBuku(Request $request){
        $url_gambar = url('/') . '/api/file/cover_buku/' . $request->header('token') . '/';

        $jumlah_pinjam = Peminjaman::select('id_buku', DB::raw('count(id_buku) AS jumlah_pinjam'))
            ->where('status', '=', 1)
            ->groupBy('id_buku');

        $data = DB::table('buku AS A')
            ->select(
                'A.id',
                'A.judul',
                'B.nama_type',
                DB::raw('concat("' . $url_gambar . '", A.gambar) AS gambar'),
                DB::raw('IF(C.jumlah_pinjam IS NULL, A.jumlah, A.jumlah-C.jumlah_pinjam) AS jumlah')
            )
            ->join('type_buku AS B', 'A.type_buku', '=', 'B.id')
            ->leftJoinSub($jumlah_pinjam, 'C', function ($join) {
                $join->on('A.id', '=', 'C.id_buku');
            });
        if($request->filled('query')) {
            $data = $data->whereRaw('LOWER(A.judul) LIKE LOWER(\'%' . $request->input('query') . '%\')');
        }
        $data = $data->orderBy('A.created_at', 'DESC')
            ->orderBy('jumlah', 'DESC')
            ->get();
        return response()->json(array('status' => 'success', 'data' => $data));
    }

    function detailBuku(Request $request){
        $url_gambar = url('/') . '/api/file/cover_buku/' . $request->header('token') . '/';

        $jumlah_pinjam = Peminjaman::select('id_buku', DB::raw('count(id_buku) AS jumlah_pinjam'))
            ->where('status', '=', 1)
            ->where('id_buku', '=', $request->input('id_buku'))
            ->groupBy('id_buku');

        $data = DB::table('buku AS A')
            ->select(
                'A.id',
                'A.judul',
                'B.nama_type',
                DB::raw('concat("' . $url_gambar . '", A.gambar) AS gambar'),
                DB::raw('IF(C.jumlah_pinjam IS NULL, A.jumlah, A.jumlah-C.jumlah_pinjam) AS jumlah')
            )
            ->join('type_buku AS B', 'A.type_buku', '=', 'B.id')
            ->leftJoinSub($jumlah_pinjam, 'C', function ($join) {
                $join->on('A.id', '=', 'C.id_buku');
            })->get();
        return response()->json(array('status' => 'success', 'data' => $data));
    }

    function pesan(Request $request){
        try {
            DB::beginTransaction();

            //validasi buku dan user
            $data = Buku::find($request->input('id_buku'));
            $user = User::find($request->header('id_user'));
            if(!$data || !$user){
                return response()->json(array('status' => 'failed', 'reason' => 'Data tidak ditemukan!'));
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
            $data->id_user = $request->header('id_user');
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

    function listPesan(Request $request){
        //batas waktu pinjam
        $batas_waktu = Pengaturan::where('id', '=', '1')->first();
        $batas_waktu = $batas_waktu->nilai;

        $url_gambar = url('/') . '/api/file/cover_buku/' . $request->header('token') . '/';
        $data = DB::table('peminjaman AS A')
            ->select(
                'B.judul',
                'A.tgl_pesan',
                DB::raw('DATE_ADD(A.tgl_pesan, INTERVAL ' . $batas_waktu . ' DAY) AS batas_waktu'),
                DB::raw('concat("' . $url_gambar . '", B.gambar) AS gambar')
            )
            ->join('buku AS B', 'B.id', '=', 'A.id_buku')
            ->where('id_user', '=', $request->header('id_user'))
            ->where('status', '=', '1')
            ->where('A.tgl_pesan', '>', date('Y-m-d', strtotime("-" . $batas_waktu . " days")))
            ->orderBy('A.created_at', 'DESC')
            ->get();

        return response()->json(array('status' => 'success', 'data' => $data));
    }

    function listPinjam(Request $request){
        //batas waktu pinjam
        $batas_waktu = Pengaturan::where('id', '=', '2')->first();
        $batas_waktu = $batas_waktu->nilai;

        $url_gambar = url('/') . '/api/file/cover_buku/' . $request->header('token') . '/';
        $data = DB::table('peminjaman AS A')
            ->select(
                'B.judul',
                'A.tgl_pinjam',
                DB::raw('DATE_ADD(A.tgl_pinjam, INTERVAL ' . $batas_waktu . ' DAY) AS batas_waktu'),
                DB::raw('concat("' . $url_gambar . '", B.gambar) AS gambar')
            )
            ->join('buku AS B', 'B.id', '=', 'A.id_buku')
            ->where('id_user', '=', $request->header('id_user'))
            ->where('status', '=', '3')
            ->orderBy('tgl_pinjam', 'DESC')
            ->get();

        return response()->json(array('status' => 'success', 'data' => $data));
    }

    function riwayat(Request $request){
        $url_gambar = url('/') . '/api/file/cover_buku/' . $request->header('token') . '/';
        $data = DB::table('peminjaman AS A')
            ->select('B.judul', 'A.tgl_pinjam', 'A.tgl_kembali', DB::raw('concat("' . $url_gambar . '", B.gambar) AS gambar'))
            ->join('buku AS B', 'B.id', '=', 'A.id_buku')
            ->where('A.id_user', '=', $request->header('id_user'))
            ->whereIn('A.status', [4, 5])
            ->orderBy('A.tgl_kembali', 'DESC')
            ->get();

        return response()->json(array('status' => 'success', 'data' => $data));
    }

    function coverBuku($token, $filename){
        //token check
        $data = User::where('login_token', '=', $token)->first();
        if(!$data){
            return response()->json(['status' => 'failed', 'reason' => 'Invalid token']);
        }

        if (strpos($filename, '.') !== false) {
            $path = storage_path('app/cover_buku/' . $filename);
            try {
                $response = Response::make(File::get($path), 200);
                return $response->header("Content-Type", File::mimeType($path));
            } catch (FileNotFoundException $exception) {
                abort(404);
            }
        } else {
            return response()->json(['status' => 'failed', 'reason' => 'Invalid image']);
        }
    }

}
