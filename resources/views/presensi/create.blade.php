@extends('layout.presensi')
@section('header')
 <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection
<style>
    .webcam-capture, .webcam-capture video{
        display: inline-block;
        width: 100% !important;
        height: auto !important;
        margin: auto;
        border-radius: 8px;
    }
    #map { height: 200px; }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@section('content')
<div class="row" style="margin-top: 70px;">
    <div class="col">
        <input type="hidden" id="lokasi">
        <div class="webcam-capture"></div>
    </div>
</div>
<div class="row">
    <div class="col mt-2">
        @if ($cek > 0)
            <button id="takeabsen" class="btn btn-danger btn-block">
                <ion-icon name="camera-outline"></ion-icon> Absen Pulang</button>
        @else
            <button id="takeabsen" class="btn btn-primary btn-block">
                <ion-icon name="camera-outline"></ion-icon> Absen Masuk</button>
        @endif
    </div>
</div>
<div class="row mt-2">
    <div class="col">
        <div id="map"></div>
    </div>
</div>

@endsection

@push('myscript')
<script>
    Webcam.set({
        width: 480,
        height: 640,
        image_format: 'jpeg',
        jpeg_quality: 80
    });
    Webcam.attach('.webcam-capture');
    var lokasi = document.getElementById('lokasi');
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(successcallback, errorCallback)
         function successcallback(position){
            lokasi.value = "Latitude: " + position.coords.latitude + 
            " Longitude: " + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 17);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            var circle = L.circle([-7.39061711768866, 112.51368997909691], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 50
            }).addTo(map);
        }
        function errorCallback(error){
            lokasi.value = "Error getting location: " + error.message;
        }
    } else {
        lokasi.value = "Geolocation is not supported by this browser.";
    }
    $('#takeabsen').click(function(e){
        Webcam.snap( function(uri) 
        {
            image = uri;
        });
        var lokasi = $('#lokasi').val();
        
        $.ajax({
            type: 'POST',
            url: '/presensi/store',
            data: {
                _token: '{{ csrf_token() }}',
                image: image,
                lokasi: lokasi
            },
            cache: false,
            success: function(respond){
                var status = respond.split("|");
                if(status[0] == "Success"){
                    Swal.fire({
                        title: 'Berhasil Absen',
                        text: status[1],
                        icon: status[0].toLowerCase(),
                        confirmButtonText: 'OK'
                    })
                    setTimeout(function(){ 
                        window.location.href = '/dashboard';
                    }, 2000);
                } else {
                    Swal.fire({
                        title: 'Gagal Absen',
                        text: status[1],
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                    setTimeout(function(){ 
                        window.location.href = '/presensi/create';
                    }, 2000);
                }
            }
        });
    });
</script>
@endpush
