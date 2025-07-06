<ul class="menu-inner py-1">
  @switch(Auth::user()->level_user)

    @case('admin_devisi')
      {{-- Admin Devisi --}}
      <li class="menu-item {{ Route::is('dashboard-admin') ? 'active' : '' }}">
        <a href="{{ route('dashboard-admin') }}" class="menu-link">
          <i class="menu-icon tf-icons ri-home-smile-line"></i>
          <div data-i18n="Dashboards">Dashboards</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="" class="menu-link">
          <i class="menu-icon tf-icons ri-mail-open-line"></i>
          <div data-i18n="Surat Masuk">Surat Masuk</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ri-file-copy-line"></i>
          <div data-i18n="Surat Keluar">Surat Keluar</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ Route::is('data-surat-keluar') ? 'active' : '' }}">
            <a href="{{ route('data-surat-keluar') }}" class="menu-link">
              <div data-i18n="Data Surat Keluar">Data Surat Keluar</div>
            </a>
          </li>
          <li class="menu-item {{ Route::is('data-pegawai') ? 'active' : '' }}">
            <a href="{{ route('data-pegawai') }}" class="menu-link">
              <div data-i18n="Data Pegawai">Data Pegawai</div>
            </a>
          </li>
          <li class="menu-item {{ Route::is('data-jenis-surat') ? 'active' : '' }}">
            <a href="{{ route('data-jenis-surat') }}" class="menu-link">
              <div data-i18n="Jenis Surat">Jenis Surat</div>
            </a>
          </li>
        </ul>
      </li>
      @break

    @case('kepala_arsip')
      {{-- Kepala Arsip --}}
      <li class="menu-item {{ Route::is('dashboard-admin') ? 'active' : '' }}">
        <a href="{{ route('dashboard-admin') }}" class="menu-link">
          <i class="menu-icon tf-icons ri-home-smile-line"></i>
          <div data-i18n="Dashboards">Dashboards</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="" class="menu-link">
          <i class="menu-icon tf-icons ri-mail-open-line"></i>
          <div data-i18n="Surat Masuk">Surat Masuk</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ri-file-copy-line"></i>
          <div data-i18n="Surat Keluar">Surat Keluar</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ Route::is('data-surat-keluar') ? 'active' : '' }}">
            <a href="{{ route('data-surat-keluar') }}" class="menu-link">
              <div data-i18n="Data Surat Keluar">Data Surat Keluar</div>
            </a>
          </li>
          <li class="menu-item {{ Route::is('laporan-surat-keluar') ? 'active' : '' }}">
            <a href="{{ route('laporan-surat-keluar') }}" class="menu-link">
              <div data-i18n="Laporan Surat Keluar">Laporan Surat Keluar</div>
            </a>
          </li>
        </ul>
      </li>
      @break

    @case('direktur')
      {{-- Direktur --}}
       <li class="menu-item {{ Route::is('dashboard-admin') ? 'active' : '' }}">
        <a href="{{ route('dashboard-admin') }}" class="menu-link">
          <i class="menu-icon tf-icons ri-home-smile-line"></i>
          <div data-i18n="Dashboards">Dashboards</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="" class="menu-link">
          <i class="menu-icon tf-icons ri-mail-open-line"></i>
          <div data-i18n="Surat Masuk">Surat Masuk</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ri-file-copy-line"></i>
          <div data-i18n="Surat Keluar">Surat Keluar</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ Route::is('data-surat-keluar') ? 'active' : '' }}">
            <a href="{{ route('data-surat-keluar') }}" class="menu-link">
              <div data-i18n="Data Surat Keluar">Data Surat Keluar</div>
            </a>
          </li>
        </ul>
      </li>
      @break

    @default
      {{-- Role lain atau guest --}}
      <li class="menu-item">
        <a href="" class="menu-link">
          <i class="menu-icon tf-icons ri-home-3-line"></i>
          <div data-i18n="Home">Home</div>
        </a>
      </li>

  @endswitch
</ul>

