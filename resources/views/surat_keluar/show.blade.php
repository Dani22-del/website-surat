
<div class="card p-3"  tabindex="-1"  aria-hidden="false" aria-modal="true">
  <div class="card-header flex text-center align-items-center justify-content-center mb-4">
    <h5 class="mb-0">Detail Data Pegawai</h5>
  </div>
  <div class="card-body">
    <form class="form-save">
      @csrf
      <input type="hidden" value="{{ $data ? $data->id : null}}" name="id">
      <div class="row">
         <div class="col-12 col-md-6 mb-3">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="name" name="name"
                        value="{{ $data ? $data->name : null }}" class="form-control" readonly
                        placeholder="Nama Lengkap " />
                    <label for="Nama Lengkap">Nama Lengkap *</label>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                 <div class="form-floating form-floating-outline">
                            <input type="email" id="email" name="email"
                                value="{{ $data ? $data->email : null }}" class="form-control" readonly
                                placeholder="Alamat Email" />
                            <label for="email">Email *</label>
                  </div>
            </div>
             <div class="col-6 form-password-toggle mb-3">
                        <div class="input-group input-group-merge">
                            <div class="form-floating form-floating-outline">
                                <input type="password" id="password" name="password" class="form-control" readonly
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                <label for="password">Password *</label>
                            </div>
                            <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                        </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                 <div class="form-floating form-floating-outline">
                            <input type="text" id="no_ktp" name="no_ktp"
                                value="{{ $data ? $data->no_ktp : null }}" class="form-control" readonly
                                placeholder="Nomor KTP" />
                            <label for="Nomor KTP">Nomor KTP *</label>
                  </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                 <div class="form-floating form-floating-outline">
                            <input type="number" id="phone" name="phone"
                                value="{{ $data ? $data->phone : null }}" class="form-control" readonly
                                placeholder="Nomor Telepon" />
                            <label for="Nomor Telepon">Nomor Telepon *</label>
                  </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                 <div class="form-floating form-floating-outline">
                            <input type="text" id="alamat" name="alamat"
                                value="{{ $data ? $data->alamat : null }}" class="form-control" readonly
                                placeholder="Alamat" />
                            <label for="Alamat">Alamat *</label>
                  </div>
            </div>
             <div class="col-12 col-md-6 mb-3">
                <div class="form-floating form-floating-outline">
                            <select id="level-user" name="level_user" class="select2 form-select" data-allow-clear="true" disabled>
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
               <div class="col-12 col-md-6 mb-3">
                        <small class="text-light fw-semibold d-block">Status</small>
                        <div class="form-check form-check-success form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="status" disabled id="Aktif" @if ($data ? $data->status == 'Aktif' : null) @checked(true) @endif
                                value="Aktif"
                                 />
                            <label class="form-check-label" for="Aktif">Aktif</label>
                        </div>
                        <div class="form-check form-check-danger form-check-inline">
                            <input class="form-check-input" type="radio" name="status" disabled id="Non-Aktif" @if ($data ? $data->status == 'Non-Aktif' : null) @checked(true) @endif
                                value="Non-Aktif"
                                 />
                            <label class="form-check-label" for="Non-Aktif">Non-Aktif</label>
                        </div>
               </div>
      </div>
    </form>
    <div class="col-12 text-end">
      <button type="reset" class="btn btn-outline-secondary btn-cancel" ><i class="ri-arrow-left-s-line me-1"></i> Cancel</button>
    </div>
  </div>
</div>

<script>
 
   $('.btn-cancel').click(function(e){
    e.preventDefault();
    $('.add-data-pegawai-page').fadeOut(function(){
      $('.add-data-pegawai-page').empty();
      $('.main-page').fadeIn();
      // $('#datagrid').DataTable().ajax.reload();
    });
});

</script>