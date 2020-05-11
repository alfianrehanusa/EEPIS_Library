<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaturan;

use DB;
use Exception;

class PengaturanController extends Controller{

    function index(){
        $data = Pengaturan::all();
        return view('page.pengaturan', compact('data'));
    }

    function read(Request $request){
        $data = Pengaturan::find($request->input('id'));
        return response()->json($data);
    }

    function edit(Request $request){
        try{
            DB::beginTransaction();
            $data = Pengaturan::find($request->input('id'));
            $data->nilai = $request->input('edit_nilai');
            $data->save();
            DB::commit();
            return response()->json(array('status' => 'success', 'reason' => 'Sukses edit data.'));
        }catch(Exception $e){
            DB::rollback();
            return response()->json(array('status' => 'failed', 'reason' => 'Kesalahan sistem!'));
        }
    }

}
