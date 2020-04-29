<?php

namespace App\Http\Controllers\Buku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use DB;
use Exception;
use Storage;

class PaTaController extends Controller{

    function index(){
        $data = Buku::where('type_buku', '=', 'pa_ta')
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('page.buku.pa_ta', compact('data'));
    }

    function detail($id){
        $data = Buku::find($id);
        if(!$data){
            abort(404);
        }
        return view('page.buku.pa_ta_detail', compact('data'));
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
            $add->type_buku = 'pa_ta';
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

            //Save new image if exist
            if ($request->hasFile('edit_gambar')) {
                $gambar = $request->file('edit_gambar');
                $gambar_name = uniqid() . '.' . $gambar->getClientOriginalExtension();
                Storage::disk('local')->putFileAs(
                    'cover_buku',
                    $gambar,
                    $gambar_name
                );

                //delete old image
                $data = Buku::find($request->input('id_asal'));
                if($data){
                    unlink(storage_path('app/cover_buku/' . $data->gambar));
                }

                //save new image name and detail book
                $data->judul = $request->input('edit_judul');
                $data->pengarang = $request->input('edit_pengarang');
                $data->sinopsis = $request->input('edit_sinopsis');
                $data->tahun = $request->input('edit_tahun');
                $data->jumlah = $request->input('edit_jumlah');
                $data->gambar = $gambar_name;
                $data->save();

            }
            else{
                //Save detail book
                $data = Buku::find($request->input('id_asal'));
                $data->judul = $request->input('edit_judul');
                $data->pengarang = $request->input('edit_pengarang');
                $data->sinopsis = $request->input('edit_sinopsis');
                $data->tahun = $request->input('edit_tahun');
                $data->jumlah = $request->input('edit_jumlah');
                $data->save();
            }

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

            //delete image
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
