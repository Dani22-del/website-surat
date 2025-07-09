@extends('components.app')
@section('css')
@endsection
@section('content')

<div class="card mb-4">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                             @if (Auth::check())
                                    {{-- <span class="fw-medium d-block small">{{ Auth::user()->name }}</span> --}}
                                    <h4 class="card-title text-primary">Selamat Datang, {{ Auth::user()->name }}!</h4>
                                    @php
                                        \Carbon\Carbon::setLocale('id');
                                    @endphp

                                    <p class="mb-4">
                                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                                    </p>
                                    @if (Auth::user()->level_user === 'admin_devisi')
                                    <p style="font-size: smaller" class="text-gray">Anda login sebagai Admin Divisi</p>
                                    @elseif (Auth::user()->level_user === 'kepala_arsip')
                                    <p style="font-size: smaller" class="text-gray">Anda login sebagai Kepala Arsip</p>
                                    @elseif (Auth::user()->level_user === 'direktur')
                                    <p style="font-size: smaller" class="text-gray">Anda login sebagai Direktur</p>
                                    @else
                                        <small class="text-muted">Pegawai</small>
                                    @endif

                                @else
                                    <small class="text-muted">Pegawai</small>
                                @endif
                            
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ url('assets/img/avatars/man-with-laptop-light.png') }}" height="140" alt="View >
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('js')
@endsection
