@extends('layouts.page')

@section('content')

<div class="content-header ml-2 mr-2">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">User Mahasiswa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item">User</li>
                    <li class="breadcrumb-item active">Mahasiswa</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content ml-3 mr-3">
    <div class="container-fluid p-3 shadow-sm mb-5 bg-white rounded">
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal_tambah_mahasiswa">
            <i class="fa fa-plus mr-1"></i>Tambah Mahasiswa
        </button>
        <div class="table-responsive">
            <table id="dt_mahasiswa" class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>NRP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key)
                        <tr>
                            <td>{{$key->id}}</td>
                            <td>{{$key->nama}}</td>
                            <td>{{$key->email}}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-user-edit mr-1"></i>Ubah</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="hapusMahasiswa({{$key->id}})"><i class="fa fa-trash mr-1"></i>Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_tambah_mahasiswa">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="tambah_mahasiswa">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Mahasiswa</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nrp" class="font-weight-normal">NRP :</label>
                        <input type="text" class="form-control" placeholder="NRP" id="nrp" name="nrp" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="nama" class="font-weight-normal">Nama Lengkap :</label>
                        <input type="text" class="form-control" placeholder="Nama Lengkap" id="nama" name="nama" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="font-weight-normal">Alamat Email :</label>
                        <input type="email" class="form-control" placeholder="Alamat Email" id="email" name="email" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="font-weight-normal">Password :</label>
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" autocomplete="off" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="tambah_mahasiswa_btn_loading" class="btn btn-primary disabled" style="display: none"><span class="spinner-border spinner-border-sm mr-1"></span>Loading</button>
                    <button id="tambah_mahasiswa_btn_add" type="submit" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>Tambah</button>
                    <button id="tambah_mahasiswa_btn_close" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dt_mahasiswa').DataTable({
                "order": []
            });

            $("#tambah_mahasiswa").submit(function(event){
                event.preventDefault();

                $('#tambah_mahasiswa_btn_loading').show();
                $('#tambah_mahasiswa_btn_add').hide();
                $('#tambah_mahasiswa_btn_close').hide();

                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    dataType: 'json',
                    url: '/user/mahasiswa/add',
                    data:formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(data){
                        $('#tambah_mahasiswa_btn_loading').hide();
                        $('#tambah_mahasiswa_btn_add').show();
                        $('#tambah_mahasiswa_btn_close').show();
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

        function hapusMahasiswa(id){
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: '<i class="fa fa-trash"> Ya, hapus data',
                cancelButtonText: '<i class="fa fa-times"> Batal',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    $.ajax({
                        type:'POST',
                        dataType: 'json',
                        url: '/user/mahasiswa/delete',
                        data:{id: id},
                        contentType: false,
                        cache: false,
                        processData: false
                    })
                    .then(response => {
                        return response.json();
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.value.status === 'success') {
                    Swal.fire(
                        'Blocked!',
                        data.reason,
                        'success'
                    )
                    table.ajax.reload( null, false);
                }
                else{
                    Swal.fire(
                        'Oops...',
                        data.reason,
                        'error'
                    )
                }
            });
        }

    </script>
@endpush
