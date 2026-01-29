<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>A4</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css" />
  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>@page { size: A4 }
    #title{
        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
        font-size: 18px;
        font-weight:bold;
    }
    .tabeldatakaryawan{
        margin-top:2px;
        margin-bottom:10px
    }
    .tabeldatakaryawan td{
        padding :5px;
    }

  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">
    <table style="width=100%">
        <tr>
            <td style="padding:20px">
                <img src="{{asset('assets/img/sekolah.png')}}" width="120" height="150" alt="">
            </td>
            <td>
                <span id="title">
                    LAPORAN PRESENSI KARYAWAN <br>
                    PERIODE {{strtoupper($namabulan[$bulan])}} {{$tahun}}<br>
                    MI MITHLABUN NAJIHIN <br>
                </span>
                <span>
                    <i>Jl. Pertamina No. 77 Desa Sumberwaru RT.02/RW.05</i>
                </span>
            </td>
        </tr>
    </table>
    <table class="tabeldatakaryawan">
        <td rowspan="6">
                @php
                   $path = Storage::url('uploads/karyawan/'.$karyawan->foto)
                @endphp
                <img src="{{url($path)}}" alt="" width="120px" height="150px">
            </td>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{$karyawan->nik}}</td>
        </tr>
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td>{{$karyawan->nama_lengkap}}</td>
        </tr>
         <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{$karyawan->jabatan}}</td>
        </tr>
         <tr>
            <td>Nama Departemen</td>
            <td>:</td>
            <td>{{$karyawan->nama_dept}}</td>
        </tr>
        <tr>
            <td>Nomer Hp</td>
            <td>:</td>
            <td>{{$karyawan->no_hp}}</td>
        </tr>
         <tr>
        </tr>
    </table>
    <div class="table-responsive">
    <table class="table table-vcenter">
        <tr class="table-warning">
            <th>No</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Foto</th>
            <th>Jam Keluar</th>
            <th>Foto</th>
            <th>Keterangan</th>
            <th>Jam Kerja</th>
        </tr>
        @foreach($presensi as $item)
        @php
            $jam_terlambat = $item->jam_in;
            $jam_jadwal = '07:00:00';
            $terlambat = false;
            
            if ($jam_terlambat > $jam_jadwal) {
                $terlambat = true;
                $selisih = strtotime($jam_terlambat) - strtotime($jam_jadwal);
                $jam = floor($selisih / 3600);
                $sisa = $selisih % 3600;
                $menit = floor($sisa / 60);
            }
            $jam_masuk = $item->jam_in;
            $jam_pulang = $item->jam_out;
            $selisih_waktu = strtotime($jam_pulang) - strtotime($jam_masuk);
            $hour = floor($selisih_waktu / 3600);
            $sisa_waktu = $selisih_waktu % 3600;
            $menute = floor($sisa_waktu / 60);
        @endphp
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{date("d-m-y",strtotime($item->tgl_presensi))}}</td>
                <td>{{$item->jam_in}}</td>
                <td>
                    @if ($item->foto_in)
                    <img src="{{ url('storage/uploads/presensi/' . $item->foto_in) }}" class="avatar" alt="">
                    @endif
                </td>
                <td>
                @if ($item->jam_out != null)
                    {{ $item->jam_out }}
                @else
                    <span class="badge bg-warning text-white">Belum Absen</span>
                @endif
                </td>
                <td>
                     @if ($item->foto_out)
                    <img src="{{ url('storage/uploads/presensi/' . $item->foto_out) }}" class="avatar" alt="">
                    @endif  
                </td>
                <td>
                     @if ($terlambat)
                        <span class="badge bg-danger text-white">
                            Terlambat {{ $jam }} Jam {{ $menit }} Menit
                        </span>
                    @else
                        <span class="badge bg-success text-white">Tepat Waktu</span>
                    @endif
                    </td>
                    <td>
                        <span class="">
                            jam {{ $hour }} {{ $menute }} Menit
                        </span>
                    </td>
            </tr>
        @endforeach
    </table>
    </div>
  </section>
<script
    src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js">
</script>
</body>

</html>