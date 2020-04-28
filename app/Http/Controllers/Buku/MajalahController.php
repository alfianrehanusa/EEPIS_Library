<?php

namespace App\Http\Controllers\Buku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MajalahController extends Controller{

    public function index(){
        return view('page.buku.majalah');
    }

}
