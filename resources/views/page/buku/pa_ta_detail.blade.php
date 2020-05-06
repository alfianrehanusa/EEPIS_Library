@extends('layouts.page')

@section('content')

<div class="content-header ml-2 mr-2">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Detail Buku</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item">Buku</li>
                    <li class="breadcrumb-item"><a href="/buku/pa_ta">Proyek/Tugas Akhir</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content ml-3 mr-3">
    <div class="container-fluid p-3 shadow-sm mb-5 bg-white rounded">
        <div class="row">
            <div class="col-8">
                <div class="row row-no-gutters">
                    <div class="col-3">
                        <h6 class="font-weight-bold">Judul</h6>
                    </div>
                    <div class="col-1 text-right pl-0 pr-0">
                        <h6>:</h6>
                    </div>
                    <div class="col">
                        <h6>{{$data->judul}}</h6>
                    </div>
                </div>
                <div class="row row-no-gutters">
                    <div class="col-3">
                        <h6 class="font-weight-bold">Tahun</h6>
                    </div>
                    <div class="col-1 text-right pl-0 pr-0">
                        <h6>:</h6>
                    </div>
                    <div class="col">
                        <h6>{{$data->tahun}}</h6>
                    </div>
                </div>
                <div class="row row-no-gutters">
                    <div class="col-3">
                        <h6 class="font-weight-bold">Pengarang</h6>
                    </div>
                    <div class="col-1 text-right pl-0 pr-0">
                        <h6>:</h6>
                    </div>
                    <div class="col">
                        <h6>{{$data->pengarang}}</h6>
                    </div>
                </div>
                <div class="row row-no-gutters">
                    <div class="col-3">
                        <h6 class="font-weight-bold">Sinopsis</h6>
                    </div>
                    <div class="col-1 text-right pl-0 pr-0">
                        <h6>:</h6>
                    </div>
                    <div class="col">
                        <h6>{{$data->sinopsis}}</h6>
                    </div>
                </div>
                <div class="row row-no-gutters">
                    <div class="col-3">
                        <h6 class="font-weight-bold">Jumlah/Stok Buku</h6>
                    </div>
                    <div class="col-1 text-right pl-0 pr-0">
                        <h6>:</h6>
                    </div>
                    <div class="col">
                        <h6>{{$data->jumlah}}</h6>
                    </div>
                </div>
                <div class="row row-no-gutters">
                    <div class="col-3">
                        <h6 class="font-weight-bold">Jumlah Buku Dipinjam</h6>
                    </div>
                    <div class="col-1 text-right pl-0 pr-0">
                        <h6>:</h6>
                    </div>
                    <div class="col">
                        <h6>{{$data->jumlah_dipinjam}}</h6>
                    </div>
                </div>
                <div class="row row-no-gutters">
                    <div class="col-3"></div>
                    <div class="col-1 text-right pl-0 pr-0"></div>
                    <div class="col">
                        <button type="button" class="btn btn-info" onclick="history.back();"><i class="fas fa-chevron-left mr-1"></i>Kembali</button>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <img src="/file/cover_buku/{{$data->gambar}}" class="img-fluid img-thumbnail" style="max-width: 300px;" alt="Cover Buku">
            </div>
        </div>
    </div>
</div>

@endsection
