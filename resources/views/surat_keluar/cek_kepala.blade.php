
<div class="card p-3"  tabindex="-1"  aria-hidden="false" aria-modal="true">
  <div class="card-header flex text-center align-items-center justify-content-center mb-4">
    <h5 class="mb-0">Validasi Surat Keluar</h5>
  </div>
  <div class="card-body">
    {{-- Judul Informasi Surat --}}
    <h5 class="card-title bg-primary text-white p-2">Informasi Surat</h5>

    <table class="table table-striped mb-4">
      <tbody>
        <tr>
          <th scope="row" style="width: 30%;">Nomor Surat</th>
          <td>{{ $data->nomor_surat }}</td>
        </tr>
        <tr>
          <th scope="row">Tanggal Surat</th>
          <td>{{ $data->tanggal_surat}}</td>
        </tr>
        <tr>
          <th scope="row">Perihal</th>
          <td>{{ $data->perihal }}</td>
        </tr>
        <tr>
          <th scope="row">Tujuan</th>
          <td>{{ $data->tujuan }}</td>
        </tr>
        <tr>
          <th scope="row">Lampiran</th>
          <td>
            @if($data->lampiran)
              <a href="{{ url('storage/'.$data->lampiran) }}" target="_blank">Lihat File</a>
            @else
              -
            @endif
          </td>
        </tr>
        <tr>
          <th scope="row">Status</th>
          <td>{{ $data->status_divisi }}</td>
        </tr>
      </tbody>
    </table>

        <form class="form-save">
          @csrf
          <input type="hidden" value="{{ $data ? $data->id_surat_keluar : null}}" name="id">
          <div class="row">
            <h5 class="card-title bg-warning text-white p-2">Tindakan Selanjutnya</h5>
                <table class="table table-striped mb-4">
      <tbody>
        {{-- Baris baru: Catatan --}}
        <tr>
          <th scope="row">Catatan</th>
          <td>
            <textarea
              name="catatan_kepala"
              class="form-control"
              rows="3"
              placeholder="Berikan catatan untuk surat ini jika diperlukan"
            >{{ old('catatan_kepala', $data->catatan_kepala ?? '') }}</textarea>
          </td>
        </tr>

        {{-- Baris baru: Tindakan --}}
        <tr>
          <th scope="row">Tindakan</th>
          <td>
           <select name="tindakan" id="tindakan" class="select2 form-select">
            <!-- placeholder: hidden sehingga tidak muncul di dropdown -->
            <option value="" disabled selected hidden>-- Pilih Tindakan --</option>

            <!-- opsi sebenarnya -->
            <option value="Revisi"
              {{ old('tindakan', $data->status_arsip ?? '') == 'Revisi' ? 'selected' : '' }}>
              Koreksi Kembali
            </option>
            <option value="Approved"
              {{ old('tindakan', $data->status_arsip ?? '') == 'Approved' ? 'selected' : '' }}>
              Ajukan ke Direktur
            </option>
          </select>

          </td>
        </tr>
      </tbody>
    </table>
           
          <div class="col-12 text-end">
            <button type="reset" class="btn btn-outline-secondary btn-cancel" ><i class="ri-arrow-left-s-line me-1"></i> Cancel</button>
            <button type="button" class="btn btn-success me-sm-3 btn-submit me-1"><i
                    class="mdi mdi-check-all me-1"></i>Submit</button>
        </div>
    </form>
  </div>
</div>

<script src="{{ url('assets/vendor/libs/toastr/toastr.js') }}"></script>
<script src="{{ url('assets/js/ui-toasts.js') }}"></script>
<script>
  $(document).ready(function() {
    $('#tindakan').select2({
      placeholder: '-- Pilih Tindakan --',
      allowClear: false,    // tanpa tombol clear
     
    });
  });
 $('.btn-submit').click(function(e) {
        e.preventDefault();
        // $('.btn-submit').html('Please wait...').attr('disabled', true);
        $('.btn-submit');
        var data = new FormData($('.form-save')[0]);
        $.ajax({
            url: "{{ route('store-surat-keluar') }}",
            type: 'POST',
            data: data,
            async: true,
            cache: false,
            contentType: false,
            processData: false
        }).done(function(data) {
            $('.form-save').validate(data, 'has-error');
            if (data.status == 'success') {
                toastr.success(data.message);
                $('#addDataSuratKeluar').hide(); // Show the modal
                $('.main-page').show();
                $('#datagrid').DataTable().ajax.reload();
            } else if (data.status == 'error') {
                $('.btn-submit');
                Lobibox.notify('error', {
                    pauseDelayOnHover: true,
                    size: 'mini',
                    rounded: true,
                    delayIndicator: false,
                    icon: 'bx bx-x-circle',
                    continueDelayOnInactiveTab: false,
                    position: 'top right',
                    sound: false,
                    msg: data.message
                });
                swal('Error :' + data.errMsg.errorInfo[0], data.errMsg.errorInfo[2], 'warning');
            } else {
                var n = 0;
                for (key in data) {
                    if (n == 0) {
                        var dt0 = key;
                    }
                    n++;
                }
                $('.btn-submit');
                Lobibox.notify('warning', {
                    pauseDelayOnHover: true,
                    size: 'mini',
                    rounded: true,
                    delayIndicator: false,
                    icon: 'bx bx-error',
                    continueDelayOnInactiveTab: false,
                    position: 'top right',
                    sound: false,
                    msg: data.message
                });
            }
        }).fail(function() {
            $('.btn-submit');
            Lobibox.notify('warning', {
                title: 'Maaf!',
                pauseDelayOnHover: true,
                size: 'mini',
                rounded: true,
                delayIndicator: false,
                icon: 'bx bx-error',
                continueDelayOnInactiveTab: false,
                position: 'top right',
                sound: false,
                msg: 'Terjadi Kesalahan, Silahkan Ulangi Kembali atau Hubungi Tim IT !!'
            });
        });
});
$('.btn-cancel').click(function(e){
    e.preventDefault();
    $('.add-data-surat-keluar-page').fadeOut(function(){
      $('.add-data-surat-keluar-page').empty();
      $('.main-page').fadeIn();
      // $('#datagrid').DataTable().ajax.reload();
    });
});

</script>