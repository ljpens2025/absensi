@extends('layout.admin.tabler')
@section('content')
<div class="page-header d-print-none" aria-label="Page header">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Monitoring </div>
                <h2 class="page-title">Monitoring Presensi</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                              <label class="form-label">Tanggal Presensi</label>
                              <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M7 14h.013" /><path d="M10.01 14h.005" /><path d="M13.01 14h.005" /><path d="M16.015 14h.005" /><path d="M13.015 17h.005" /><path d="M7.01 17h.005" /><path d="M10.01 17h.005" /></svg>
                                    </span>
                                    <input type="text" id="datepicker" value="{{date("y-m-d")}}" name="tanggal" class="form-control" placeholder="Pilih Tanggal Presensi" autpocomplete="off"/>
                              </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nik</th>
                                            <th>Nama Karyawan</th>
                                            <th>Departemen</th>
                                            <th>Jam Masuk</th>
                                            <th>Foto</th>
                                            <th>Jam Keluar</th>
                                            <th>Foto</th>
                                            <th>Keterangan</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                   <tbody id="load_presensi">

                                   </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('myscript')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // 1. Ambil tanggal hari ini dari value input yang sudah diset oleh PHP
    var tanggal = document.getElementById('datepicker').value;

    // 2. Panggil fungsi loadPresensi AGAR LANGSUNG MUNCUL saat loading page
    if(tanggal != ""){
        loadPresensi(tanggal);
    }

    // 3. Konfigurasi Litepicker (Biarkan seperti sebelumnya)
    window.Litepicker && (new Litepicker({
        element: document.getElementById('datepicker'),
        buttonText: {
            previousMonth: '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>',
            nextMonth: '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg>',
        },
        format: 'YYYY-MM-DD',
        setup: (picker) => {
            picker.on('selected', (date1, date2) => {
                var tanggal = document.getElementById('datepicker').value;
                loadPresensi(tanggal);
            });
        }
    }));
});

// Fungsi AJAX tetap sama
function loadPresensi(tanggal) {
    $.ajax({
        type: 'POST',
        url: '/getpresensi',
        data: {
            _token: "{{ csrf_token() }}",
            tanggal: tanggal
        },
        cache: false,
        success: function(respond) {
            $("#load_presensi").html(respond);
        },
        error: function(xhr) {
            alert('Gagal mengambil data');
            console.log(xhr);
        }
    });
}
</script>
@endpush
@endsection