<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Exception;

class MahasiswaController{

    function index(){
        $data = User::where('user_type', '=', 'mahasiswa')
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('page.user.mahasiswa', compact('data'));
    }

    function read(Request $request){
        $data = User::find($request->input('id'));
        return response()->json($data);
    }

    function add(Request $request){
        try{
            if(User::find($request->input('nrp'))){
                return response()->json(array('status' => 'failed', 'reason' => 'NRP sudah ada!'));
            }
            if(User::where('email', '=', $request->input('email'))->first()){
                return response()->json(array('status' => 'failed', 'reason' => 'Alamat email sudah ada!'));
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
        try{
            if($request->input('edit_nrp') != $request->input('nrp_asal') && User::find($request->input('edit_nrp'))){
                return response()->json(array('status' => 'failed', 'reason' => 'NRP sudah ada!'));
            }
            if($request->input('edit_email') != $request->input('email_asal') && User::where('email', '=', $request->input('edit_email'))->first()){
                return response()->json(array('status' => 'failed', 'reason' => 'Alamat email sudah ada!'));
            }

            $data = User::find($request->input('nrp_asal'));
            $data->id = $request->input('edit_nrp');
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
            if(!User::find($request->input('id'))->delete()){
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
