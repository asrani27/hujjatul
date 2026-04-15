<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Penduduk;
use App\Models\Pengajuan;
use App\Models\Surat;
use App\Models\User;

class KepalaDesaDashboardController extends Controller
{
    /**
     * Display the kepala desa dashboard.
     */
    public function index()
    {
        // Get statistics
        $totalPenduduk = Penduduk::count();
        $totalPengajuan = Pengajuan::count();
        $totalLayanan = Layanan::count();
        $totalSurat = Surat::count();
        
        // Pengajuan statistics by status
        $pengajuanMenunggu = Pengajuan::where('status', 'menunggu')->count();
        $pengajuanDiproses = Pengajuan::where('status', 'diproses')->count();
        $pengajuanSelesai = Pengajuan::where('status', 'selesai')->count();
        $pengajuanDitolak = Pengajuan::where('status', 'ditolak')->count();
        
        // Get recent activities
        $recentPengajuan = Pengajuan::with(['penduduk', 'layanan'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $recentSurat = Surat::orderBy('created_at', 'desc')->take(5)->get();

        return view('kepala-desa.dashboard', compact(
            'totalPenduduk',
            'totalPengajuan',
            'totalLayanan',
            'totalSurat',
            'pengajuanMenunggu',
            'pengajuanDiproses',
            'pengajuanSelesai',
            'pengajuanDitolak',
            'recentPengajuan',
            'recentSurat'
        ));
    }
}
