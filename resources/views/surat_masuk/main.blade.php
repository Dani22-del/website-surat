@extends('components.app')
@section('css')
@endsection
@section('content')

  <div class="row gy-4">
    <h4 class="fw-bold mb-2 py-3">
       Laporan Surat Masuk
    </h4>
    <div class="main-page card p-3">
           <div class="mb-3">
            <label for="dari_tanggal">Dari Tanggal:</label>
            <input type="date" id="dari_tanggal" class="form-control" style="display:inline-block; width:auto;">
            <label for="sampai_tanggal" class="ms-2">Sampai Tanggal:</label>
            <input type="date" id="sampai_tanggal" class="form-control" style="display:inline-block; width:auto;">
            <button id="filter" class="btn btn-primary ms-2">Filter</button>
            <button id="cetak" class="btn btn-success ms-2">Cetak</button>
        </div>
        <div class="card-datatable text-nowrap p-3">
            
            <div style="overflow-x: auto">

                <table id="datagrid" class="table-hover table" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl. Surat Diterima</th>
                            <th>No. Surat</th>
                            <th>Pengirim</th>
                            <th>Perihal</th>
                            <th>Penerima</th>
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
        ajax: "{{ route('data-surat-masuk') }}",

        columns: [
            
            {
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'tanggal_diterima',
                name: 'tanggal_diterima',
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
                data: 'pengirim',
                name: 'pengirim',
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
                data: 'penerima',
                name: 'penerima',
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

     $('#filter').on('click', function() {
        var dari_tanggal = $('#dari_tanggal').val();
        var sampai_tanggal = $('#sampai_tanggal').val();
        table.ajax.url("{{ route('data-surat-masuk') }}?dari_tanggal=" + dari_tanggal + "&sampai_tanggal=" + sampai_tanggal).load();
    });

    // Aksi tombol Cetak
    $('#cetak').on('click', function() {
        var dari_tanggal = $('#dari_tanggal').val();
        var sampai_tanggal = $('#sampai_tanggal').val();
        window.open("{{ route('cetak-laporan-surat-masuk') }}?dari_tanggal=" + dari_tanggal + "&sampai_tanggal=" + sampai_tanggal, '_blank');
    });

    function cetakSuratMasuk(id) {
    // 1) Bila route kamu menerima parameter ID di URI, kamu bisa langsung:
    // var url = '{{ url("surat_keluar/cetak") }}/' + id;
    // 2) Atau bila mau pakai route() dengan nama:
    var url = '{{ route("cetak-per-surat-masuk", ":id") }}'.replace(':id', id);

    window.open(url, '_blank');
  }
   window.cetakSuratMasuk = cetakSuratMasuk;

    });
</script>

@endsection
