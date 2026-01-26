<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Departemen;
use Illuminate\Support\Facades\Redirect;

class DepartemenController extends Controller
{
   public function index(Request $request)
{
    // 1. Inisialisasi Query untuk Tabel (Pencarian)
    $query = Departemen::query();
    
    // Tidak perlu select('departemen.*') jika tidak ada join, tapi tidak masalah jika dibiarkan.
    $query->select('*'); 

    // 2. Logic Pencarian Nama
    if (!empty($request->nama_departemen)) {
        $query->where('nama_dept', 'like', '%' . $request->nama_departemen . '%');
    }

    // 3. Logic Filter Kode Dept
    if (!empty($request->kode_dept)) {
        $query->where('kode_dept', $request->kode_dept);
    }

    // 4. Eksekusi Query untuk Tabel (Gunakan variabel $departemen)
    $departemen = $query->paginate(5);
    
    // PENTING: Agar pencarian tidak hilang saat ganti halaman pagination
    $departemen->appends($request->all()); 

    // 5. Ambil data untuk DROPDOWN (Gunakan variabel BARU, misal $list_dept)
    // Kita ambil semua data untuk mengisi opsi select
    $list_dept = DB::table('departemen')->get();

    // 6. Kirim kedua variabel ke View
    return view('departemen.departemen', compact('departemen', 'list_dept'));
}
    public function store(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $nama_dept = $request->nama_dept;
        try {
            // Simpan data
            $data = [
                'kode_dept' => $kode_dept,
                'nama_dept' => $nama_dept
            ];

            DB::table('departemen')->insert($data);
            return redirect()->back()->with('success', 'Departemen berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Tips: Jika NIK Duplicate, error akan tertangkap disini
            if($e->getCode() == 23000) { // Code SQL Integrity Constraint Violation
                return redirect()->back()->with('error', 'Data Gagal Disimpan: Kode Departemen Sudah Terdaftar!');
            }
            return redirect()->back()->with('error', 'Gagal menambahkan departemen: ' . $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $departemen = DB::table('departemen')->where('kode_dept', $kode_dept)->first();
        // Kembalikan dalam bentuk JSON agar mudah diolah Javascript
        return response()->json($departemen);
    }

    public function update(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $nama_dept = $request->nama_dept;

        try {
            $departemen = DB::table('departemen')->where('kode_dept', $kode_dept)->first();
            // Siapkan data update
            $data = [
                'nama_dept' => $nama_dept,
                'kode_dept' => $kode_dept,
            ];

            // Lakukan Update ke Database
            $update = DB::table('departemen')->where('kode_dept', $kode_dept)->update($data);
            if ($update) {
                return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
            }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Diupdate']);
        }

        return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
    }
    public function delete($kode_dept)
    {
        try {
            // Lakukan penghapusan
            $hapus = DB::table('departemen')->where('kode_dept', $kode_dept)->delete();

            // Cek apakah ada baris yang terhapus
            if ($hapus) {
                return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
            } else {
                // Jika kode_dept tidak ditemukan di database
                return Redirect::back()->with(['error' => 'Data Tidak Ditemukan']); 
            }

        } catch (\Exception $e) {
            // Tangkap error database (misal: constraint violation / foreign key error)
            return Redirect::back()->with(['error' => 'Data Gagal Dihapus! Data mungkin sedang digunakan di tabel lain.']);
        }

    }
}