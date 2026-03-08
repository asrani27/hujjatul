<?php

namespace App\Http\Controllers;

use App\Models\ProfilDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    /**
     * Display the form for editing profil desa.
     */
    public function edit()
    {
        $profil = ProfilDesa::getProfil();
        
        return view('admin.profil.edit', compact('profil'));
    }

    /**
     * Update the profil desa.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'alamat_kantor' => 'required|string',
            'nama_kepala_desa' => 'required|string|max:255',
            'nip_kepala_desa' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        ProfilDesa::updateOrCreateProfil([
            'nama_desa' => $request->nama_desa,
            'kecamatan' => $request->kecamatan,
            'alamat_kantor' => $request->alamat_kantor,
            'nama_kepala_desa' => $request->nama_kepala_desa,
            'nip_kepala_desa' => $request->nip_kepala_desa,
        ]);

        return redirect()
            ->route('admin.profil.edit')
            ->with('success', 'Profil desa berhasil diperbarui');
    }
}