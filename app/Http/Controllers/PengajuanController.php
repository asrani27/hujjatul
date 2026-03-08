<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Penduduk;
use App\Models\Layanan;
use App\Models\Persyaratan;
use App\Models\PengajuanDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pengajuan::with(['penduduk', 'layanan', 'statusHistories' => function($q) {
            $q->latest()->limit(5);
        }]);
        
        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nomor', 'like', "%{$search}%")
                  ->orWhereHas('penduduk', function($q) use ($search) {
                      $q->where('nama_lengkap', 'like', "%{$search}%");
                  })
                  ->orWhereHas('layanan', function($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  });
        }
        
        $pengajuans = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get available layanans for filter
        $layanans = Layanan::where('is_active', true)->orderBy('nama')->get();
        $penduduks = Penduduk::orderBy('nama_lengkap')->get();
        
        if ($request->ajax()) {
            $pengajuans->getCollection()->transform(function ($pengajuan) {
                return [
                    'id' => $pengajuan->id,
                    'nomor' => $pengajuan->nomor,
                    'penduduk_nama' => $pengajuan->penduduk->nama_lengkap,
                    'layanan_nama' => $pengajuan->layanan->nama,
                    'tanggal' => $pengajuan->tanggal_indo,
                    'status' => $pengajuan->status,
                    'status_badge' => $this->getStatusBadge($pengajuan->status),
                    'show_url' => route('admin.pengajuans.show', $pengajuan->id),
                    'edit_url' => route('admin.pengajuans.edit', $pengajuan->id),
                ];
            });
            
            return response()->json([
                'pengajuans' => $pengajuans,
                'pagination' => $pengajuans->appends(['search' => $request->search, 'status' => $request->status])->links('pagination::tailwind')->toHtml()
            ]);
        }
        
        return view('admin.pengajuan.index', compact('pengajuans', 'layanans', 'penduduks'));
    }

    /**
     * Show form for creating a new resource.
     */
    public function create()
    {
        $penduduks = Penduduk::orderBy('nama_lengkap')->get();
        $layanans = Layanan::where('is_active', true)->orderBy('nama')->get();
        $persyaratan = collect();
        
        return view('admin.pengajuan.create', compact('penduduks', 'layanans', 'persyaratan'));
    }

    /**
     * Get persyaratan by layanan ID.
     */
    public function getPersyaratanByLayanan($layananId)
    {
        $persyaratan = Persyaratan::where('layanan_id', $layananId)
            ->orderBy('urutan')
            ->get();
        
        return response()->json([
            'success' => true,
            'persyaratan' => $persyaratan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penduduk_id' => 'required|exists:penduduks,id',
            'layanan_id' => 'required|exists:layanans,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validate required document uploads
        $persyaratanList = Persyaratan::where('layanan_id', $request->layanan_id)
            ->where('wajib', true)
            ->get();
        
        foreach ($persyaratanList as $persyaratan) {
            $fieldName = 'dokumen_' . $persyaratan->id;
            if (!$request->hasFile($fieldName)) {
                return redirect()->back()
                    ->withErrors([$fieldName => 'Dokumen ' . $persyaratan->nama_dokumen . ' wajib diupload'])
                    ->withInput();
            }
        }

        // Generate unique nomor
        $nomor = $this->generateNomor();

        $pengajuan = Pengajuan::create([
            'nomor' => $nomor,
            'penduduk_id' => $request->penduduk_id,
            'layanan_id' => $request->layanan_id,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'status' => 'menunggu',
        ]);

        // Create initial status history
        $pengajuan->updateStatus('menunggu', 'Pengajuan dibuat', Auth::id());

        // Handle file uploads
        $this->handleDocumentUploads($request, $pengajuan);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan berhasil ditambahkan'
            ]);
        }

        return redirect()
            ->route('admin.pengajuans.index')
            ->with('success', 'Pengajuan berhasil ditambahkan');
    }

    /**
     * Handle document uploads for pengajuan.
     */
    private function handleDocumentUploads(Request $request, Pengajuan $pengajuan): void
    {
        $persyaratanList = Persyaratan::where('layanan_id', $pengajuan->layanan_id)->get();

        foreach ($persyaratanList as $persyaratan) {
            $fieldName = 'dokumen_' . $persyaratan->id;

            if ($request->hasFile($fieldName)) {
                $file = $request->file($fieldName);
                
                // Validate file size if specified
                if ($persyaratan->max_size && $file->getSize() > $persyaratan->max_size) {
                    continue; // Skip files that exceed size limit
                }

                // Store file
                $path = $file->store('pengajuan/' . $pengajuan->id, 'public');

                // Create document record
                PengajuanDokumen::create([
                    'pengajuan_id' => $pengajuan->id,
                    'persyaratan_id' => $persyaratan->id,
                    'nama_file' => $file->getClientOriginalName(),
                    'path_file' => $path,
                    'mime_type' => $file->getMimeType(),
                    'ukuran_file' => $file->getSize(),
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengajuan $pengajuan)
    {
        $pengajuan->load(['penduduk', 'layanan', 'statusHistories.user']);
        
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengajuan $pengajuan)
    {
        $penduduks = Penduduk::orderBy('nama_lengkap')->get();
        $layanans = Layanan::where('is_active', true)->orderBy('nama')->get();
        
        return view('admin.pengajuan.edit', compact('pengajuan', 'penduduks', 'layanans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengajuan $pengajuan)
    {
        $validator = Validator::make($request->all(), [
            'penduduk_id' => 'required|exists:penduduks,id',
            'layanan_id' => 'required|exists:layanans,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pengajuan->update([
            'penduduk_id' => $request->penduduk_id,
            'layanan_id' => $request->layanan_id,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        // Handle file uploads for new documents
        $this->handleDocumentUploads($request, $pengajuan);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan berhasil diperbarui'
            ]);
        }

        return redirect()
            ->route('admin.pengajuans.index')
            ->with('success', 'Pengajuan berhasil diperbarui');
    }

    /**
     * Update status of the specified resource.
     */
    public function updateStatus(Request $request, Pengajuan $pengajuan)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'catatan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $pengajuan->updateStatus($request->status, $request->catatan, Auth::id());

        return response()->json([
            'success' => true,
            'message' => 'Status pengajuan berhasil diperbarui'
        ]);
    }

    /**
     * Download document.
     */
    public function downloadDokumen(PengajuanDokumen $dokumen)
    {
        // Check if file exists
        if (!Storage::disk('public')->exists($dokumen->path_file)) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::disk('public')->download($dokumen->path_file, $dokumen->nama_file);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengajuan $pengajuan)
    {
        $pengajuan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan berhasil dihapus'
        ]);
    }

    /**
     * Generate unique nomor pengajuan.
     */
    private function generateNomor(): string
    {
        $prefix = 'PGJ';
        $date = date('Ymd');
        $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
        
        return $prefix . $date . $random;
    }

    /**
     * Get status badge HTML.
     */
    private function getStatusBadge(string $status): string
    {
        return match($status) {
            'menunggu' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>',
            'diproses' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Diproses</span>',
            'selesai' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>',
            'ditolak' => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>',
            default => '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">' . $status . '</span>',
        };
    }
}