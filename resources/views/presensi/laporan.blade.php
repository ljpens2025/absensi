@extends('layout.admin.tabler')
@section('content')
<div class="page-header d-print-none" aria-label="Page header">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <h2 class="page-title">Laporan Presensi</h2>
              </div>
            </div>
          </div>
</div>
<div class="page-body">
<div class="container-xl">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <form action="/dashboardadmin/cetaklaporan" target="_blank" method="POST">
                        @csrf
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <select name="bulan" id="bulan" class="form-select">
                                        <option value="">Bulan</option>
                                        @for($i=1; $i<=12; $i++)
                                          <option value="{{ $i }}" {{ $i == date('m') ? 'selected' : '' }}>{{ $namabulan[$i] }}</option>
                                        @endfor 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <select name="tahun" id="tahun" class="form-select">
                                        <option value="">Tahun</option>
                                             @php
                                            $tahunmulai = 2022; // Sesuaikan tahun mulai
                                                $tahunsekarang = date('Y');
                                            @endphp
                                            @for($t = $tahunmulai; $t <= $tahunsekarang; $t++)
                                                <option value="{{ $t }}" {{ $t == $tahunsekarang ? 'selected' : '' }}>{{ $t }}</option>
                                            @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <select name="nik" id="nik" class="form-select">
                                        <option value="">Pilih Karyawan</option>
                                        @foreach($karyawan as $d)
                                            <option value="{{$d->nik}}">{{$d->nama_lengkap}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <div class="form-group">
                                   <button type="submit" class="btn btn-primary w-100"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 15a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2l0 -4" /></svg>Cetak</button>
                                </div>
                            </div>
                             <div class="col-6">
                                <div class="form-group">
                                   <button type="submit" class="btn btn-success w-100"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-export"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M11.5 21h-4.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v5m-5 6h7m-3 -3l3 3l-3 3" /></svg>Export Excel</button>
                                </div>
                             </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection