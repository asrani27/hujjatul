@extends('layouts.app')

@section('title', 'Profil Desa - Hujjatul')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Profil Desa</h1>
</div>

<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-6 pb-4 border-b">Update Profil Desa</h2>
        
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <form action="{{ route('admin.profil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Nama Desa -->
                <div>
                    <label for="nama_desa" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Desa <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_desa" name="nama_desa" required
                        value="{{ old('nama_desa', $profil->nama_desa ?? '') }}"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan nama desa">
                    @error('nama_desa')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Kecamatan -->
                <div>
                    <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-2">
                        Kecamatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="kecamatan" name="kecamatan" required
                        value="{{ old('kecamatan', $profil->kecamatan ?? '') }}"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan nama kecamatan">
                    @error('kecamatan')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Alamat Kantor -->
                <div>
                    <label for="alamat_kantor" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Kantor <span class="text-red-500">*</span>
                    </label>
                    <textarea id="alamat_kantor" name="alamat_kantor" rows="4" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan alamat kantor desa">{{ old('alamat_kantor', $profil->alamat_kantor ?? '') }}</textarea>
                    @error('alamat_kantor')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nama Kepala Desa -->
                <div>
                    <label for="nama_kepala_desa" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kepala Desa <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_kepala_desa" name="nama_kepala_desa" required
                        value="{{ old('nama_kepala_desa', $profil->nama_kepala_desa ?? '') }}"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan nama kepala desa">
                    @error('nama_kepala_desa')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- NIP Kepala Desa -->
                <div>
                    <label for="nip_kepala_desa" class="block text-sm font-medium text-gray-700 mb-2">
                        NIP Kepala Desa <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nip_kepala_desa" name="nip_kepala_desa" required
                        value="{{ old('nip_kepala_desa', $profil->nip_kepala_desa ?? '') }}"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan NIP kepala desa"
                        pattern="[0-9]{18}"
                        title="NIP harus 18 digit angka">
                    @error('nip_kepala_desa')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Format: 18 digit angka (contoh: 197501012010011001)</p>
                </div>

                <!-- Submit Button -->
                <div class="pt-6 border-t">
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Simpan Profil Desa
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Info Card -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-semibold text-blue-900 mb-2">Informasi Profil Desa</h3>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• Profil desa digunakan sebagai informasi dasar dalam sistem</li>
                    <li>• Data ini akan muncul di surat-surat dan dokumen resmi</li>
                    <li>• Pastikan NIP kepala desa valid (18 digit angka)</li>
                    <li>• Profil hanya satu untuk seluruh sistem</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection