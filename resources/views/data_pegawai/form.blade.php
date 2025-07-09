
<div class="card p-3" id="addDataPegawai"  tabindex="-1"  aria-hidden="false" aria-modal="true">
    <div class="card-header flex text-center align-items-center justify-content-center mb-4">
      <h5 class="mb-0">{{$data? "Edit Data Pegawai" : "Tambah Data Pegawai"}}</h5>
    </div>
    <div class="card-body">
      <form class="form-save">
        @csrf
        <input type="hidden" value="{{ $data ? $data->id : null}}" name="id">
        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="name" name="name"
                        value="{{ $data ? $data->name : null }}" class="form-control"
                        placeholder="Nama Lengkap " />
                    <label for="Nama Lengkap">Nama Lengkap *</label>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                 <div class="form-floating form-floating-outline">
                            <input type="email" id="email" name="email"
                                value="{{ $data ? $data->email : null }}" class="form-control"
                                placeholder="Alamat Email" />
                            <label for="email">Email *</label>
                  </div>
            </div>
            <div class="col-6 form-password-toggle mb-3">
                <label for="password" class="form-label">
                  Password
                  @if($data)
                    <small class="text-muted">(kosongkan untuk tidak mengganti)</small>
                  @endif
                </label>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    autocomplete="new-password"
                  />
                  <span class="input-group-text cursor-pointer">
                    <i class="mdi mdi-eye-off-outline"></i>
                  </span>
                </div>
              </div>

            <div class="col-12 col-md-6 mb-3">
                 <div class="form-floating form-floating-outline">
                            <input type="text" id="no_ktp" name="no_ktp"
                                value="{{ $data ? $data->no_ktp : null }}" class="form-control"
                                placeholder="Nomor KTP" />
                            <label for="Nomor KTP">Nomor KTP *</label>
                  </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                 <div class="form-floating form-floating-outline">
                            <input type="number" id="phone" name="phone"
                                value="{{ $data ? $data->phone : null }}" class="form-control"
                                placeholder="Nomor Telepon" />
                            <label for="Nomor Telepon">Nomor Telepon *</label>
                  </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                 <div class="form-floating form-floating-outline">
                            <input type="text" id="alamat" name="alamat"
                                value="{{ $data ? $data->alamat : null }}" class="form-control"
                                placeholder="Alamat" />
                            <label for="Alamat">Alamat *</label>
                  </div>
            </div>
             <div class="col-12 col-md-6 mb-3">
                <div class="form-floating form-floating-outline">
                            <select id="level-user" name="level_user" class="select2 form-select" data-allow-clear="true">
                                 @if (empty($data))
                                <option disabled selected>Pilih</option>
                                @endif
                                 @foreach($statuses as $key => $label)
                                  <option value="{{ $key }}" @selected($data && $data->level_user === $key)>
                                    {{ $label }}
                                  </option>
                                @endforeach
                            </select>
                            <label for="level_user">Level User</label>
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
    $(document).ready(function (){
           $("#level-user").select2({
             allowClear:true
           });
    })
$('.btn-submit').click(function(e) {
        e.preventDefault();
        // $('.btn-submit').html('Please wait...').attr('disabled', true);
        $('.btn-submit');
        var data = new FormData($('.form-save')[0]);
        $.ajax({
            url: "{{ route('store-data-pegawai') }}",
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
                $('#addDataPegawai').hide(); // Show the modal
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
    $('.add-data-pegawai-page').fadeOut(function(){
      $('.add-data-pegawai-page').empty();
      $('.main-page').fadeIn();
      // $('#datagrid').DataTable().ajax.reload();
    });
});
    
</script>
