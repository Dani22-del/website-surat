@extends('components.app')
@section('css')
@endsection
@section('content')

  <div class="row gy-4">
    <h4 class="fw-bold mb-2 py-3">
        Surat Keluar
    </h4>
    <div class="main-page card p-3">
        <div class="card-datatable text-nowrap p-3">
            <div class="col-lg-3 col-sm-6 col-12 mb-4">
                <div class="demo-inline-spacing">
                   @php
                        $level = Auth::user()->level_user;
                    @endphp

                    {{-- Hanya tampilkan tombol “Tambah” untuk admin_devisi --}}
                    @if($level === 'admin_devisi')
                    <div class="btn-group">
                        <button type="button" onclick="addSuratKeluar()" class="btn btn-sm btn-primary">
                        <i class="mdi mdi-plus-box-multiple-outline me-1"></i> Tambah
                        </button>
                    </div>
                    @endif

                {{-- Hanya tampilkan tombol “Cek Kepala Arsip” untuk kepala_arsip --}}
                </div>
            </div>
            <div style="overflow-x: auto">

                <table id="datagrid" class="table-hover table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Status</th>
                            <th>Tgl. Surat</th>
                            <th>No. Surat</th>
                            <th>Perihal</th>
                            <th>Tujuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="add-data-surat-keluar-page"></div>
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
        ajax: "{{ route('data-surat-keluar') }}",

        columns: [
            
            {
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'status',
                name: 'status',
                render: function(data, type, row) {
                    return '<p style="color:black">' + data + '</p>';
                }
            },
            {
                data: 'tanggal_surat',
                name: 'tanggal_surat',
                render: function(data, type, row) {
                    return '<p style="color:black">' + data + '</p>';
                }
            },
            {
                data: 'nomor_surat',
                name: 'nomor_surat',
                render: function(data, type, row) {
                    return '<p style="color:black">' + data + '</p>';
                }
            },
            {
                data: 'perihal',
                name: 'perihal',
                render: function(data, type, row) {
                    return '<p style="color:black">' + data + '</p>';
                }
            },
            {
                data: 'tujuan',
                name: 'tujuan',
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
        function addSuratKeluar() {
        $('.main-page').hide()
        $.post("{!! route('form-add-surat-keluar') !!}").done(function(data) {
            if (data.status == 'success') {
                // $('.add-schedule-page').html('');
                $('.add-data-surat-keluar-page').html(data.content).fadeIn();
                // $('#addPetani').modal('show'); // Show the modal
            } else {
                $('.main-page').show();
            }
        });
    }

        function editForm(id) {
        $('.main-page').hide()
            $.post("{!! route('form-add-surat-keluar') !!}", {
                id: id
            }).done(function(data) {
                if (data.status == 'success') {
                    $('.add-data-surat-keluar-page').html(data.content).fadeIn();
                } else {
                    $('.main-page').show();
                }
            });
    }

    function detailSuratKeluar(id) {
            $('.main-page').hide()
            $.post("{!! route('detail-surat-keluar') !!}",{id:id}).done(function(data) {
                if (data.status == 'success') {
                    // $('.add-absensi-page').html('');
                    $('.add-data-surat-keluar-page').html(data.content).fadeIn();
                } else {
                    $('.main-page').show();
                }
            });
    }

    function cekKepalaArsip(id) {
            $('.main-page').hide()
            $.post("{!! route('cek-kepala-surat-keluar') !!}",{id:id}).done(function(data) {
                if (data.status == 'success') {
                    // $('.add-absensi-page').html('');
                    $('.add-data-surat-keluar-page').html(data.content).fadeIn();
                } else {
                    $('.main-page').show();
                }
            });
        }
        function cekDirektur(id) {
            $('.main-page').hide()
            $.post("{!! route('cek-direktur-surat-keluar') !!}",{id:id}).done(function(data) {
                if (data.status == 'success') {
                    // $('.add-absensi-page').html('');
                    $('.add-data-surat-keluar-page').html(data.content).fadeIn();
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
                    $.post("{!! route('destroy-surat-keluar') !!}", {
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
   
</script>
@endsection
