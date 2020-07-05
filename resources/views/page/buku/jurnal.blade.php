@extends('layouts.page')

@section('title')
    Buku Jurnal
@endsection

@section('content')

<div class="content-header ml-2 mr-2">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Buku Jurnal</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item">Buku</li>
                    <li class="breadcrumb-item active">Jurnal</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content ml-3 mr-3">
    <div class="container-fluid p-3 shadow-sm mb-5 bg-white rounded">
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal_tambah_buku">
            <i class="fa fa-plus mr-1"></i>Tambah Buku
        </button>
        <div class="table-responsive">
            <table id="dt_buku" class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Id Buku</th>
                        <th>Judul</th>
                        <th>Jumlah Buku</th>
                        <th>Jumlah Dipinjam</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key)
                        <tr>
                            <td>{{$key->id}}</td>
                            <td>{{$key->judul}}</td>
                            <td>{{$key->jumlah}}</td>
                            <td>{{$key->jumlah_dipinjam}}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info mb-1" onclick="location.href='/buku/jurnal/detail/{{$key->id}}';"><i class="fa fa-eye mr-1"></i>Detail</button><br>
                                <button type="button" class="btn btn-sm btn-warning mb-1" onclick="editBuku({{$key->id}})"><i class="fa fa-user-edit mr-1"></i>Ubah</button><br>
                                <button type="button" class="btn btn-sm btn-danger mb-1" onclick="hapusBuku({{$key->id}})"><i class="fa fa-trash mr-1"></i>Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_tambah_buku">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="tambah_buku">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Buku</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="judul" class="font-weight-normal">Judul Buku :</label>
                        <input type="text" class="form-control" placeholder="Judul Buku" id="judul" name="judul" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="pengarang" class="font-weight-normal">Pengarang :</label>
                        <input type="text" class="form-control" placeholder="Pengarang" id="pengarang" name="pengarang" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="sinopsis" class="font-weight-normal">Sinopsis Buku :</label>
                        <textarea rows="5" class="form-control" placeholder="Sinopsis Buku" id="sinopsis" name="sinopsis" autocomplete="off" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="tahun" class="font-weight-normal">Tahun Terbit :</label>
                                <input type="number" min="0" minlength=0 max="{{date('Y')}}" maxlength="{{date('Y')}}" class="form-control" placeholder="Tahun Terbit" id="tahun" name="tahun" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="jumlah" class="font-weight-normal">Jumlah/Stok Buku :</label>
                                <input type="number" min="0" minlength="0" class="form-control" placeholder="Jumlah/Stok Buku" id="jumlah" name="jumlah" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gambar" class="font-weight-normal">Gambar Sampul Buku :</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="gambar" name="gambar" accept="image/*" required>
                            <label class="custom-file-label" for="gambar">Pilih Gambar</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="tambah_buku_btn_loading" class="btn btn-primary disabled" style="display: none"><span class="spinner-border spinner-border-sm mr-1"></span>Loading</button>
                    <button id="tambah_buku_btn_add" type="submit" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>Tambah</button>
                    <button id="tambah_buku_btn_close" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times mr-1"></i>Tutup</button>
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
            $('#dt_buku').DataTable({
                "order": []
            });

            $("#tambah_buku").submit(function(event){
                event.preventDefault();

                $('#tambah_buku_btn_loading').show();
                $('#tambah_buku_btn_add').hide();
                $('#tambah_buku_btn_close').hide();

                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    dataType: 'json',
                    url: '/buku/jurnal/add',
                    data:formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(data){
                        $('#tambah_buku_btn_loading').hide();
                        $('#tambah_buku_btn_add').show();
                        $('#tambah_buku_btn_close').show();
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

        function hapusBuku(id){
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
                        url: '/buku/delete',
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

        function editBuku(id){
            var dialog = bootbox.dialog({
                title: 'Perubahan Data Buku',
                message: '<p><i class="fa fa-spin fa-spinner"></i> Loading...</p>'
            }).find(".modal-dialog").addClass("modal-dialog-centered");
            $.post("/buku/read", {id: id}, function(data, status){
                var message = '<form id="edit_buku"><input type="hidden" name="id_asal" value="' + data.id + '">';
                // message += '<div class="form-group"><label for="edit_id" class="font-weight-normal">Id Buku :</label><input readonly type="text" class="form-control" placeholder="Id Buku" id="edit_id" name="edit_id" autocomplete="off" value="' + data.id + '" required></div>';
                message += '<div class="form-group"><label for="edit_judul" class="font-weight-normal">Judul Buku :</label><input type="text" class="form-control" placeholder="Judul Buku" id="edit_judul" name="edit_judul" autocomplete="off" value="' + data.judul + '" required></div>';
                message += '<div class="form-group"><label for="edit_pengarang" class="font-weight-normal">Pengarang :</label><input type="text" class="form-control" placeholder="Pengarang" id="edit_pengarang" name="edit_pengarang" autocomplete="off" value="' + data.pengarang + '" required></div>';
                message += '<div class="form-group"><label for="edit_sinopsis" class="font-weight-normal">Sinopsis Buku :</label><textarea rows="5" class="form-control" placeholder="Sinopsis Buku" id="edit_sinopsis" name="edit_sinopsis" autocomplete="off" required>' + data.sinopsis + '</textarea></div>';

                message += '<div class="row">';
                message += '<div class="col"><div class="form-group"><label for="edit_tahun" class="font-weight-normal">Tahun Terbit :</label><input type="text" class="form-control" placeholder="Tahun Terbit" id="edit_tahun" name="edit_tahun" autocomplete="off" value="' + data.tahun + '" required></div></div>';
                message += '<div class="col"><div class="form-group"><label for="edit_jumlah" class="font-weight-normal">Jumlah/Stok Buku :</label><input type="text" class="form-control" placeholder="Jumlah Stok/Buku" id="edit_jumlah" name="edit_jumlah" autocomplete="off" value="' + data.jumlah + '" required></div></div>';
                message += '</div>'

                message += '<div class="form-group"><label for="edit_gambar" class="font-weight-normal">Gambar Sampul Buku :</label><div class="custom-file"><input type="file" class="custom-file-input" id="edit_gambar" name="edit_gambar" accept="image/*"><label class="custom-file-label" for="edit_gambar">Pilih Gambar</label></div><small class="form-text text-muted">Kosongkan jika tidak ingin merubah gambar</small></div>';

                message += '<div class="text-right"><button id="ubah_buku_btn_loading" class="btn btn-success disabled" style="display: none;">Loading...</button><button id="ubah_buku_btn_submit" type="submit" class="btn btn-success"><i class="far fa-floppy-o mr-1"></i>Simpan</button></div></form>';
                dialog.init(function(){
                    dialog.find('.bootbox-body').html(message);

                    // Add the following code if you want the name of the file appear on select
                    $(".custom-file-input").on("change", function() {
                        var fileName = $(this).val().split("\\").pop();
                        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                    });
                });
                $(document).ready(function(){
                    $("#edit_buku").submit(function(event){
                        event.preventDefault();
                        $('#ubah_buku_btn_loading').show();
                        $('#ubah_buku_btn_submit').hide();
                        $('.bootbox-close-button').hide();
                        var formData = new FormData(this);
                        $.ajax({
                            type:'POST',
                            dataType: 'json',
                            url: '/buku/jurnal/edit',
                            data:formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success:function(data){
                                $('#ubah_buku_btn_loading').hide();
                                $('#ubah_buku_btn_submit').show();
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
