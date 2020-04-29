<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamanController extends Controller{

    function index(){
        return view('page.peminjaman');
    }

}
