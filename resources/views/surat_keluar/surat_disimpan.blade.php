@extends('components.app')
@section('css')
@endsection
@section('content')

  <div class="row gy-4">
    <h4 class="fw-bold mb-2 py-3">
       Surat Disimpan
    </h4>
    <div class="main-page card p-3">
        <div class="card-datatable text-nowrap p-3">
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
        ajax: "{{ route('laporan-surat-disimpan') }}",

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
        ]
    });
    });
</script>

@endsection
