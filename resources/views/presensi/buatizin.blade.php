@extends('layout.presensi')
@section('header')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form Izin / Sakit</div>
    <div class="right"></div>
</div>
<style>
    /* Paksa datepicker memiliki z-index tertinggi */
    .datepicker {
        z-index: 99999 !important;
        margin-top: 50px;
    }
    
    /* Opsional: Jika menggunakan modal bootstrap */
    .datepicker-dropdown {
        z-index: 99999 !important;
        margin-top: 50px;
    }
</style>
@endsection
@section('content')
<div class="row" style="margin-top: 70px;">
    <div class="col">
        <form method="POST" action="{{ route('storeizinPresensi') }}" enctype="multipart/form-data" id="formIzin">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group">
                       <input type="text" id="datepicker" name="tgl_izin" class="form-control" placeholder="Tanggal">
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="col">
                    <div class="form-group">
                       <select name="jenis_izin" id="status" class="form-control">
                            <option value="">Izin / Sakit</option>
                            <option value="i">Izin</option>
                            <option value="s">Sakit</option>
                        </select>
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="col">
                    <div class="form-group">
                          <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Keterangan"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary w-100">Kirim</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('myscript') <script>
    $(document).ready(function(){
        $("#datepicker").datepicker({
            format: "yyyy-mm-dd", // Format tanggal SQL (Tahun-Bulan-Tanggal)
            autoclose: true,      // Otomatis tutup setelah memilih tanggal
            todayHighlight: true,  // Menandai hari ini
        });
        $("#formIzin").submit(function(){
            var tgl_izin = $("#datepicker").val();
            var jenis_izin = $("#status").val();
            var keterangan = $("#keterangan").val();
            if(tgl_izin == ""){
                 Swal.fire({
                        title: 'Gagal Kirim!',
                        text: 'Tanggal Izin / Sakit Harus Diisi',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                return false;
            } else if(jenis_izin == ""){
                Swal.fire({
                        title: 'Gagal Kirim!',
                        text: 'Jenis Izin / Sakit Harus Diisi',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                return false;
            } else if(keterangan == ""){
                Swal.fire({
                        title: 'Gagal Kirim!',
                        text: 'Keterangan Harus Diisi',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                return false;
            }
        });
    });
</script>
@endpush