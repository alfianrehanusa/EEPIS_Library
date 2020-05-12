<?php

namespace App\Http\Controllers\Buku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ebook;

use DB;
use Exception;
use Storage;

class EbookController extends Controller{

    function index(){
        $data = Ebook::orderBy('created_at', 'DESC')
            ->get();
        return view('page.buku.ebook', compact('data'));
    }

    function detail($id){
        $data = Ebook::find($id);
        if(!$data){
            abort(404);
        }
        return view('page.buku.ebook_detail', compact('data'));
    }

    function read(Request $request){
        $data = Ebook::find($request->input('id'));
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

            $ebook = $request->file('ebook');
            $ebook_name = uniqid() . '.' . $ebook->getClientOriginalExtension();
            Storage::disk('local')->putFileAs(
                'file_ebook',
                $ebook,
                $ebook_name
            );

            $add = new Ebook;
            $add->judul = $request->input('judul');
            $add->tahun = $request->input('tahun');
            $add->pengarang = $request->input('pengarang');
            $add->sinopsis = $request->input('sinopsis');
            $add->ebook = $ebook_name;
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

            //Save new image or ebook file if exist
            if ($request->hasFile('edit_gambar') || $request->hasFile('edit_ebook')) {
                $data = Ebook::find($request->input('id_asal'));

                //if edit_gambar exist, save it
                if($request->hasFile('edit_gambar')){
                    $gambar = $request->file('edit_gambar');
                    $gambar_name = uniqid() . '.' . $gambar->getClientOriginalExtension();
                    Storage::disk('local')->putFileAs(
                        'cover_buku',
                        $gambar,
                        $gambar_name
                    );

                    //delete old image
                    if($data){
                        unlink(storage_path('app/cover_buku/' . $data->gambar));
                    }
                }
                //if edit_ebook exist, save it
                if($request->hasFile('edit_ebook')){
                    $ebook = $request->file('edit_ebook');
                    $ebook_name = uniqid() . '.' . $ebook->getClientOriginalExtension();
                    Storage::disk('local')->putFileAs(
                        'file_ebook',
                        $ebook,
                        $ebook_name
                    );

                    //delete old ebook
                    if($data){
                        unlink(storage_path('app/file_ebook/' . $data->ebook));
                    }
                }

                //save new image name or ebook name and detail book
                $data->judul = $request->input('edit_judul');
                $data->pengarang = $request->input('edit_pengarang');
                $data->sinopsis = $request->input('edit_sinopsis');
                $data->tahun = $request->input('edit_tahun');
                if($request->hasFile('edit_gambar')){
                    $data->gambar = $gambar_name;
                }
                if($request->hasFile('edit_ebook')){
                    $data->ebook = $ebook_name;
                }
                $data->save();

            }
            else{
                //Save detail book
                $data = Ebook::find($request->input('id_asal'));
                $data->judul = $request->input('edit_judul');
                $data->pengarang = $request->input('edit_pengarang');
                $data->sinopsis = $request->input('edit_sinopsis');
                $data->tahun = $request->input('edit_tahun');
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
            if(Ebook::find($request->input('id'))){
                $filename = Ebook::find($request->input('id'));
                unlink(storage_path('app/cover_buku/' . $filename->gambar));
            }

            //delete ebook
            if(Ebook::find($request->input('id'))){
                $filename = Ebook::find($request->input('id'));
                unlink(storage_path('app/file_ebook/' . $filename->ebook));
            }

            //delete data
            if(!Ebook::find($request->input('id'))->delete()){
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
