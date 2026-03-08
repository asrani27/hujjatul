<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pengajuan;
use App\Models\PengajuanDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MasyarakatPengajuanController extends Controller
{
    /**
     * Display a listing of the user's pengajuans.
     */
    public function index()
    {
        $penduduk = auth()->user()->penduduk;
        
        $pengajuans = Pengajuan::with(['layanan', 'statusHistories'])
            ->where('penduduk_id', $penduduk->id)
            ->latest()
            ->paginate(10);

        return view('masyarakat.pengajuan.index', compact('pengajuans'));
    }

    /**
     * Show the form for creating a new pengajuan.
     */
    public function create()
    {
        $penduduk = auth()->user()->penduduk;
        $layanans = Layanan::where('is_active', true)->get();

        return view('masyarakat.pengajuan.create', compact('layanans', 'penduduk'));
    }

    /**
     * Store a newly created pengajuan in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanans,id',
            'keterangan' => 'nullable|string',
        ]);

        $penduduk = auth()->user()->penduduk;

        // Generate nomor pengajuan
        $layanan = Layanan::find($request->layanan_id);
        $prefix = strtoupper(substr($layanan->nama, 0, 3));
        $date = date('Ymd');
        $lastPengajuan = Pengajuan::whereDate('created_at', today())->count();
        $nomor = "{$prefix}-{$date}-" . str_pad($lastPengajuan + 1, 4, '0', STR_PAD_LEFT);

        // Create pengajuan
        $pengajuan = Pengajuan::create([
            'nomor' => $nomor,
            'penduduk_id' => $penduduk->id,
            'layanan_id' => $request->layanan_id,
            'tanggal' => now(),
            'keterangan' => $request->keterangan,
            'status' => 'menunggu',
        ]);

        // Create initial status history
        $pengajuan->statusHistories()->create([
            'status' => 'menunggu',
            'keterangan' => 'Pengajuan berhasil dibuat',
            'changed_by' => auth()->id(),
        ]);

        // Get all persyaratan for this layanan
        $persyaratanList = \App\Models\Persyaratan::where('layanan_id', $request->layanan_id)->get();

        // Upload documents
        foreach ($persyaratanList as $persyaratan) {
            $fieldName = 'dokumen_' . $persyaratan->id;

            if ($request->hasFile($fieldName)) {
                $file = $request->file($fieldName);
                
                // Validate file
                $validated = $request->validate([
                    $fieldName => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                ]);

                // Store file
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('pengajuan_dokumen', $filename, 'public');

                // Create document record
                PengajuanDokumen::create([
                    'pengajuan_id' => $pengajuan->id,
                    'persyaratan_id' => $persyaratan->id,
                    'nama_file' => $filename,
                    'path_file' => $path,
                    'mime_type' => $file->getMimeType(),
                    'ukuran_file' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('masyarakat.pengajuan.index')
            ->with('success', 'Pengajuan berhasil dibuat dengan nomor: ' . $nomor);
    }

    /**
     * Display the specified pengajuan.
     */
    public function show(Pengajuan $pengajuan)
    {
        $penduduk = auth()->user()->penduduk;

        // Check if pengajuan belongs to the logged-in user
        if ($pengajuan->penduduk_id !== $penduduk->id) {
            abort(403, 'Anda tidak memiliki akses ke pengajuan ini');
        }

        $pengajuan->load(['layanan', 'penduduk', 'statusHistories', 'dokumen']);

        return view('masyarakat.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Download a document.
     */
    public function downloadDokumen(PengajuanDokumen $dokumen)
    {
        $penduduk = auth()->user()->penduduk;
        $pengajuan = $dokumen->pengajuan;

        // Check if pengajuan belongs to the logged-in user
        if ($pengajuan->penduduk_id !== $penduduk->id) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini');
        }

        return Storage::disk('public')->download($dokumen->path, $dokumen->nama_file);
    }

    /**
     * Get persyaratan by layanan ID (AJAX).
     */
    public function getPersyaratanByLayanan($layananId)
    {
        $layanan = Layanan::with('persyaratans')->find($layananId);

        if (!$layanan) {
            return response()->json(['error' => 'Layanan tidak ditemukan'], 404);
        }

        return response()->json([
            'persyaratan' => $layanan->persyaratans->map(function ($persyaratan) {
                return [
                    'id' => $persyaratan->id,
                    'nama' => $persyaratan->nama_dokumen,
                    'wajib' => $persyaratan->wajib,
                ];
            })
        ]);
    }
}