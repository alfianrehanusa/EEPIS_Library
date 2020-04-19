<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Exception;

class MahasiswaController{

    function index(){
        $data = User::orderBy('created_at', 'DESC')->get();
        return view('page.user.mahasiswa', compact('data'));
    }

    function read(Request $request){
        $data = User::find($request->input('nrp'))->first();
        return response()->json($data);
    }

    function add(Request $request){
        try{
            $data = User::find($request->input('nrp'));
            if($data){
                return response()->json(array('status' => 'failed', 'reason' => 'Data sudah ada!'));
            }

            DB::beginTransaction();
            $add = new User;
            $add->id = $request->input('nrp');
            $add->nama = $request->input('nama');
            $add->email = $request->input('email');
            $add->password = md5($request->input('password'));
            $add->user_type = 'mahasiswa';
            $add->save();
            DB::commit();
            return response()->json(array('status' => 'success', 'reason' => 'Sukses tambah data.'));
        }catch(Exception $e){
            DB::rollback();
            return response()->json(array('status' => 'failed', 'reason' => 'Kesalahan sistem!'));
        }
    }

    function edit(Request $request){
        dd($request);
    }

    function delete(Request $request){
        return response()->json(array('status' => 'success', 'reason' => $request->input('id')));
    }

}
