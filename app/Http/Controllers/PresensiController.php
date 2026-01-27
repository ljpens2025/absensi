<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class PresensiController extends Controller
{
    public function create (){
        $hariini = date('Y-m-d');
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nik', $nik)->count();
        return view('presensi.create', compact('cek'));
    }
    public function store(Request $request){
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');
        $lokasi = $request->lokasi;
        $clean_lokasi = str_replace(['Latitude: ', 'Longitude: '], '', $lokasi);
        $latitudekantor = -7.39061711768866;
        $longitudekantor = 112.51368997909691;
        $lokasiuser = explode(' ', $clean_lokasi); // Pecah berdasarkan spasi
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];
        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak['meters']);
        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();
        if($cek > 0) {
            $ket = "out";
        }else {
            $ket = "in";
        }
        $image = $request->image;  
        $folderPath ="uploads/presensi/";
        $formatName = $nik . "_" . $tgl_presensi . "-" . $ket;
        $image_parts = explode(";base64,", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . '.png';
        $file = $folderPath . $fileName;
        $data = [
            'nik' => $nik,
            'tgl_presensi' => $tgl_presensi,
            'jam_in' => $jam,
            'foto_in' => $fileName,
            'location_in' => $lokasi,
        ];
        
        if($radius > 50) {
            echo "error|Anda berada diluar jangkauan presensi kantor (10 meter). Jarak Anda saat ini " . $radius . " meter.|";    
        } else {
        if($cek > 0) {
            //update presensi pulang
            $data_pulang = [
                'jam_out' => $jam,
                'foto_out' => $fileName,
                'location_out' => $lokasi,
            ];
            $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
            if($update) {
                echo "Success|Terima kasih, Hati-hati di jalan pulang.|out";
                Storage::disk('public')->put($folderPath . $fileName, $image_base64);
            }else {
                echo "error|Gagal melakukan presensi pulang, Hubungi Admin|out";
            }
        } else{
            $simpan = DB::table('presensi')->insert($data);
            if($simpan) {
                echo "Success|Presensi Berhasil, Selamat Bekerja!|in";
                Storage::disk('public')->put($folderPath . $fileName, $image_base64);
            }else {
                echo "error|Gagal melakukan presensi, Hubungi Admin|in";
            }
        }      
    }
    
    } 

     //Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }
    public function editprofile(){
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('presensi.editprofile', compact('karyawan'));
    }    

    public function updateprofile(Request $request){
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        if($request->hasFile('foto')){
            $foto = $nik.".".$request->file('foto')->getClientOriginalExtension();
        }else {
            $foto = $karyawan->foto;
        }
        if($request->password == "" || empty($request->password)){
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto
            ];
        }else {
        $data = [
            'nama_lengkap' => $nama_lengkap,
            'no_hp' => $no_hp,
            'foto' => $foto,
            'password' => $password
        ];
        } 
        $update = DB::table('karyawan')->where('nik', $nik)->update($data);
        if($update){
                if($request->hasFile('foto')){
                    $folderPath ="uploads/karyawan/";
                    $request->file('foto')->storeAs($folderPath, $foto, 'public');
                }
            return Redirect::back()->with(['success' => 'Profile Berhasil di Update']);
        }else {
            return Redirect::back()->with(['error' => 'Gagal Update Profile']);
        }
    }

    public function histori(){
        $namabulaan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        return view('presensi.histori', compact('namabulaan'));
    }

    public function gethistori(Request $request){
        $nik = Auth::guard('karyawan')->user()->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $histori = DB::table('presensi')
                    ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
                    ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
                    ->whereYear('tgl_presensi', $tahun)
                    ->where('nik', $nik)
                    ->orderBy('tgl_presensi', 'ASC')
                    ->get();
        return view('presensi.gethistori', compact('histori'));
    }
    
    public function izin(){
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = DB::table('pengajuan izin')
                    ->where('nik', $nik)
                    ->get();
        return view('presensi.izin', compact('dataizin'));
    }
    public function buatizin(){
        return view('presensi.buatizin');
    }
    public function storeizin(Request $request){
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin = $request->tgl_izin;
        $jenis_izin = $request->jenis_izin;
        $keterangan = $request->keterangan;
        $data = [
            'nik' => $nik,
            'tanggal_izin' => $tgl_izin,
            'status' => $jenis_izin,
            'keterangan' => $keterangan
        ];
        $simpan = DB::table('pengajuan izin')->insert($data);
        if($simpan){
            return Redirect('/izin')->with(['success' => 'Izin/Sakit Berhasil diajukan']);
        }else {
            return Redirect('/izin')->with(['error' => 'Gagal mengajukan Izin/Sakit']);
        }
    }
    public function monitoring(){
        return view('presensi.monitoring');
    }

   public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;

        // Ambil data presensi join dengan karyawan
        $presensi = DB::table('presensi')
            ->select('presensi.*', 'nama_lengkap', 'kode_dept')
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->where('tgl_presensi', $tanggal)
            ->get();

        // Return view (Laravel otomatis merender ini menjadi string HTML untuk AJAX)
        // Pastikan path 'presensi.getpresensi' sesuai dengan folder view Anda
        return view('presensi.getpresensi', compact('presensi'));
    }
    
}


