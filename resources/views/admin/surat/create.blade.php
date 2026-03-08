@extends('layouts.app')

@section('title', 'Tambah Surat')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.surats.index') }}" 
           class="text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Surat</h1>
            <p class="text-gray-600 mt-1">Tambahkan arsip surat baru</p>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.surats.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nomor Surat -->
            <div class="mb-4">
                <label for="nomor_surat" class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Surat <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nomor_surat" 
                       id="nomor_surat" 
                       value="{{ old('nomor_surat') }}"
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                       placeholder="Contoh: 470/001/DS/2026">
                @error('nomor_surat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Surat -->
            <div class="mb-4">
                <label for="jenis_surat" class="block text-sm font-medium text-gray-700 mb-2">
                    Jenis Surat <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="jenis_surat" 
                       id="jenis_surat" 
                       value="{{ old('jenis_surat') }}"
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                       placeholder="Contoh: Surat Keterangan, Surat Pengantar">
                @error('jenis_surat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Surat -->
            <div class="mb-4">
                <label for="tanggal_surat" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Surat <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       name="tanggal_surat" 
                       id="tanggal_surat" 
                       value="{{ old('tanggal_surat') }}"
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                @error('tanggal_surat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- File Surat -->
            <div class="mb-6">
                <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                    File Surat <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-500 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Upload file</span>
                                <input id="file" name="file" type="file" class="sr-only" required accept=".pdf,.doc,.docx">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">
                            PDF, DOC, DOCX hingga 10MB
                        </p>
                    </div>
                </div>
                @error('file')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.surats.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Simpan Surat
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Preview selected file
document.getElementById('file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const fileName = file.name;
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        const fileExtension = fileName.split('.').pop().toLowerCase();
        
        // Validate file size (max 10MB)
        if (fileSize > 10) {
            alert('Ukuran file terlalu besar! Maksimal 10MB');
            e.target.value = '';
            return;
        }
        
        // Validate file type
        const allowedTypes = ['pdf', 'doc', 'docx'];
        if (!allowedTypes.includes(fileExtension)) {
            alert('Format file tidak didukung! Gunakan PDF, DOC, atau DOCX');
            e.target.value = '';
            return;
        }
        
        console.log('File selected:', fileName, 'Size:', fileSize + 'MB');
    }
});
</script>
@endsection