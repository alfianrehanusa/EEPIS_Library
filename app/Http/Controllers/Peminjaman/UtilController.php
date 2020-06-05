<?php

namespace App\Http\Controllers\Peminjaman;

use Illuminate\Http\Request;

use App\Models\Peminjaman;

class UtilController{

    function read(Request $request){
        return response()->json(Peminjaman::find($request->input('id')));
    }

}
