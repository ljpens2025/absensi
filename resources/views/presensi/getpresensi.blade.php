@if ($presensi->isEmpty())
    <tr>
        <td colspan="9" class="text-center">Data Belum Ada</td>
    </tr>
@else
    @foreach ($presensi as $d)
        @php
            // --- LOGIKA HITUNG KETERLAMBATAN (Dipindah ke sini) ---
            $foto_in = Storage::url('uploads/absensi/' . $d->foto_in);
            $foto_out = Storage::url('uploads/absensi/' . $d->foto_out);
            
            $jam_terlambat = $d->jam_in;
            $jam_jadwal = '07:00:00';
            $terlambat = false;
            
            if ($jam_terlambat > $jam_jadwal) {
                $terlambat = true;
                $selisih = strtotime($jam_terlambat) - strtotime($jam_jadwal);
                $jam = floor($selisih / 3600);
                $sisa = $selisih % 3600;
                $menit = floor($sisa / 60);
            }
        @endphp

        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->nik }}</td>
            <td>{{ $d->nama_lengkap }}</td>
            <td>{{ $d->kode_dept }}</td>
            <td>{{ $d->jam_in }}</td>
            <td>
                @if ($d->foto_in)
                    <img src="{{ url('storage/uploads/presensi/' . $d->foto_in) }}" class="avatar" alt="">
                @endif
            </td>
            <td>
                @if ($d->jam_out != null)
                    {{ $d->jam_out }}
                @else
                    <span class="badge bg-warning text-white">Belum Absen</span>
                @endif
            </td>
            <td>
                @if ($d->foto_out)
                    <img src="{{ url('storage/uploads/presensi/' . $d->foto_out) }}" class="avatar" alt="">
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
                <a href="" class="btn btn-primary tampilkanpeta" id="{{$d->id}}" data-bs-toggle="modal" data-bs-target="#peta">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-map-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" /><path d="M9 4v13" /><path d="M15 7v5.5" /><path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879" /><path d="M19 18v.01" /></svg>
                </a>
            </td>
        </tr>
        <div class="modal" id="peta" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Peta Presensi Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                </div>
            </div>
            <div>

            </div>
        </div>
    @endforeach
    <script>
        $
    </script>
@endif