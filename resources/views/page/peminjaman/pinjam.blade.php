@extends('layouts.page')

@section('title')
    Peminjam Pinjam
@endsection

@section('content')

<div class="content-header ml-2 mr-2">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Daftar Peminjaman</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item">Peminjaman</li>
                    <li class="breadcrumb-item active">Daftar Peminjaman</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content ml-3 mr-3">
    <div class="container-fluid p-3 shadow-sm mb-5 bg-white rounded">
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal_tambah_data_pinjam">
            <i class="fa fa-plus mr-1"></i>Tambah Data Pinjam Buku
        </button>
        <div class="table-responsive">
            <table id="dt_pesan" class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Judul Buku</th>
                        <th>Nama Peminjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Pengembalian</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key)
                        <tr>
                            <td>{{$key->judul}}</td>
                            <td>{{$key->nama}}</td>
                            <td>{{$key->tgl_pinjam}}</td>
                            <td>@php
                                $diff = date("Y-m-d", strtotime('+' . $batas_waktu . " days", strtotime($key->tgl_pinjam)));
                                echo $diff;
                                $deadline = date("Y-m-d", strtotime($diff));
                                $diff = date_diff(date_create($diff), date_create(date("Y-m-d")));
                                @endphp
                                @if($diff->format("%R") == '+')
                                    <span class="badge badge-danger">Telat {{$diff->format("%a hari")}}</span>
                                @else
                                    @if($diff->format("%a") == '0')
                                        <span class="badge badge-success">hari ini</span>
                                    @else
                                        <span class="badge badge-success">{{$diff->format("%a hari lagi")}}</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                {{-- <button type="button" class="btn btn-sm btn-warning" onclick="editPinjam({{$key->id_pinjam}})"><i class="fa fa-user-edit mr-1"></i>Ubah</button> --}}
                                <button type="button" class="btn btn-sm btn-success mb-1" onclick="kembalikanBuku({{$key->id_pinjam}}, {{$key->harga}}, '{{$deadline}}')"><i class="fa fa-book mr-1"></i>Kembalikan Buku</button><br>
                                <button type="button" class="btn btn-sm btn-danger mb-1" onclick="hapusPinjam({{$key->id_pinjam}})"><i class="fa fa-trash mr-1"></i>Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_tambah_data_pinjam">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="tambah_data_pinjam">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Pinjam Buku</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="type_buku" class="font-weight-normal">Type Buku :</label>
                        <select id="type_buku" class="form-control select2" onchange="selectTypeBuku(this)" required>
                            <option></option>
                            @foreach ($list_type_buku as $key)
                                <option value="{{$key->id}}">{{$key->nama_type}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="judul_buku" class="font-weight-normal">Judul Buku :</label>
                        <select id="judul_buku" name="id_buku" class="form-control select2" disabled required>
                            <option></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="type_user" class="font-weight-normal">Type User :</label>
                        <select id="type_user" class="form-control select2" onchange="selectTypeUser(this)" required>
                            <option></option>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="karyawan">Karyawan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_user" class="font-weight-normal">Nama User :</label>
                        <select id="nama_user" name="id_user" class="form-control select2" disabled required>
                            <option></option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="tgl_pesan" class="font-weight-normal">Tanggal Pesan :</label>
                                <input id="tgl_pesan" type="date" class="form-control" id="tgl_pesan" name="tgl_pesan" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="tgl_pinjam" class="font-weight-normal">Tanggal Pinjam :</label>
                                <input id="tgl_pinjam" type="date" class="form-control" id="tgl_pinjam" name="tgl_pinjam" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="tambah_pinjam_btn_loading" class="btn btn-primary disabled" style="display: none"><span class="spinner-border spinner-border-sm mr-1"></span>Loading</button>
                    <button id="tambah_pinjam_btn_add" type="submit" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>Tambah</button>
                    <button id="tambah_pinjam_btn_close" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    </script>
    <script>
        $(document).ready(function() {
            $('#dt_pesan').DataTable({
                "order": []
            });

            //Initialize Select2 Elements
            $('#type_buku').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Type Buku"
            });
            $('#judul_buku').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Judul Buku"
            });
            $('#type_user').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Type User"
            });
            $('#nama_user').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Nama User"
            });

            $("#tambah_data_pinjam").submit(function(event){
                event.preventDefault();

                $('#tambah_pinjam_btn_loading').show();
                $('#tambah_pinjam_btn_add').hide();
                $('#tambah_pinjam_btn_close').hide();

                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    dataType: 'json',
                    url: '/peminjaman/pinjam/add',
                    data:formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(data){
                        $('#tambah_pinjam_btn_loading').hide();
                        $('#tambah_pinjam_btn_add').show();
                        $('#tambah_pinjam_btn_close').show();
                        if(data.status === 'success'){
                            Swal.fire(
                                'Sukses!',
                                data.reason,
                                'success'
                            ).then(() => {
                                location.reload(true);
                            });
                        } else {
                            Swal.fire(
                                'Oops...',
                                data.reason,
                                'error'
                            )
                        }
                    }
                });
            });

        });

        function selectTypeBuku(item) {
            var formdata = new FormData();
            formdata.append('id_buku', item.options[item.selectedIndex].value);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/buku/list_buku',
                data: formdata,
                contentType: false,
                cache: false,
                processData: false,
                success:function(data){
                    $('#judul_buku').empty();
                    data.forEach(item => {
                        $("#judul_buku").append($("<option />").val(item.id).text(item.judul));
                    });
                    $('#judul_buku').prop('disabled', false);
                }
            });
        }

        function selectTypeUser(item) {
            var formdata = new FormData();
            formdata.append('user_type', item.options[item.selectedIndex].value);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/user/list_user',
                data: formdata,
                contentType: false,
                cache: false,
                processData: false,
                success:function(data){
                    $('#nama_user').empty();
                    data.forEach(item => {
                        $("#nama_user").append($("<option />").val(item.id).text(item.nama));
                    });
                    $('#nama_user').prop('disabled', false);
                }
            });
        }

        // function editPinjam(id){
        //     var dialog = bootbox.dialog({
        //         title: 'Perubahan Data Pinjam',
        //         message: '<p><i class="fa fa-spin fa-spinner"></i> Loading...</p>'
        //     }).find(".modal-dialog").addClass("modal-dialog-centered");
        //     $.post("/peminjaman/read", {id: id}, function(data, status){
        //         var message = '<form id="edit_pinjam"><input type="hidden" name="id_asal" value="' + data.id + '">';
        //         message += '<div class="form-group"><label for="edit_type_buku" class="font-weight-normal">Type Buku :</label><select id="edit_type_buku" class="form-control select2" onchange="selectTypeBuku(this)" required><option></option>@foreach ($list_type_buku as $key)<option value="{{$key->id}}">{{$key->nama_type}}</option>@endforeach<option value="ebook">Ebook</option></select></div>';

        //         message += '<div class="text-right"><button id="ubah_buku_btn_loading" class="btn btn-success disabled" style="display: none;">Loading...</button><button id="ubah_buku_btn_submit" type="submit" class="btn btn-success"><i class="far fa-floppy-o mr-1"></i>Simpan</button></div></form>';
        //         dialog.init(function(){
        //             dialog.find('.bootbox-body').html(message);

        //             //Initialize Select2 Elements
        //             $('#edit_type_buku').select2({
        //                 theme: 'bootstrap4',
        //                 placeholder: "Pilih Type Buku"
        //             });
        //             $('#edit_judul_buku').select2({
        //                 theme: 'bootstrap4',
        //                 placeholder: "Pilih Judul Buku"
        //             });
        //             $('#edit_type_user').select2({
        //                 theme: 'bootstrap4',
        //                 placeholder: "Pilih Type User"
        //             });
        //             $('#edit_nama_user').select2({
        //                 theme: 'bootstrap4',
        //                 placeholder: "Pilih Nama User"
        //             });
        //         });
        //         $(document).ready(function(){
        //             $("#edit_pinjam").submit(function(event){
        //                 event.preventDefault();
        //                 $('#ubah_buku_btn_loading').show();
        //                 $('#ubah_buku_btn_submit').hide();
        //                 $('.bootbox-close-button').hide();
        //                 var formData = new FormData(this);
        //                 $.ajax({
        //                     type:'POST',
        //                     dataType: 'json',
        //                     url: '/peminjaman/pinjam/edit',
        //                     data:formData,
        //                     contentType: false,
        //                     cache: false,
        //                     processData: false,
        //                     success:function(data){
        //                         $('#ubah_buku_btn_loading').hide();
        //                         $('#ubah_buku_btn_submit').show();
        //                         $('.bootbox-close-button').show();
        //                         if(data.status === 'success'){
        //                             Swal.fire(
        //                                 'Sukses!',
        //                                 data.reason,
        //                                 'success'
        //                             ).then(() => {
        //                                 location.reload(true);
        //                             });
        //                         } else {
        //                             Swal.fire(
        //                                 'Oops...',
        //                                 data.reason,
        //                                 'error'
        //                             )
        //                         }
        //                     }
        //                 });
        //             });
        //         });
        //     });
        // }

        async function kembalikanBuku(id, harga, deadline){
            const {
                value: kondisi
            } = await Swal.fire({
                title: 'Kondisi Buku',
                input: 'select',
                confirmButtonText: '<i class="fa fa-book-open"> OK',
                cancelButtonText: '<i class="fa fa-times"> Batal',
                inputOptions: {
                    'bagus': 'Bagus',
                    'rusak_hilang': 'Rusak Atau Hilang'
                },
                showCancelButton: true,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        resolve();
                    })
                }
            })

            if (kondisi == "rusak_hilang") {
                Swal.fire({
                    title: 'Buku dalam keadaan rusak/hilang',
                    text: "Denda sebesar Rp " + harga,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-book-open"> OK',
                    cancelButtonText: '<i class="fa fa-times"> Batal'
                }).then((result) => {
                    if(result.value){
                        cekKeterlambatan(deadline);
                    }
                });
            }
            else{
                cekKeterlambatan(deadline);
            }

        }

        function cekKeterlambatan(deadline){

            var date_deadline = new Date(deadline);
            var date_now = new Date();

            var timeDiff = Math.abs(date_deadline.getTime() - date_now.getTime());
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

            if(date_deadline < date_now){
                Swal.fire({
                    title: 'Terlambat mengembalikan buku',
                    text: "Denda sebesar Rp " + ({{$denda}} * (diffDays-1)),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-book-open"> OK',
                    cancelButtonText: '<i class="fa fa-times"> Batal'
                }).then((result) => {
                    if(result.value){
                        konfirmasiPengembalian();
                    }
                });
            }
            else{
                konfirmasiPengembalian();
            }
        }
    
        function konfirmasiPengembalian(){
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Buku akan dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                confirmButtonText: '<i class="fa fa-book-open"> Ya, kembalikan buku',
                cancelButtonText: '<i class="fa fa-times"> Batal'
            }).then((result) => {
                if(result.value){
                    var formdata = new FormData();
                    formdata.append('id', id);
                    formdata.append('kondisi', kondisi);
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: '/peminjaman/pinjam/kembali',
                        data: formdata,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success:function(data){
                            if(data.status === 'success'){
                                Swal.fire(
                                    'Sukses!',
                                    data.reason,
                                    'success'
                                ).then(() => {
                                    location.reload(true);
                                });
                            } else {
                                Swal.fire(
                                    'Oops...',
                                    data.reason,
                                    'error'
                                );
                            }
                        }
                    });
                }
            });
        }

        function hapusPinjam(id){
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: '<i class="fa fa-trash"> Ya, hapus data',
                cancelButtonText: '<i class="fa fa-times"> Batal'
            }).then((result) => {
                if(result.value){
                    var formdata = new FormData();
                    formdata.append('id', id);
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: '/peminjaman/pinjam/delete',
                        data: formdata,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success:function(data){
                            if(data.status === 'success'){
                                Swal.fire(
                                    'Sukses!',
                                    data.reason,
                                    'success'
                                ).then(() => {
                                    location.reload(true);
                                });
                            } else {
                                Swal.fire(
                                    'Oops...',
                                    data.reason,
                                    'error'
                                )
                            }
                        }
                    });
                }
            });
        }

    </script>
@endpush
