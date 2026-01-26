@extends('layout.admin.tabler')
@section('content')
<div class="page-header d-print-none" aria-label="Page header">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Karyawan</div>
                <h2 class="page-title">Data Karyawan</h2>
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
                                @php
                                    if(session('success')){
                                        echo '<div class="alert alert-success">'.session('success').'</div>';
                                    } elseif(session('error')){
                                        echo '<div class="alert alert-danger">'.session('error').'</div>';
                                    }
                                @endphp
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>Tambah Data
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2">
                           <div class="col-12">
                                <form action="/dashboardadmin/karyawan" method="GET" class="mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="nama_karyawan" placeholder="Cari Karyawan...">
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <select name="kode_dept" id="kode_dept" class="form-select">
                                                    <option value="">-- Pilih Departemen --</option>
                                                    @foreach($departemen as $d)
                                                    <option value="{{ $d->kode_dept }}">{{ $d->nama_dept }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                        <path d="M21 21l-6 -6" />
                                                    </svg>
                                                    Cari
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama Karyawan</th>
                                        <th>Jabatan</th>
                                        <th>No Telepon</th>
                                        <th>Foto</th>
                                        <th>Departemen</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody>
                                        @foreach($karyawan as $k )
                                            <tr>
                                                <td>{{ $loop->iteration + $karyawan->firstItem() - 1 }}</td>
                                                <td>{{ $k->nik }}</td>
                                                <td>{{ $k->nama_lengkap }}</td>
                                                <td>{{ $k->jabatan }}</td>
                                                <td>{{ $k->no_hp }}</td>
                                                <td>
                                                    <img src="{{ Storage::url('uploads/karyawan/'.$k->foto) }}" alt="Foto Karyawan" class="avatar" >
                                                </td>
                                                <td>{{ $k->nama_dept }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-primary edit" nik="{{ $k->nik }}" data-bs-toggle="modal" data-bs-target="#updatedata"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-pencil"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>Edit Data</a>
                                                    <form action="/karyawan/delete/{{ $k->nik }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        <a class="btn btn-sm btn-danger delete-confirm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                            Hapus
                                                        </a>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item"><a class="page-link" href="{{ $karyawan->previousPageUrl() }}">Previous</a></li>
                                        @foreach ($karyawan->links()->elements[0] as $page => $url)
                                        <li class="page-item {{ $karyawan->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                        @endforeach
                                        <li class="page-item"><a class="page-link" href="{{ $karyawan->nextPageUrl() }}">Next</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- modal update karyawan -->
<div class="modal" id="updatedata" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Updata Data Karyawan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/karyawan/update" method="POST" enctype="multipart/form-data" id="formeditkaryawan">
            @csrf
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-qrcode" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="6" height="6" rx="1" /><line x1="7" y1="17" x2="7" y2="17.01" /><rect x="14" y="4" width="6" height="6" rx="1" /><line x1="7" y1="7" x2="7" y2="7.01" /><rect x="4" y="14" width="6" height="6" rx="1" /><line x1="14" y1="14" x2="17" y2="14" /><line x1="14" y1="20" x2="17" y2="20" /><line x1="14" y1="17" x2="14" y2="20" /><line x1="17" y1="17" x2="20" y2="17" /><line x1="20" y1="17" x2="20" y2="20" /></svg>
                        </span>
                        <input type="text" readonly value="" id="nik_edit" name="nik" class="form-control" placeholder="NIK">
                    </div>
                    
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                             <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                        </span>
                        <input type="text" id="nama_lengkap_edit" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap">
                    </div>

                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-briefcase" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="7" width="18" height="13" rx="2" /><path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" /><line x1="12" y1="12" x2="12" y2="12.01" /><path d="M3 13a20 20 0 0 0 18 0" /></svg>
                        </span>
                        <input type="text" id="jabatan_edit" name="jabatan" class="form-control" placeholder="Jabatan">
                    </div>

                    <div class="input-icon mb-3">
                         <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>
                        </span>
                        <input type="text" id="no_hp_edit" name="no_hp" class="form-control" placeholder="No HP">
                    </div>

                    <div class="input-icon mb-3">
                         <span class="input-icon-addon">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-key"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14.52 2c1.029 0 2.015 .409 2.742 1.136l3.602 3.602a3.877 3.877 0 0 1 0 5.483l-2.643 2.643a3.88 3.88 0 0 1 -4.941 .452l-.105 -.078l-5.882 5.883a3 3 0 0 1 -1.68 .843l-.22 .027l-.221 .009h-1.172c-1.014 0 -1.867 -.759 -1.991 -1.823l-.009 -.177v-1.172c0 -.704 .248 -1.386 .73 -1.96l.149 -.161l.414 -.414a1 1 0 0 1 .707 -.293h1v-1a1 1 0 0 1 .883 -.993l.117 -.007h1v-1a1 1 0 0 1 .206 -.608l.087 -.1l1.468 -1.469l-.076 -.103a3.9 3.9 0 0 1 -.678 -1.963l-.007 -.236c0 -1.029 .409 -2.015 1.136 -2.742l2.643 -2.643a3.88 3.88 0 0 1 2.741 -1.136m.495 5h-.02a2 2 0 1 0 0 4h.02a2 2 0 1 0 0 -4" /></svg>  
                        </span>
                        <input type="password" name="password" class="form-control" placeholder="Password (Kosongkan jika tidak diganti)">
                    </div>

                     <input type="hidden" name="old_foto" id="old_foto">

                    <div class="mb-3">
                         <label class="form-label">Foto Karyawan</label>
                        <input type="file" name="foto" class="form-control">
                        <small class="text-secondary" id="text_foto_lama"></small>
                    </div>

                    <div class="mb-3">
                        <select name="kode_dept" id="kode_dept_edit" class="form-select">
                            <option value="">Pilih Departemen</option>
                            @foreach($departemen as $d)
                            <option value="{{ $d->kode_dept }}">{{ $d->nama_dept }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>
<!-- modal input karyawan -->
<div class="modal" id="exampleModal" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Karyawan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/karyawan/store" method="post" id="formkaryawan" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-qrcode"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1l0 -4" /><path d="M7 17l0 .01" /><path d="M14 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1l0 -4" /><path d="M7 7l0 .01" /><path d="M4 15a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1l0 -4" /><path d="M17 7l0 .01" /><path d="M14 14l3 0" /><path d="M20 14l0 .01" /><path d="M14 14l0 3" /><path d="M14 20l3 0" /><path d="M17 17l3 0" /><path d="M20 17l0 3" /></svg>
                        </span>
                        <input type="text" id="nik" name="nik" class="form-control" placeholder="NIK" />
                    </div>
                    
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                        </span>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Nama Karyawan" />
                    </div>

                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-briefcase"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2l0 -9" /><path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" /><path d="M12 12l0 .01" /><path d="M3 13a20 20 0 0 0 18 0" /></svg>
                        </span>
                        <input type="text" id="jabatan" name="jabatan" class="form-control" placeholder="Jabatan" />
                    </div>

                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-landline-phone"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 3h-2a2 2 0 0 0 -2 2v14a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-14a2 2 0 0 0 -2 -2" /><path d="M16 4h-11a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3h11" /><path d="M12 8h-6v3h6l0 -3" /><path d="M12 14v.01" /><path d="M9 14v.01" /><path d="M6 14v.01" /><path d="M12 17v.01" /><path d="M9 17v.01" /><path d="M6 17v.01" /></svg>
                        </span>
                        <input type="text" id="no_hp" name="no_hp" class="form-control" placeholder="No HP" />
                    </div>
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-key"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14.52 2c1.029 0 2.015 .409 2.742 1.136l3.602 3.602a3.877 3.877 0 0 1 0 5.483l-2.643 2.643a3.88 3.88 0 0 1 -4.941 .452l-.105 -.078l-5.882 5.883a3 3 0 0 1 -1.68 .843l-.22 .027l-.221 .009h-1.172c-1.014 0 -1.867 -.759 -1.991 -1.823l-.009 -.177v-1.172c0 -.704 .248 -1.386 .73 -1.96l.149 -.161l.414 -.414a1 1 0 0 1 .707 -.293h1v-1a1 1 0 0 1 .883 -.993l.117 -.007h1v-1a1 1 0 0 1 .206 -.608l.087 -.1l1.468 -1.469l-.076 -.103a3.9 3.9 0 0 1 -.678 -1.963l-.007 -.236c0 -1.029 .409 -2.015 1.136 -2.742l2.643 -2.643a3.88 3.88 0 0 1 2.741 -1.136m.495 5h-.02a2 2 0 1 0 0 4h.02a2 2 0 1 0 0 -4" /></svg>  
                        </span>
                        <input type="text" id="password" name="password" class="form-control" placeholder="Password" />
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <input type="file" class="form-control" name="foto">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <select name="kode_dept" id="kode_dept_create" class="form-select mt-2">
                                <option value="">Pilih Departemen</option>
                                @foreach($departemen as $d)
                                <option value="{{ $d->kode_dept }}">{{ $d->nama_dept }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="modal-footer mt-2">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-send"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14l11 -11" /><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" /></svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
  </div>
</div>
<!-- modal edit karyawan -->
 <!-- modal edit karyawan -->


@push('myscript')
<script>
$(document).ready(function () {
    // ===== SCRIPT UPDATE DATA (Tambahkan dibawah validasi form lama) =====
    $('.edit').click(function(){
        var nik = $(this).attr('nik');
        $.ajax({
            type: 'POST',
            url: '/karyawan/edit',
            cache: false,
            data: {
                _token: "{{ csrf_token() }}",
                nik: nik
            },
            success: function(respond){
                // Panggil Modal Edit (Bootstrap 5)
                // Pastikan jQuery mengenali ID modal yang baru (#updatedata)
                $('#updatedata').modal('show');

                // Isi data ke form menggunakan ID yang berakhiran _edit
                $('#nik_edit').val(respond.nik);
                $('#nama_lengkap_edit').val(respond.nama_lengkap);
                $('#jabatan_edit').val(respond.jabatan);
                $('#no_hp_edit').val(respond.no_hp);
                $('#kode_dept_edit').val(respond.kode_dept);
                
                // Isi hidden input foto lama agar controller tahu file apa yang harus dihapus jika diganti
                $('#old_foto').val(respond.foto);
                $('#text_foto_lama').text('Foto saat ini: ' + respond.foto);
            }
        });
    });
    // ===== KONFIRMASI HAPUS DATA =====
    $('.delete-confirm').click(function(e){
        var form = $(this).closest('form');
        e.preventDefault(); // Mencegah form submit langsung
        
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit form jika user klik Ya
            }
        })
    });
    // ===== VALIDASI FORM =====
    $('#formkaryawan').submit(function(e){
                var nik = $('#nik').val();
                var nama_lengkap = $('#nama_lengkap').val();
                var jabatan = $('#jabatan').val();
                var no_hp = $('#no_hp').val();
                var kode_dept = $('#kode_dept_create').val();
                var password = $('#password').val();
                if(nik == ''){
                    Swal.fire({
                        title: 'Error!',
                        text: 'NIK tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        // Beri jeda 500ms (setengah detik) agar alert hilang dulu
                        setTimeout(function() {
                            $('#nik').focus();
                        }, 500); 
                });
                    return false;
                } else if(nama_lengkap == ''){
                        Swal.fire({
                        title: 'Error!',
                        text: 'Nama lengkap tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                        }).then((result) => {
                        // Beri jeda 500ms (setengah detik) agar alert hilang dulu
                            setTimeout(function() {
                            $('#nama_lengkap').focus();
                        }, 500); 
                        });
                    return false;
                } else if(jabatan == ''){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Jabatan tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        // Beri jeda 500ms (setengah detik) agar alert hilang dulu
                        setTimeout(function() {
                            $('#jabatan').focus();
                        }, 500); 
                    });
                    return false;
                } else if(no_hp == ''){
                    Swal.fire({
                        title: 'Error!',
                        text: 'No HP tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        // Beri jeda 500ms (setengah detik) agar alert hilang dulu
                        setTimeout(function() {
                            $('#no_hp').focus();
                        }, 500); 
                    });
                    return false;

                } else if(password == ''){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Password tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        setTimeout(function() {
                            $('#password').focus();
                        }, 500); 
                    });
                } else if(kode_dept == ''){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Departemen harus dipilih',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        setTimeout(function() { $('#kode_dept_create').focus(); }, 500); 
                    });
                    return false;
                }
            });
    });

</script>
@endpush

@endsection
