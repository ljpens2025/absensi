<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = date('Y-m-d');
        $nik = Auth::guard('karyawan')->user()->nik;
        $bulanini = date('m') * 1;
        $tahunini = date('Y');
        $leaderboard = DB::table('presensi')
            ->where('tgl_presensi', $hariini)
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->orderBy('jam_in')
            ->get();
        $namabulan=["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $presensihariini = DB::table('presensi')->where('nik', $nik)->where('tgl_presensi', $hariini)->first();
        $historibulanini = DB::table('presensi')->whereRaw('MONTH(tgl_presensi)="'.$bulanini.'"')->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')->where('nik', $nik)->orderBy('tgl_presensi')->get();
        $rekappresensi = DB::table('presensi')
            ->selectRaw('COUNT(nik) as jumlah_hadir, SUM(IF(jam_in > "07.00",1,0)) as jumlah_terlambat')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="'.$bulanini.'"')
            ->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')
            ->first();
        $rekapizin = DB::table('pengajuan izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin, 
            SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tanggal_izin)="'.$bulanini.'"')
            ->whereRaw('YEAR(tanggal_izin)="'.$tahunini.'"')
            ->where('status_approved',1)
            ->first();
        return view('dashboard.dashboard', compact('presensihariini', 'namabulan', 'bulanini', 'tahunini', 'historibulanini', 'rekappresensi', 'leaderboard', 'rekapizin'));
    }

     public function dashboardadmin() {
         $hariini = date('Y-m-d');
         $rekappresensi = DB::table('presensi')
            ->selectRaw('COUNT(nik) as jumlah_hadir, SUM(IF(jam_in > "07.00",1,0)) as jumlah_terlambat')
            ->where('tgl_presensi', $hariini)
            ->first();
         $rekapizin = DB::table('pengajuan izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin, SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('tanggal_izin', $hariini)
            ->where('status_approved',1)
            ->first();
        return view('dashboard.dashboardadmin', compact('rekappresensi', 'rekapizin'));
     }
}
