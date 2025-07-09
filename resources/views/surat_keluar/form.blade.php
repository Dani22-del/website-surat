
<div class="card p-3" id="addDataSuratKeluar"  tabindex="-1"  aria-hidden="false" aria-modal="true">
    <div class="card-header flex text-center align-items-center justify-content-center mb-4">
      <h5 class="mb-0">{{$data? "Edit Surat Keluar" : "Tambah Surat Keluar"}}</h5>
    </div>
    <div class="card-body">
      <form class="form-save">
        @csrf
        <input type="hidden" value="{{ $data ? $data->id_surat_keluar : null}}" name="id">
        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="nomor_surat" name="nomor_surat"
                        value="{{ $data ? $data->nomor_surat : null }}" class="form-control"
                        placeholder="No Surat " />
                    <label for="No Surat">No Surat *</label>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <div class="form-floating form-floating-outline">
                    <select id="jenis-surat" name="jenis_surat_id" class="select2 form-select" data-allow-clear="true">
                        @if (empty($data))
                        <option disabled selected>Pilih</option>
                        @endif
                        @foreach($jenis as $item)
                        <option value="{{$item->id}}"@if (!empty($data))
                                @if ($data->jenis_surat_id == $item->id )
                                    selected
                                @endif
                        @endif>{{$item->kode}}</option>
                        @endforeach
                    </select>
                    <label for="jenis surat">Jenis Surat *</label>
                </div>
            </div>
             <div class="col-12 col-md-6 mb-3">
                 <div class="form-floating form-floating-outline">
                            <input type="date" id="tanggal_surat" name="tanggal_surat" value="{{ $data ? $data->tanggal_surat : null }}"
                                 class="form-control"
                                placeholder="Tanggal Surat" />
                            <label for="Tanggal Surat">Tanggal Surat *</label>
                  </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                 <div class="form-floating form-floating-outline">
                            <input type="text" id="perihal" name="perihal"
                              value="{{ $data ? $data->perihal : null }}" class="form-control"
                                placeholder="Perihal" />
                            <label for="Perihal">Perihal *</label>
                  </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                 <div class="form-floating form-floating-outline">
                            <input type="text" id="tujuan" name="tujuan"
                               value="{{ $data ? $data->tujuan : null }}"  class="form-control"
                                placeholder="Tujuan" />
                            <label for="Tujuan">Tujuan *</label>
                  </div>
            </div>
              <div class="col-12 col-md-6 mb-3">
                 <div class="form-floating form-floating-outline">
                  <input type="file" class="form-control " id="lampiran" name="lampiran" >
                            <label for="Lampiran">Lampiran *</label>
                  </div>
            </div>
            <div class="col-sm-12 col-12 col-md-12 col-lg-12">
                    <div class="mb-3">
                        <label for="description" class="form-label">Ringkasan</label>
                        <textarea class="form-control " id="isi" name="isi"  rows="6">{{ $data ? $data->isi : '' }}</textarea>
                        <span class="error invalid-feedback"></span>
                    </div>
            </div>
            {{-- Hanya tampilkan kalau sedang edit --}}
            @if(isset($data))
            <div class="row g-3">
                {{-- Catatan Kepala --}}
                <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input 
                    type="text"
                    class="form-control"
                    id="catatan_kepala"
                    name="catatan_kepala"
                    placeholder="Catatan Kepala Arsip" 
                    value="{{ $data->catatan_kepala }}"
                    readonly
                    >
                    <label for="catatan_kepala">
                    <i class="ri-user-line me-1"></i> Catatan Kepala Arsip
                    </label>
                </div>
                </div>

                {{-- Catatan Direktur --}}
                <div class="col-12 col-md-6">
                <div class="form-floating">
                    <input 
                    type="text"
                    class="form-control"
                    id="catatan_direktur"
                    name="catatan_direktur"
                    placeholder="Catatan Direktur" 
                    value="{{ $data->catatan_direktur }}"
                    readonly
                    >
                    <label for="catatan_direktur">
                    <i class="ri-shield-user-line me-1"></i> Catatan Direktur
                    </label>
                </div>
                </div>
            </div>
            @endif
          <div class="col-12 text-end mt-3">
            <button type="reset" class="btn btn-outline-secondary btn-cancel" ><i class="ri-arrow-left-s-line me-1"></i> Cancel</button>
            <button type="button" class="btn btn-success me-sm-3 btn-submit me-1"><i
                    class="mdi mdi-check-all me-1"></i>Submit</button>
        </div>
        </div>
      </form>
      
    </div>
  </div>
  
<script src="{{ url('assets/vendor/libs/toastr/toastr.js') }}"></script>
<script src="{{ url('assets/js/ui-toasts.js') }}"></script>
<script>
    $(document).ready(function (){
           $("#jenis-surat").select2({
             allowClear:true
           });
    })
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
