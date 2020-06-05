<?php

namespace App\Http\Controllers\Peminjaman;

use Illuminate\Http\Request;

use App\Models\Peminjaman;
use App\Models\Buku;
use DB;
use Exception;

class UtilController{

    function read(Request $request){
        return response()->json(Peminjaman::find($request->input('id')));
    }

    function deletePesan(Request $request){
        try{
            DB::beginTransaction();

            //delete data
            if(!Peminjaman::find($request->input('id'))->delete()){
                throw 'Kesalahan sistem!';
            }

            DB::commit();
            return response()->json(array('status' => 'success', 'reason' => 'Proses berhasil.'));
        }catch(Exception $e){
            DB::rollback();
            return response()->json(array('status' => 'failed', 'reason' => 'Kesalahan sistem!'));
        }
    }

    function deletePinjam(Request $request){
        try{
            DB::beginTransaction();

            $data = Peminjaman::find($request->input('id'));

            //increment stok buku;
            $increment = Buku::find($data->id_buku);
            $increment->jumlah = $increment->jumlah + 1;
            $increment->save();

            //delete data
            if(!Peminjaman::find($request->input('id'))->delete()){
                throw 'Kesalahan sistem!';
            }

            DB::commit();
            return response()->json(array('status' => 'success', 'reason' => 'Proses berhasil.'));
        }catch(Exception $e){
            DB::rollback();
            return response()->json(array('status' => 'failed', 'reason' => 'Kesalahan sistem!'));
        }
    }

}
