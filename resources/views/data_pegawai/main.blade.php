@extends('components.app')
@section('css')
@endsection
@section('content')
  <div class="row gy-4">
    <h4 class="fw-bold mb-2 py-3">
        Data Pegawai
    </h4>
    <div class="main-page card p-3">
        <div class="card-datatable text-nowrap p-3">
            <div class="col-lg-3 col-sm-6 col-12 mb-4">
                <div class="demo-inline-spacing">
                    <div class="btn-group">
                        <button type="button" onclick="addDataPegawai()" class="btn btn-sm btn-primary">
                            <i class="mdi mdi-plus-box-multiple-outline me-1"></i> Tambah Baru
                        </button>
                    </div>
                </div>
            </div>
            <div style="overflow-x: auto">

                <table id="datagrid" class="table-hover table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama Lengkap</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="add-data-pegawai-page"></div>
  </div>
@endsection

@section('js')

<script>
    $(function() {
    var table = $('#datagrid').DataTable({
        processing: true,
        serverSide: true,
        language: {
            searchPlaceholder: "Ketikkan yang dicari"
        },
        ajax: "{{ route('data-pegawai') }}",

        columns: [
            // {
            //     data: 'pengepul',
            //     name: 'nama_pengepul',
            //     render: function(data, type, row) {
            //         return '<p style="color:black">' + data.nama_pengepul + '</p>';
            //     }
            // },
            {
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'no_ktp',
                name: 'no_ktp',
                render: function(data, type, row) {
                    return '<p style="color:black">' + data + '</p>';
                }
            },
            {
                data: 'name',
                name: 'name',
                render: function(data, type, row) {
                    return '<p style="color:black">' + data + '</p>';
                }
            },
            {
                data: 'level_user',
                name: 'level_user',
                render: function(data, type, row) {
                    return '<p style="color:black">' + data + '</p>';
                }
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });
    });
</script>
<script type="text/javascript">
        function addDataPegawai() {
        $('.main-page').hide()
        $.post("{!! route('form-add-data-pegawai') !!}").done(function(data) {
            if (data.status == 'success') {
                // $('.add-schedule-page').html('');
                $('.add-data-pegawai-page').html(data.content).fadeIn();
                // $('#addPetani').modal('show'); // Show the modal
            } else {
                $('.main-page').show();
            }
        });
    }

        function editForm(id) {
        $('.main-page').hide()
            $.post("{!! route('form-add-data-pegawai') !!}", {
                id: id
            }).done(function(data) {
                if (data.status == 'success') {
                    $('.add-data-pegawai-page').html(data.content).fadeIn();
                } else {
                    $('.main-page').show();
                }
            });
    }

        function deleteForm(id) {
            Swal.fire({
                title: "Apakah Anda yakin akan menghapus data ini ?",
                text: "Data akan dihapus dan tidak dapat diperbaharui kembali!",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Hapus Data!',
            }).then((result) => {
                if (result.value) {
                    $.post("{!! route('destroy-data-pegawai') !!}", {
                        id: id
                    }).done(function(data) {
                        console.log(data);
                        toastr.success(data.success);
                        $('.preloader').show();
                        $('#datagrid').DataTable().ajax.reload();
                    }).fail(function() {
                        toastr.error(data);
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastr.warning('Penghapusan dibatalkan');
                    $('#datagrid').DataTable().ajax.reload();
                }
            });
        }
        function detailDataPegawai(id) {
            $('.main-page').hide()
            $.post("{!! route('detail-data-pegawai') !!}",{id:id}).done(function(data) {
                if (data.status == 'success') {
                    // $('.add-absensi-page').html('');
                    $('.add-data-pegawai-page').html(data.content).fadeIn();
                } else {
                    $('.main-page').show();
                }
            });
        } 
   
</script>
@endsection
