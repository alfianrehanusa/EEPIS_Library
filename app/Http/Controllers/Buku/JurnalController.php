<?php

namespace App\Http\Controllers\Buku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JurnalController extends Controller{

    public function index(){
        return view('page.buku.jurnal');
    }

}
