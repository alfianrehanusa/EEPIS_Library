<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Useradmin;

use DB;
use Exception;

class UseradminController extends Controller{

    function index(){
        $data = Useradmin::orderBy('created_at', 'DESC')
            ->get();
        return view('page.useradmin', compact('data'));
    }

    function read(Request $request){
        $data = Useradmin::find($request->input('id'));
        return response()->json($data);
    }

    function add(Request $request){
        try{
            if(Useradmin::where('email', '=', $request->input('email'))->first()){
                return response()->json(array('status' => 'failed', 'reason' => 'Alamat email sudah ada!'));
            }
            DB::beginTransaction();
            $add = new Useradmin;
            $add->name = $request->input('nama');
            $add->email = $request->input('email');
            $add->password = Hash::make($request->input('password'));
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
            if($request->input('edit_email') != $request->input('email_asal') && Useradmin::where('email', '=', $request->input('edit_email'))->first()){
                return response()->json(array('status' => 'failed', 'reason' => 'Alamat email sudah ada!'));
            }

            $data = Useradmin::find($request->input('id_asal'));
            $data->name = $request->input('edit_nama');
            $data->email = $request->input('edit_email');
            if($request->input('edit_password')){
                $data->password = Hash::make($request->input('edit_password'));
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
            if(!Useradmin::find($request->input('id'))->delete()){
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
