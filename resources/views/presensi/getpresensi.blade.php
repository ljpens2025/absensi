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
                <a href="#" class="btn btn-primary tampilkanpeta" id="peta-{{$d->id}}" 
                   data-bs-toggle="modal" data-bs-target="#modalPeta"
                   data-lat="{{ $d->latitude }}" 
                   data-lng="{{ $d->longitude }}"
                   data-nama="{{ $d->nama_lengkap }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-map-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" /><path d="M9 4v13" /><path d="M15 7v5.5" /><path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879" /><path d="M19 18v.01" /></svg>
                </a>
            </td>
        </tr>
        <div class="modal fade" id="modalPeta" tabindex="-1" role="dialog" aria-labelledby="modalPetaLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPetaLabel">Peta Lokasi Presensi Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="mapContainer" style="height: 400px; border-radius: 8px;"></div>
                        <div class="mt-3">
                            <p><strong>Nama Karyawan:</strong> <span id="namaKaryawan"></span></p>
                            <p><strong>Status Lokasi:</strong> <span id="statusLokasi" class="badge"></span></p>
                            <p><strong>Koordinat:</strong> <span id="koordinat"></span></p>
                            <p><strong>Jarak dari Kantor:</strong> <span id="jarakKantor"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
    <script>
    // Koordinat kantor (sesuaikan dengan lokasi kantor Anda)
    const KANTOR_LAT =  -7.390791262452981;
    const KANTOR_LNG = 112.51373316319541;
    const RADIUS_KANTOR = 100; // Radius dalam meter
    
    let map = null;
    let markerKantor = null;
    let markerKaryawan = null;
    let circleRadius = null;

    $(document).ready(function() {
        $('.tampilkanpeta').on('click', function() {
            const lat = $(this).data('lat');
            const lng = $(this).data('lng');
            const nama = $(this).data('nama');
            
            // Update informasi teks
            $('#namaKaryawan').text(nama);
            $('#koordinat').text(lat + ', ' + lng);
            
            // Hitung jarak dan status text
            const jarak = hitungJarak(KANTOR_LAT, KANTOR_LNG, lat, lng);
            $('#jarakKantor').text(jarak.toFixed(2) + ' meter');
            
            const statusBadge = $('#statusLokasi');
            if (jarak <= RADIUS_KANTOR) {
                statusBadge.removeClass('bg-danger').addClass('bg-success text-white').text('Dalam Radius Kantor');
            } else {
                statusBadge.removeClass('bg-success').addClass('bg-danger text-white').text('Luar Radius Kantor');
            }
            
            // --- PERBAIKAN UTAMA DISINI ---
            // Kita beri jeda sedikit (500ms) agar Modal muncul dulu, baru peta digambar.
            // Atau lebih baik menggunakan event 'shown.bs.modal' jika memungkinkan, 
            // tapi setTimeout adalah cara termudah tanpa mengubah struktur HTML.
            setTimeout(function() {
                if (!map) {
                    initMap();
                }
                
                // PENTING: Perintah ini memaksa Leaflet mengecek ulang ukuran div
                // Ini yang memperbaiki masalah peta "abu-abu" atau zoom world view
                map.invalidateSize();
                
                updateMap(lat, lng);
            }, 300); 
        });
    });

    function initMap() {
        // Inisialisasi peta
        map = L.map('mapContainer').setView([KANTOR_LAT, KANTOR_LNG], 18); // Zoom awal diperbesar
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);
        
        // Marker kantor
        markerKantor = L.marker([KANTOR_LAT, KANTOR_LNG], {
             icon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            })
        }).addTo(map).bindPopup('Lokasi Kantor');
        
        // Circle radius kantor
        circleRadius = L.circle([KANTOR_LAT, KANTOR_LNG], {
            color: 'blue',
            fillColor: '#3388ff',
            fillOpacity: 0.2,
            radius: RADIUS_KANTOR
        }).addTo(map);
    }

    function updateMap(lat, lng) {
        // Hapus marker karyawan lama jika ada
        if (markerKaryawan) {
            map.removeLayer(markerKaryawan);
        }
        
        const jarak = hitungJarak(KANTOR_LAT, KANTOR_LNG, lat, lng);
        const iconColor = jarak <= RADIUS_KANTOR ? 'green' : 'red';
        
        markerKaryawan = L.marker([lat, lng], {
            icon: L.icon({
                iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-${iconColor}.png`,
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            })
        }).addTo(map).bindPopup(`Lokasi Karyawan (${jarak.toFixed(2)}m)`);
        
        // --- PERBAIKAN ZOOM (FIT BOUNDS) ---
        // Buat bounds (batas area) yang mencakup Lingkaran Radius DAN Marker Karyawan
        // Ini akan memastikan lingkaran terlihat penuh di layar
        
        const bounds = circleRadius.getBounds(); // Ambil batas lingkaran kantor
        bounds.extend([lat, lng]); // Perluas batas agar mencakup posisi karyawan juga
        
        // Fit peta ke batas tersebut dengan sedikit padding agar tidak mepet pinggir
        map.fitBounds(bounds, {
            padding: [50, 50], // Jarak dari pinggir frame (pixel)
            maxZoom: 18,       // Agar tidak terlalu zoom in jika jaraknya sangat dekat
            animate: true
        });
    }

    // Rumus Haversine (tetap sama)
    function hitungJarak(lat1, lng1, lat2, lng2) {
        const R = 6371000; 
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLng/2) * Math.sin(dLng/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }
</script>
@endif