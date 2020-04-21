<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Exception;

class PustakawanController{

    function index(){
        $data = User::where('user_type', '=', 'mahasiswa')
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('page.user.mahasiswa', compact('data'));
    }

}
