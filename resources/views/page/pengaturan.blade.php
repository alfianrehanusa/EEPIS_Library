@extends('layouts.page')

@section('content')

<div class="content-header ml-2 mr-2">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pengaturan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Pengaturan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content ml-3 mr-3">
    <div class="container-fluid p-3 shadow-sm mb-5 bg-white rounded">
        <div class="table-responsive">
            <table id="dt_pengaturan" class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Nama Pengaturan</th>
                        <th>Jumlah Hari</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key)
                        <tr>
                            <td>{{$key->nama}}</td>
                            <td>{{$key->nilai}} hari</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning" onclick="editPengaturan({{$key->id}})"><i class="fa fa-user-edit mr-1"></i>Ubah</button>
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
            $('#dt_pengaturan').DataTable({
                "order": []
            });
        });

        function editPengaturan(id){
            var dialog = bootbox.dialog({
                title: 'Perubahan Pengaturan',
                size: 'small',
                message: '<p><i class="fa fa-spin fa-spinner"></i> Loading...</p>'
            }).find(".modal-dialog").addClass("modal-dialog-centered");
            $.post("/pengaturan/read", {id: id}, function(data, status){
                var message = '<form id="edit_pengaturan"><input type="hidden" name="id" value="' + data.id + '">';
                message += '<div class="form-group"><label for="edit_nilai" class="font-weight-normal">Jumlah Hari :</label><input type="number" min="1" class="form-control" placeholder="Jumlah Hari" id="edit_nilai" name="edit_nilai" autocomplete="off" value="' + data.nilai + '" required></div>';
                message += '<div class="text-right"><button id="ubah_pengaturan_btn_loading" class="btn btn-success disabled" style="display: none;">Loading...</button><button id="ubah_pengaturan_btn_submit" type="submit" class="btn btn-success"><i class="far fa-floppy-o mr-1"></i>Simpan</button></div></form>'
                dialog.init(function(){
                    dialog.find('.bootbox-body').html(message);
                });
                $(document).ready(function(){
                    $("#edit_pengaturan").submit(function(event){
                        event.preventDefault();
                        $('#ubah_pengaturan_btn_loading').show();
                        $('#ubah_pengaturan_btn_submit').hide();
                        $('.bootbox-close-button').hide();
                        var formData = new FormData(this);
                        $.ajax({
                            type:'POST',
                            dataType: 'json',
                            url: '/pengaturan/edit',
                            data:formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success:function(data){
                                $('#ubah_pengaturan_btn_loading').hide();
                                $('#ubah_pengaturan_btn_submit').show();
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
