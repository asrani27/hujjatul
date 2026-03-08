<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Layanan::with('persyaratans');
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
        }
        
        $layanans = $query->orderBy('nama')->paginate(10);
        
        if ($request->ajax()) {
            $layanans->getCollection()->transform(function ($layanan) {
                return [
                    'id' => $layanan->id,
                    'nama' => $layanan->nama,
                    'deskripsi' => $layanan->deskripsi,
                    'is_active' => $layanan->is_active,
                    'is_active_text' => $layanan->is_active ? 'Aktif' : 'Non-Aktif',
                    'is_active_badge' => $layanan->is_active 
                        ? '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>'
                        : '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Non-Aktif</span>',
                    'edit_url' => route('admin.layanans.edit', $layanan->id),
                    'persyaratan_url' => route('admin.persyaratans.index', $layanan->id),
                    'persyaratan_count' => $layanan->persyaratans->count(),
                ];
            });
            
            return response()->json([
                'layanans' => $layanans,
                'pagination' => $layanans->appends(['search' => $request->search])->links('pagination::tailwind')->toHtml()
            ]);
        }
        
        return view('admin.layanan.index', compact('layanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.layanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:layanans,nama',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Layanan::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.layanans.index')
            ->with('success', 'Layanan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Layanan $layanan)
    {
        $validator = Validator::make($request->all(), [
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('layanans', 'nama')->ignore($layanan->id),
            ],
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $layanan->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.layanans.index')
            ->with('success', 'Layanan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Layanan $layanan)
    {
        $layanan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Layanan berhasil dihapus'
        ]);
    }

    /**
     * Toggle active status.
     */
    public function toggleStatus(Layanan $layanan)
    {
        $layanan->update([
            'is_active' => !$layanan->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status layanan berhasil diubah'
        ]);
    }
}