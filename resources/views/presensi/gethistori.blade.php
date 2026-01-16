@if($histori->isEmpty())
<div class="alert alert-warning alert-outline mt-2">
    <p>Tidak ada data presensi</p>
</div>
@endif
@foreach($histori as $d)
<ul class="listview image-listview" style="margin-top: 10px;">
    <li>
        <div class="item">
            @php
            $path = Storage::url('uploads/presensi/'.$d->foto_in);
            @endphp
            <img src="{{ $path }}" alt="image" class="image">
            <div class="in">
            <div>
            <b>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</b><br>
            </div>
            <span class="badge {{$d->jam_in > '07:00' ? 'badge-danger' : 'badge-success'}}">{{ $d->jam_in }}</span>
            </div>
            <span class="badge badge-primary">{{ $d->jam_out }}</span>
        </div>                      
    </li>
 
</ul>
@endforeach