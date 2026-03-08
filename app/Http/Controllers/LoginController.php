<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Display the login page.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Redirect based on role
            $user = Auth::user();
            if ($user->role === 'ADMIN') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'KEPALA_DESA') {
                return redirect()->route('kepala-desa.dashboard');
            } else {
                return redirect()->route('masyarakat.dashboard');
            }
        }

        throw ValidationException::withMessages([
            'username' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Display the registration page.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|digits:16|unique:penduduks,nik|unique:users,username',
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
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create Penduduk
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

        // Create User with MASYARAKAT role
        $user = User::create([
            'name' => $penduduk->nama_lengkap,
            'username' => $penduduk->nik,
            'password' => Hash::make($request->password),
            'role' => 'MASYARAKAT',
        ]);

        // Link user to penduduk
        $penduduk->user_id = $user->id;
        $penduduk->save();

        // Log the user in
        Auth::login($user);

        return redirect()->route('masyarakat.dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang.');
    }
}
