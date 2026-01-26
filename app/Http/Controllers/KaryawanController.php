<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();
        $query->select('karyawan.*','nama_dept');
        $query->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept');
        $query->orderBy('karyawan.nama_lengkap');
        $departemen = DB::table('departemen')->get();
        if(!empty($request->nama_karyawan)){
            $query->where('karyawan.nama_lengkap', 'like', '%'.$request->nama_karyawan.'%');
        }
         if(!empty($request->kode_dept)){
            $query->where('karyawan.kode_dept', $request->kode_dept);
        }
        $karyawan = $query->paginate(5);
        return view('karyawan.index', compact('karyawan', 'departemen'));
    }
    public function store(Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $kode_dept = $request->kode_dept;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $password = $request->password;
        $foto = null; // Default null jika tidak ada foto
        if($request->hasFile('foto')){
            $foto = $nik.".".$request->file('foto')->getClientOriginalExtension();
        }

        try {
            // Simpan data
            $data = [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'kode_dept' => $kode_dept,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'foto' => $foto, // Bisa null atau nama file
                'password' => bcrypt($password)
            ];
            
            DB::table('karyawan')->insert($data);

            // Simpan file fisik hanya jika insert DB berhasil & ada file
            if($request->hasFile('foto')){
                $folderPath = "uploads/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto, 'public');
            }

            return redirect()->back()->with('success', 'Karyawan berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Tips: Jika NIK Duplicate, error akan tertangkap disini
            if($e->getCode() == 23000) { // Code SQL Integrity Constraint Violation
                return redirect()->back()->with('error', 'Data Gagal Disimpan: NIK Sudah Terdaftar!');
            }
            return redirect()->back()->with('error', 'Gagal menambahkan karyawan: ' . $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $nik = $request->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        // Kembalikan dalam bentuk JSON agar mudah diolah Javascript
        return response()->json($karyawan);
    }

    public function update(Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $kode_dept = $request->kode_dept;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $password = $request->password;
        $old_foto = $request->old_foto;

        try {
            $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
            
            // Cek apakah ada upload foto baru
            if ($request->hasFile('foto')) {
                $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
            } else {
                $foto = $old_foto; // Jika tidak ganti foto, pakai yang lama
            }

            // Siapkan data update
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'kode_dept'    => $kode_dept,
                'jabatan'      => $jabatan,
                'no_hp'        => $no_hp,
                'foto'         => $foto,
            ];

            // Update password hanya jika diisi
            if (!empty($password)) {
                $data['password'] = Hash::make($password);
            }

            // Lakukan Update ke Database
            $update = DB::table('karyawan')->where('nik', $nik)->update($data);

            if ($update) {
                // Jika ada foto baru, simpan file dan hapus yang lama
                if ($request->hasFile('foto')) {
                    $folderPath = "uploads/karyawan/";
                    $folderPathOld = "uploads/karyawan/" . $old_foto;
                    // Hapus foto lama jika ada
                    Storage::delete($folderPathOld);
                    // Simpan foto baru
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
            }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Diupdate']);
        }

        return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
    }
    public function delete($nik)
    {
        // 1. Ambil data karyawan dulu untuk mengecek nama foto
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();

        if ($karyawan) {
            try {
                // 2. Hapus data di database
                DB::table('karyawan')->where('nik', $nik)->delete();

                // 3. Hapus file foto fisik jika ada
                if ($karyawan->foto != null) {
                    $folderPath = "uploads/karyawan/" . $karyawan->foto;
                    Storage::delete($folderPath);
                }

                return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
            } catch (\Exception $e) {
                return Redirect::back()->with(['error' => 'Data Gagal Dihapus']);
            }
        }
        
        return Redirect::back()->with(['error' => 'Data Tidak Ditemukan']);
    }
}