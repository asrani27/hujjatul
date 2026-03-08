@extends('layouts.app')

@section('title', 'Tambah Persyaratan - ' . $layanan->nama)

@section('content')
<div class="mb-6">
    <div>
        <a href="{{ route('admin.persyaratans.index', $layanan->id) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center mb-2">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Persyaratan
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Tambah Persyaratan Baru</h1>
        <p class="text-gray-600 mt-1">Layanan: {{ $layanan->nama }}</p>
    </div>
</div>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="text-red-800 font-semibold mb-2">Ada kesalahan dalam formulir:</div>
                <ul class="text-red-700 text-sm list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.persyaratans.store', $layanan->id) }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Nama Dokumen -->
                <div>
                    <label for="nama_dokumen" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Dokumen <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_dokumen" name="nama_dokumen"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('nama_dokumen') }}"
                        placeholder="Contoh: KTP, KK, Surat Pengantar"
                        required>
                </div>

                <!-- Keterangan -->
                <div>
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                        Keterangan
                    </label>
                    <textarea id="keterangan" name="keterangan" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Tambahkan keterangan atau deskripsi untuk dokumen ini">{{ old('keterangan') }}</textarea>
                </div>

                <!-- Tipe File -->
                <div>
                    <label for="tipe_file" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipe File yang Diperbolehkan
                    </label>
                    <input type="text" id="tipe_file" name="tipe_file"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('tipe_file') }}"
                        placeholder="Contoh: pdf,jpg,jpeg,png (kosongkan untuk semua tipe)">
                    <p class="mt-1 text-sm text-gray-500">
                        Pisahkan dengan koma. Contoh: pdf,jpg,png
                    </p>
                </div>

                <!-- Ukuran Maksimum -->
                <div>
                    <label for="max_size" class="block text-sm font-medium text-gray-700 mb-2">
                        Ukuran Maksimum (MB)
                    </label>
                    <input type="number" id="max_size" name="max_size" min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('max_size') }}"
                        placeholder="Contoh: 5 (kosongkan untuk tanpa batas)">
                    <p class="mt-1 text-sm text-gray-500">
                        Kosongkan jika tidak ingin membatasi ukuran file
                    </p>
                </div>

                <!-- Urutan -->
                <div>
                    <label for="urutan" class="block text-sm font-medium text-gray-700 mb-2">
                        Urutan <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="urutan" name="urutan" min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('urutan', $urutan) }}"
                        required>
                    <p class="mt-1 text-sm text-gray-500">
                        Nomor urutan tampilan persyaratan
                    </p>
                </div>

                <!-- Wajib -->
                <div class="flex items-center">
                    <input type="checkbox" id="wajib" name="wajib" 
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        {{ old('wajib') ? 'checked' : '' }}>
                    <label for="wajib" class="ml-2 block text-sm text-gray-900">
                        Dokumen ini wajib diisi
                    </label>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-8 flex gap-4">
                <a href="{{ route('admin.persyaratans.index', $layanan->id) }}"
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-center">
                    Batal
                </a>
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Simpan Persyaratan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection