@extends('layouts.page')

@section('title')
    User Admin
@endsection

@section('content')

<div class="content-header ml-2 mr-2">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">User Admin</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">User Admin</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content ml-3 mr-3">
    <div class="container-fluid p-3 shadow-sm mb-5 bg-white rounded">
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal_tambah_admin">
            <i class="fa fa-plus mr-1"></i>Tambah Admin
        </button>
        <div class="table-responsive">
            <table id="dt_useradmin" class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $id = 1; @endphp
                    @foreach ($data as $key)
                        <tr>
                            <td>{{$id++}}</td>
                            <td>{{$key->name}}</td>
                            <td>{{$key->email}}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning" onclick="editAdmin({{$key->id}})"><i class="fa fa-user-edit mr-1"></i>Ubah</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="hapusAdmin({{$key->id}})"><i class="fa fa-trash mr-1"></i>Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_tambah_admin">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="tambah_admin">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Admin</h4>
                </div>
                <div class="modal-body">
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
                    <button id="tambah_admin_btn_loading" class="btn btn-primary disabled" style="display: none"><span class="spinner-border spinner-border-sm mr-1"></span>Loading</button>
                    <button id="tambah_admin_btn_add" type="submit" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>Tambah</button>
                    <button id="tambah_admin_btn_close" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dt_useradmin').DataTable({
                "order": []
            });

            $("#tambah_admin").submit(function(event){
                event.preventDefault();

                $('#tambah_admin_btn_loading').show();
                $('#tambah_admin_btn_add').hide();
                $('#tambah_admin_btn_close').hide();

                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    dataType: 'json',
                    url: '/useradmin/add',
                    data:formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(data){
                        $('#tambah_admin_btn_loading').hide();
                        $('#tambah_admin_btn_add').show();
                        $('#tambah_admin_btn_close').show();
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

        function hapusAdmin(id){
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
                        url: '/useradmin/delete',
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

        function editAdmin(id){
            var dialog = bootbox.dialog({
                title: 'Perubahan Data Admin',
                message: '<p><i class="fa fa-spin fa-spinner"></i> Loading...</p>'
            }).find(".modal-dialog").addClass("modal-dialog-centered");
            $.post("/useradmin/read", {id: id}, function(data, status){
                var message = '<form id="edit_admin"><input type="hidden" name="id_asal" value="' + data.id + '"><input type="hidden" name="email_asal" value="' + data.email + '">';
                message += '<div class="form-group"><label for="edit_nama" class="font-weight-normal">Nama Lengkap :</label><input type="text" class="form-control" placeholder="Nama Lengkap" id="edit_nama" name="edit_nama" autocomplete="off" value="' + data.name + '" required></div>';
                message += '<div class="form-group"><label for="edit_email" class="font-weight-normal">Alamat Email :</label><input type="email" class="form-control" placeholder="Alamat Email" id="edit_email" name="edit_email" autocomplete="off" value="' + data.email + '" required></div>';
                message += '<div class="form-group"><label for="edit_password" class="font-weight-normal">Password :</label><input type="password" class="form-control" placeholder="Password" id="edit_password" name="edit_password" autocomplete="off"><small class="form-text text-muted">Kosongkan jika tidak ingin merubah password</small></div>';
                message += '<div class="text-right"><button id="ubah_admin_btn_loading" class="btn btn-success disabled" style="display: none;">Loading...</button><button id="ubah_admin_btn_submit" type="submit" class="btn btn-success"><i class="far fa-floppy-o mr-1"></i>Simpan</button></div></form>'
                dialog.init(function(){
                    dialog.find('.bootbox-body').html(message);
                });
                $(document).ready(function(){
                    $("#edit_admin").submit(function(event){
                        event.preventDefault();
                        $('#ubah_admin_btn_loading').show();
                        $('#ubah_admin_btn_submit').hide();
                        $('.bootbox-close-button').hide();
                        var formData = new FormData(this);
                        $.ajax({
                            type:'POST',
                            dataType: 'json',
                            url: '/useradmin/edit',
                            data:formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success:function(data){
                                $('#ubah_admin_btn_loading').hide();
                                $('#ubah_admin_btn_submit').show();
                                $('.bootbox-close-button').show();
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
            });
        }

    </script>
@endpush
