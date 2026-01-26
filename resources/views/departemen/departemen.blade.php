@extends('layout.admin.tabler')
@section('content')
<div class="page-header d-print-none" aria-label="Page header">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Departemen</div>
                <h2 class="page-title">Data Departemen</h2>
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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahdata">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>Tambah Data
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2">
                           <form action="/dashboardadmin/departemen" method="GET" class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="nama_departemen" 
                                                value="{{ Request('nama_departemen') }}" 
                                                placeholder="Cari Departemen">
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <select name="kode_dept" id="kode_dept" class="form-select">
                                                <option value="">-- Pilih Departemen --</option>
                                                
                                                @foreach($list_dept as $d)
                                                    <option value="{{ $d->kode_dept }}" 
                                                        {{ Request('kode_dept') == $d->kode_dept ? 'selected' : '' }}>
                                                        {{ $d->nama_dept }}
                                                    </option>
                                                @endforeach
                                                
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary w-100">
                                                Cari
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <div class="row mt-2">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <th>No</th>
                                        <th>Kode Departemen</th>
                                        <th>Nama Departemen</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody>
                                        @foreach($departemen as $d )
                                            <tr>
                                                <td>{{ $loop->iteration + $departemen->firstItem() - 1 }}</td>
                                                <td>{{ $d->kode_dept }}</td>
                                                <td>{{ $d->nama_dept }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-primary edit" kode_dept="{{ $d->kode_dept }}" data-bs-toggle="modal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-pencil"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>Edit Data</a>
                                                    <form action="/departemen/delete/{{ $d->kode_dept }}" method="POST" style="display:inline-block;">
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
                                        <li class="page-item"><a class="page-link" href="{{ $departemen->previousPageUrl() }}">Previous</a></li>
                                        @foreach ($departemen->links()->elements[0] as $page => $url)
                                        <li class="page-item {{ $departemen->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                        @endforeach
                                        <li class="page-item"><a class="page-link" href="{{ $departemen->nextPageUrl() }}">Next</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
<!-- modal tambah departemen -->
</div>
<div class="modal" id="tambahdata" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Departemen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/departemen/store" method="POST" id="tambahdepartemen">
            @csrf
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-qrcode" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="6" height="6" rx="1" /><line x1="7" y1="17" x2="7" y2="17.01" /><rect x="14" y="4" width="6" height="6" rx="1" /><line x1="7" y1="7" x2="7" y2="7.01" /><rect x="4" y="14" width="6" height="6" rx="1" /><line x1="14" y1="14" x2="17" y2="14" /><line x1="14" y1="20" x2="17" y2="20" /><line x1="14" y1="17" x2="14" y2="20" /><line x1="17" y1="17" x2="20" y2="17" /><line x1="20" y1="17" x2="20" y2="20" /></svg>
                        </span>
                        <input type="text" id="kode_departemen" name="kode_dept" class="form-control" placeholder="Kode Departemen">
                    </div>
                    
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                             <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                        </span>
                        <input type="text" id="nama_dept" name="nama_dept" class="form-control" placeholder="Nama Departemen">
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- modal edit departemen -->
<div class="modal modal-blur fade" id="modal-editdepartemen" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Data Departemen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/departemen/update" method="POST" id="form-editdepartemen">
            @csrf
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-qrcode" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="6" height="6" rx="1" /><line x1="7" y1="17" x2="7" y2="17.01" /><rect x="14" y="4" width="6" height="6" rx="1" /><line x1="7" y1="7" x2="7" y2="7.01" /><rect x="4" y="14" width="6" height="6" rx="1" /><line x1="14" y1="14" x2="17" y2="14" /><line x1="14" y1="20" x2="17" y2="20" /><line x1="14" y1="17" x2="14" y2="20" /><line x1="17" y1="17" x2="20" y2="17" /><line x1="20" y1="17" x2="20" y2="20" /></svg>
                </span>
                <input type="text" readonly id="kode_departemen_edit" name="kode_dept" class="form-control" placeholder="Kode Departemen">
            </div>
            
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                     <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                </span>
                <input type="text" id="nama_dept_edit" name="nama_dept" class="form-control" placeholder="Nama Departemen">
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@push('myscript')
<script>
    $(document).ready(function () {
     $('#tambahdepartemen').submit(function(e){
                var kode_dept = $('#kode_departemen').val();
                var nama_dept = $('#nama_dept').val();
               
                if(kode_dept == ''){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Kode Departemen tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        // Beri jeda 500ms (setengah detik) agar alert hilang dulu
                        setTimeout(function() {
                            $('#kode_departemen').focus();
                        }, 500); 
                });
                    return false;
                } else if(nama_dept == ''){
                        Swal.fire({
                        title: 'Error!',
                        text: 'Nama Departemen tidak boleh kosong',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                        }).then((result) => {
                        // Beri jeda 500ms (setengah detik) agar alert hilang dulu
                            setTimeout(function() {
                            $('#nama_dept').focus();
                        }, 500); 
                        });
                    return false;
                }
            });
     });
    $('.edit').click(function(){
        // Mengambil data kode dari atribut tombol edit
        // Pastikan di tombol edit tabel atributnya adalah 'kode_dept'
        // Contoh: <a href="#" class="edit" kode_dept="{{ $d->kode_dept }}">
        var kode_dept = $(this).attr('kode_dept'); 

        $.ajax({
            type: 'POST',
            url: '/departemen/edit',
            cache: false,
            data: {
                _token: "{{ csrf_token() }}",
                kode_dept: kode_dept // Sesuaikan nama key dengan request di Controller
            },
            success: function(respond){
                // Isi value ke dalam input form modal
                $('#kode_departemen_edit').val(respond.kode_dept);
                $('#nama_dept_edit').val(respond.nama_dept);

                // Tampilkan modal setelah data berhasil diambil
                $('#modal-editdepartemen').modal('show');
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
    
</script>
@endpush