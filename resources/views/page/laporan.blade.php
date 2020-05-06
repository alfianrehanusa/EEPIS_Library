@extends('layouts.page')

@section('content')

<div class="content-header ml-2 mr-2">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Laporan Peminjaman Buku</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Laporan Peminjaman</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content ml-3 mr-3">
    <div class="container-fluid p-3 shadow-sm mb-5 bg-white rounded">
        <div class="table-responsive">
            <table id="dt_laporan" class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Id Pinjam</th>
                        <th>Judul Buku</th>
                        <th>Nama Peminjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status Pengembalian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key)
                        <tr>
                            <td>{{$key->id_pinjam}}</td>
                            <td>{{$key->judul}}</td>
                            <td>{{$key->nama}}</td>
                            <td>{{$key->tgl_pinjam}}</td>
                            <td>{{$key->tgl_kembali}}</td>
                            <td>
                                @if($key->status == 4)
                                    <span class="badge badge-danger">Telat</span>
                                @else
                                    <span class="badge badge-success">Tepat Waktu</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dt_laporan').DataTable({
                "order": []
            });
        });
    </script>
@endpush
