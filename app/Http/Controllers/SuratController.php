<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Surat::query();
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nomor_surat', 'like', "%{$search}%");
        }
        
        $surats = $query->orderBy('tanggal_surat', 'desc')->paginate(10);
        
        if ($request->ajax()) {
            return response()->json([
                'surats' => $surats,
                'pagination' => $surats->appends(['search' => $request->search])->links('pagination::tailwind')->toHtml()
            ]);
        }
        
        return view('admin.surat.index', compact('surats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.surat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'required|string|max:255|unique:surats,nomor_surat',
            'jenis_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // Max 10MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('surat', $fileName, 'public');
        }

        Surat::create([
            'nomor_surat' => $request->nomor_surat,
            'jenis_surat' => $request->jenis_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'file' => $filePath,
        ]);

        return redirect()
            ->route('admin.surats.index')
            ->with('success', 'Surat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Surat $surat)
    {
        return view('admin.surat.show', compact('surat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Surat $surat)
    {
        return view('admin.surat.edit', compact('surat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Surat $surat)
    {
        $validator = Validator::make($request->all(), [
            'nomor_surat' => 'required|string|max:255|unique:surats,nomor_surat,' . $surat->id,
            'jenis_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // Max 10MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle file upload if new file is provided
        if ($request->hasFile('file')) {
            // Delete old file
            if ($surat->file && Storage::disk('public')->exists($surat->file)) {
                Storage::disk('public')->delete($surat->file);
            }
            
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('surat', $fileName, 'public');
            
            $surat->file = $filePath;
        }

        $surat->update([
            'nomor_surat' => $request->nomor_surat,
            'jenis_surat' => $request->jenis_surat,
            'tanggal_surat' => $request->tanggal_surat,
        ]);

        return redirect()
            ->route('admin.surats.index')
            ->with('success', 'Surat berhasil diperbarui');
    }

    /**
     * Download the file.
     */
    public function download(Surat $surat)
    {
        if (!Storage::disk('public')->exists($surat->file)) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::disk('public')->download($surat->file, $surat->file_name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Surat $surat)
    {
        // Delete file from storage
        if ($surat->file && Storage::disk('public')->exists($surat->file)) {
            Storage::disk('public')->delete($surat->file);
        }
        
        $surat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Surat berhasil dihapus'
        ]);
    }
}