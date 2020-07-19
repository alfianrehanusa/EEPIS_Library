<?php

namespace App\Http\Controllers\Buku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Buku;
use App\Models\Ebook;
use App\Models\Type_buku;
use DB;
use Exception;
use PDO;

class UtilController extends Controller{

    function read(Request $request){
        $data = Buku::find($request->input('id'));
        return response()->json($data);
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

    function listBuku(Request $request){
        $id_buku = $request->input('id_buku');
        if($id_buku == 'ebook'){
            $data = Ebook::select('id', 'judul')->get();
        }
        else{
            $data = Buku::where('type_buku', '=', $id_buku)
                // ->where('stok_buku', '>', '0')
                ->get();
        }
        return response()->json($data);
    }

    function listKategori(){
        return response()->json(Type_buku::all());
    }
}
