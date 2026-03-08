<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\ProfilDesa;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.laporan.index');
    }

    /**
     * Generate PDF report for users
     */
    public function cetakUser(Request $request)
    {
        $query = User::query();

        // Filter by role if specified
        if ($request->has('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->get();
        $profilDesa = ProfilDesa::getProfil();

        $data = [
            'data' => $users,
            'profil' => $profilDesa
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf.user', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-user-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Generate PDF report for pengajuan
     */
    public function cetakPengajuan(Request $request)
    {
        $query = Pengajuan::with(['penduduk', 'layanan', 'statusHistories']);

        // Filter by status if specified
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date range if specified
        if ($request->has('tanggal_mulai') && $request->has('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $pengajuan = $query->orderBy('tanggal', 'desc')->get();
        $profilDesa = ProfilDesa::getProfil();

        $data = [
            'data' => $pengajuan,
            'profil' => $profilDesa
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf.pengajuan', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-pengajuan-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Generate PDF report for surat
     */
    public function cetakSurat(Request $request)
    {
        $query = Surat::query();

        // Filter by date range if specified
        if ($request->has('tanggal_mulai') && $request->has('tanggal_selesai')) {
            $query->whereBetween('tanggal_surat', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $surats = $query->orderBy('tanggal_surat', 'desc')->get();
        $profilDesa = ProfilDesa::getProfil();

        $data = [
            'data' => $surats,
            'profil' => $profilDesa
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf.surat', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('laporan-surat-' . date('Y-m-d') . '.pdf');
    }
}
