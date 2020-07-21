@extends('layouts.page')

@section('title')
    Laporan Denda
@endsection

@section('content')

<div class="content-header ml-2 mr-2">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Laporan Denda</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Laporan Denda</li>
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
                        <th>Nama Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Nominal</th>
                        <th>Tanggal Denda</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key)
                        <tr>
                            <td>{{$key->nama}}</td>
                            <td>{{$key->judul}}</td>
                            <td>Rp {{$key->nominal}}</td>
                            <td>{{$key->tanggal}}</td>
                            <td>
                                @if($key->type_denda == 1)
                                    Terlambat
                                @else
                                    Buku rusak/hilang
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
