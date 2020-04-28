<?php

namespace App\Http\Controllers\Buku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use DB;
use Exception;
use Storage;

class UmumController extends Controller{

    function index(){
        $data = Buku::where('type_buku', '=', 'umum')
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('page.buku.umum', compact('data'));
    }

    function detail($id){
        $data = Buku::find($id);
        if(!$data){
            abort(404);
        }
        return view('page.buku.umum_detail', compact('data'));
    }

    function read(Request $request){
        $data = Buku::find($request->input('id'));
        return response()->json($data);
    }

    function add(Request $request){
        try{
            DB::beginTransaction();
            $gambar = $request->file('gambar');
            $gambar_name = uniqid() . '.' . $gambar->getClientOriginalExtension();
            Storage::disk('local')->putFileAs(
                'cover_buku',
                $gambar,
                $gambar_name
            );

            $add = new Buku;
            $add->judul = $request->input('judul');
            $add->tahun = $request->input('tahun');
            $add->pengarang = $request->input('pengarang');
            $add->sinopsis = $request->input('sinopsis');
            $add->jumlah = $request->input('jumlah');
            $add->type_buku = 'umum';
            $add->gambar = $gambar_name;
            $add->save();
            DB::commit();

            return response()->json(array('status' => 'success', 'reason' => 'Sukses tambah buku.'));
        }catch(Exception $e){
            DB::rollback();
            return response()->json(array('status' => 'failed', 'reason' => 'Kesalahan sistem!'));
        }
    }

    function edit(Request $request){
        try{
            if($request->input('edit_nip') != $request->input('nip_asal') && Buku::find($request->input('edit_nip'))){
                return response()->json(array('status' => 'failed', 'reason' => 'NIP sudah ada!'));
            }
            $data = Buku::find($request->input('nip_asal'));
            $data->id = $request->input('edit_nip');
            $data->nama = $request->input('edit_nama');
            $data->email = $request->input('edit_email');
            if($request->input('edit_password')){
                $data->password = md5($request->input('edit_password'));
            }
            $data->save();
            DB::commit();
            return response()->json(array('status' => 'success', 'reason' => 'Sukses edit data.'));
        }catch(Exception $e){
            DB::rollback();
            return response()->json(array('status' => 'failed', 'reason' => 'Kesalahan sistem!'));
        }
    }

    function delete(Request $request){
        try{
            DB::beginTransaction();

            //delete picture
            if(Buku::find($request->input('id'))){
                $filename = Buku::find($request->input('id'));
                unlink(storage_path('app/cover_buku/' . $filename->gambar));
            }

            //delete data
            if(!Buku::find($request->input('id'))->delete()){
                throw 'Kesalahan sistem!';
            }

            DB::commit();
            return response()->json(array('status' => 'success', 'reason' => 'Sukses hapus data'));
        }catch(Exception $e){
            DB::rollback();
            return response()->json(array('status' => 'success', 'reason' => 'Kesalahan sistem!'));
        }
    }

}
