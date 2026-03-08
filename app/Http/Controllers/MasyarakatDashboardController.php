<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class MasyarakatDashboardController extends Controller
{
    /**
     * Display the masyarakat dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        $penduduk = $user->penduduk;

        // Get pengajuan statistics for this user
        $totalPengajuan = Pengajuan::where('penduduk_id', $penduduk->id)->count();
        $pengajuanMenunggu = Pengajuan::where('penduduk_id', $penduduk->id)->where('status', 'menunggu')->count();
        $pengajuanDiproses = Pengajuan::where('penduduk_id', $penduduk->id)->where('status', 'diproses')->count();
        $pengajuanSelesai = Pengajuan::where('penduduk_id', $penduduk->id)->where('status', 'selesai')->count();
        $pengajuanDitolak = Pengajuan::where('penduduk_id', $penduduk->id)->where('status', 'ditolak')->count();

        // Get recent pengajuan for this user
        $recentPengajuan = Pengajuan::with(['layanan', 'statusHistories'])
            ->where('penduduk_id', $penduduk->id)
            ->latest()
            ->take(5)
            ->get();

        return view('masyarakat.dashboard', compact(
            'penduduk',
            'totalPengajuan',
            'pengajuanMenunggu',
            'pengajuanDiproses',
            'pengajuanSelesai',
            'pengajuanDitolak',
            'recentPengajuan'
        ));
    }
}