<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Penduduk;
use App\Models\Pengajuan;
use App\Models\Surat;
use App\Models\User;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get statistics
        $totalUsers = User::count();
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
        $recentUsers = User::orderBy('created_at', 'desc')->take(3)->get();
        $recentPengajuan = Pengajuan::with(['penduduk', 'layanan'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        $recentSurat = Surat::orderBy('created_at', 'desc')->take(3)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPenduduk',
            'totalPengajuan',
            'totalLayanan',
            'totalSurat',
            'pengajuanMenunggu',
            'pengajuanDiproses',
            'pengajuanSelesai',
            'pengajuanDitolak',
            'recentUsers',
            'recentPengajuan',
            'recentSurat'
        ));
    }
}
