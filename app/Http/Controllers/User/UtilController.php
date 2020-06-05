<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\User;

class UtilController{

    function list(Request $request){
        $data = User::where('user_type', '=', $request->input('user_type'))->get();
        return response()->json($data);
    }

}
