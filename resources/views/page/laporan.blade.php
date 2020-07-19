@extends('layouts.page')

@section('title')
    Laporan Peminjaman
@endsection

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

        <form class="form-inline" method="GET" action="/laporan">
            <label for="email" class="mr-sm-2">Filter:</label>
            <select id="name" class="form-control mb-2 mr-sm-2" name="name" onchange="selectFilter(this)" required>
                <option value selected hidden>Pilih Filter</option>
                <option value="kategori_buku">Kategori Buku</option>
                <option value="prodi">Program Studi</option>
            </select>
            <select id="value" class="form-control mb-2 mr-sm-2" name="value" style="display: none" required>
                <option value selected hidden>Pilih</option>
            </select>
            <select id="filter" class="form-control mb-2 mr-sm-2" name="filter" required>
                <option value="all">Semua</option>
                <option value="4">Tepat Waktu</option>
                <option value="5">Telat</option>
            </select>
            <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search mr-1"></i>Cari</button>
        </form>

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

        function selectFilter(item){
            item = item.options[item.selectedIndex].value;
            url = '';
            if(item == 'kategori_buku'){
                url = '/buku/list_kategori';
            }
            else if(item == 'prodi'){
                url = '/user/list_prodi';
            }

            var formdata = new FormData();
            $.ajax({
                type: 'GET',
                url: url,
                success:function(data){
                    $('#value').empty();
                    data.forEach(key => {
                        if(item == 'kategori_buku'){
                            $("#value").append($("<option />").val(key.id).text(key.nama_type));
                        }
                        else if(item == 'prodi'){
                            $("#value").append($("<option />").val(key.id).text(key.nama_prodi));
                        }
                    });
                    $('#value').show();
                }
            });
        }
    </script>
@endpush
