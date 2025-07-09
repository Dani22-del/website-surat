
<div class="card shadow-sm mb-4">
  <div class="card-header bg-warning text-white">
    <h5 class="mb-0"><i class="mdi mdi-file-document-outline me-1"></i> Detail Surat Keluar</h5>
  </div>
  <div class="card-body">
    <ul class="list-group list-group-flush">
      <li class="list-group-item">
        <strong>No. Surat:</strong>
        <span class="float-end">{{ $data?->nomor_surat ?? '–' }}</span>
      </li>
      <li class="list-group-item">
        <strong>Jenis Surat:</strong>
        <span class="badge bg-info text-dark float-end">
          {{ optional($data->jenisSurat)->kode ?? '–' }}
        </span>
      </li>
      <li class="list-group-item">
        <strong>Tanggal Surat:</strong>
        <span class="float-end">{{ $data?->tanggal_surat ?? '–' }}</span>
      </li>
      <li class="list-group-item">
        <strong>Perihal:</strong>
        <span class="float-end">{{ $data?->perihal ?? '–' }}</span>
      </li>
      <li class="list-group-item">
        <strong>Tujuan:</strong>
        <span class="float-end">{{ $data?->tujuan ?? '–' }}</span>
      </li>
      <li class="list-group-item">
        <strong>Lampiran:</strong>
        @if(!empty($data?->lampiran))
          <a href="{{ asset('storage/lampiran/'.$data->lampiran) }}" target="_blank" class="float-end">
            <i class="mdi mdi-file-download-outline"></i> {{ $data->lampiran }}
          </a>
        @else
          <span class="float-end text-muted">–</span>
        @endif
      </li>
      <li class="list-group-item">
        <strong>Ringkasan:</strong>
        <p class="mb-0 mt-1 text-justify">{{ $data?->isi ?? '–' }}</p>
      </li>

      @isset($data)
      <li class="list-group-item">
        <strong><i class="ri-user-line me-1"></i> Catatan Kepala Arsip:</strong>
        <span class="float-end">{{ $data->catatan_kepala ?: '–' }}</span>
      </li>
      <li class="list-group-item">
        <strong><i class="ri-shield-user-line me-1"></i> Catatan Direktur:</strong>
        <span class="float-end">{{ $data->catatan_direktur ?: '–' }}</span>
      </li>
      @endisset
    </ul>
  </div>
 <div class="card-footer text-end">
      <button type="reset" class="btn btn-outline-secondary btn-cancel" ><i class="ri-arrow-left-s-line me-1"></i> Kembali</button>
    </div>
</div>


<script>
 
   $('.btn-cancel').click(function(e){
    e.preventDefault();
    $('.add-data-surat-keluar-page').fadeOut(function(){
      $('.add-data-surat-keluar-page').empty();
      $('.main-page').fadeIn();
      // $('#datagrid').DataTable().ajax.reload();
    });
});

</script>