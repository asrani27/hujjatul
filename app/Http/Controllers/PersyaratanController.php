<?php

namespace App\Http\Controllers;

use App\Models\Persyaratan;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PersyaratanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Layanan $layanan)
    {
        $persyaratans = $layanan->persyaratans()->orderBy('urutan')->get();
        return view('admin.persyaratan.index', compact('layanan', 'persyaratans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Layanan $layanan)
    {
        $urutan = $layanan->persyaratans()->count() + 1;
        return view('admin.persyaratan.create', compact('layanan', 'urutan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Layanan $layanan)
    {
        $validator = Validator::make($request->all(), [
            'nama_dokumen' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'tipe_file' => 'nullable|string',
            'max_size' => 'nullable|integer|min:1',
            'wajib' => 'nullable|boolean',
            'urutan' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Persyaratan::create([
            'layanan_id' => $layanan->id,
            'nama_dokumen' => $request->nama_dokumen,
            'keterangan' => $request->keterangan,
            'tipe_file' => $request->tipe_file,
            'max_size' => $request->max_size,
            'wajib' => $request->has('wajib'),
            'urutan' => $request->urutan,
        ]);

        return redirect()
            ->route('admin.persyaratans.index', $layanan->id)
            ->with('success', 'Persyaratan berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Layanan $layanan, Persyaratan $persyaratan)
    {
        return view('admin.persyaratan.edit', compact('layanan', 'persyaratan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Layanan $layanan, Persyaratan $persyaratan)
    {
        $validator = Validator::make($request->all(), [
            'nama_dokumen' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'tipe_file' => 'nullable|string',
            'max_size' => 'nullable|integer|min:1',
            'wajib' => 'nullable|boolean',
            'urutan' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $persyaratan->update([
            'nama_dokumen' => $request->nama_dokumen,
            'keterangan' => $request->keterangan,
            'tipe_file' => $request->tipe_file,
            'max_size' => $request->max_size,
            'wajib' => $request->has('wajib'),
            'urutan' => $request->urutan,
        ]);

        return redirect()
            ->route('admin.persyaratans.index', $layanan->id)
            ->with('success', 'Persyaratan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Layanan $layanan, Persyaratan $persyaratan)
    {
        $persyaratan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Persyaratan berhasil dihapus'
        ]);
    }

    /**
     * Reorder persyaratans.
     */
    public function reorder(Request $request, Layanan $layanan)
    {
        $orders = $request->orders;

        foreach ($orders as $index => $id) {
            Persyaratan::where('id', $id)->update(['urutan' => $index + 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan persyaratan berhasil diperbarui'
        ]);
    }
}