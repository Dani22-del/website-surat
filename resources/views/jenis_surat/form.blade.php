
<div class="card p-3" id="addJenisSurat"  tabindex="-1"  aria-hidden="false" aria-modal="true">
    <div class="card-header flex text-center align-items-center justify-content-center mb-4">
      <h5 class="mb-0">{{$data? "Edit Jenis Surat" : "Tambah Jenis Surat"}}</h5>
    </div>
    <div class="card-body">
      <form class="form-save">
        @csrf
        <input type="hidden" value="{{ $data ? $data->id : null}}" name="id">
        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="kode" name="kode"
                        value="{{ $data ? $data->kode : null }}" class="form-control"
                        placeholder="Kode " />
                    <label for="Kode">Kode *</label>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="type" name="type"
                        value="{{ $data ? $data->type : null }}" class="form-control"
                        placeholder="Klasifikasi " />
                    <label for="Klasifikasi">Klasifikasi *</label>
                </div>
            </div>
            <div class="col-12 col-md-12 mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="deskripsi" name="deskripsi"
                        value="{{ $data ? $data->deskripsi : null }}" class="form-control"
                        placeholder="Deskripsi " />
                    <label for="Deskripsi">Deskripsi *</label>
                </div>
            </div>
          <div class="col-12 text-end">
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
    // $(document).ready(function (){
    //        $("#nama-pengepul").select2({
    //          allowClear:true,
    //          placeholder: 'Search for a petani'
    //        });
    // })
$('.btn-submit').click(function(e) {
        e.preventDefault();
        // $('.btn-submit').html('Please wait...').attr('disabled', true);
        $('.btn-submit');
        var data = new FormData($('.form-save')[0]);
        $.ajax({
            url: "{{ route('store-jenis-surat') }}",
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
                $('#addJenisSurat').hide(); // Show the modal
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
    $('.add-jenis-surat-page').fadeOut(function(){
      $('.add-jenis-surat-page').empty();
      $('.main-page').fadeIn();
      // $('#datagrid').DataTable().ajax.reload();
    });
});
    
</script>
