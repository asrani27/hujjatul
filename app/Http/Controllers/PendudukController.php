<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class PendudukController extends Controller
{
    /**
     * Display a listing of penduduk with AJAX search.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Penduduk::query()->with('user');

            // Search functionality
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nik', 'like', '%' . $search . '%')
                        ->orWhere('nama_lengkap', 'like', '%' . $search . '%')
                        ->orWhere('alamat', 'like', '%' . $search . '%')
                        ->orWhere('desa', 'like', '%' . $search . '%');
                });
            }

            $penduduks = $query->latest()->paginate(10);

            // Add edit_url and tanggal_lahir_indo to each penduduk
            $penduduks->getCollection()->transform(function ($penduduk) {
                $penduduk->edit_url = route('admin.penduduks.edit', $penduduk->id);
                $penduduk->tanggal_lahir_indo = $penduduk->tanggal_lahir_indo;
                return $penduduk;
            });

            return response()->json([
                'penduduks' => $penduduks,
                'pagination' => $penduduks->links('pagination.tailwind')->toHtml()
            ]);
        }

        return view('admin.penduduk.index');
    }

    /**
     * Show the form for creating a new penduduk.
     */
    public function create()
    {
        return view('admin.penduduk.create');
    }

    /**
     * Store a newly created penduduk in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|digits:16|unique:penduduks,nik',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'desa' => 'required|string|max:255',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'status_kawin' => 'required|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $penduduk = Penduduk::create([
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'desa' => $request->desa,
            'agama' => $request->agama,
            'status_kawin' => $request->status_kawin,
            'pekerjaan' => $request->pekerjaan,
            'no_hp' => $request->no_hp,
        ]);

        Session::flash('success', "Data penduduk <b>{$penduduk->nama_lengkap}</b> berhasil ditambahkan!");

        return response()->json([
            'success' => true,
            'message' => 'Penduduk created successfully!'
        ]);
    }

    /**
     * Show the form for editing the specified penduduk.
     */
    public function edit($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        return view('admin.penduduk.edit', compact('penduduk'));
    }

    /**
     * Update the specified penduduk in storage.
     */
    public function update(Request $request, $id)
    {
        $penduduk = Penduduk::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|digits:16|unique:penduduks,nik,' . $id,
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'desa' => 'required|string|max:255',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'status_kawin' => 'required|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $penduduk->nik = $request->nik;
        $penduduk->nama_lengkap = $request->nama_lengkap;
        $penduduk->tempat_lahir = $request->tempat_lahir;
        $penduduk->tanggal_lahir = $request->tanggal_lahir;
        $penduduk->jenis_kelamin = $request->jenis_kelamin;
        $penduduk->alamat = $request->alamat;
        $penduduk->desa = $request->desa;
        $penduduk->agama = $request->agama;
        $penduduk->status_kawin = $request->status_kawin;
        $penduduk->pekerjaan = $request->pekerjaan;
        $penduduk->no_hp = $request->no_hp;

        $penduduk->save();

        Session::flash('success', "Data penduduk <b>{$penduduk->nama_lengkap}</b> berhasil diperbarui!");

        return response()->json([
            'success' => true,
            'message' => 'Penduduk updated successfully!'
        ]);
    }

    /**
     * Remove the specified penduduk from storage.
     */
    public function destroy($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $pendudukNama = $penduduk->nama_lengkap;
        $penduduk->delete();

        Session::flash('success', "Data penduduk <b>{$pendudukNama}</b> berhasil dihapus!");

        return response()->json([
            'success' => true,
            'message' => 'Penduduk deleted successfully!'
        ]);
    }

    /**
     * Create a user account for the specified penduduk.
     */
    public function createUser($id)
    {
        $penduduk = Penduduk::findOrFail($id);

        // Check if user already exists
        if ($penduduk->user) {
            return response()->json([
                'success' => false,
                'message' => 'Penduduk ini sudah memiliki akun user!'
            ], 400);
        }

        // Create user with NIK as username and "masyarakat" as password
        $user = User::create([
            'name' => $penduduk->nama_lengkap,
            'username' => $penduduk->nik,
            'password' => Hash::make('masyarakat'),
            'role' => 'MASYARAKAT',
        ]);

        // Link user to penduduk
        $penduduk->user_id = $user->id;
        $penduduk->save();

        Session::flash('success', "Akun user berhasil dibuat untuk <b>{$penduduk->nama_lengkap}</b>! Username: {$penduduk->nik}, Password: masyarakat");

        return response()->json([
            'success' => true,
            'message' => 'User created successfully!'
        ]);
    }

    /**
     * Reset password for the specified penduduk's user account.
     */
    public function resetPassword($id)
    {
        $penduduk = Penduduk::findOrFail($id);

        // Check if user exists
        if (!$penduduk->user) {
            return response()->json([
                'success' => false,
                'message' => 'Penduduk ini belum memiliki akun user!'
            ], 400);
        }

        // Reset password to "masyarakat"
        $penduduk->user->password = Hash::make('masyarakat');
        $penduduk->user->save();

        Session::flash('success', "Password berhasil di-reset untuk <b>{$penduduk->nama_lengkap}</b>! Password baru: masyarakat");

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully!'
        ]);
    }
}
