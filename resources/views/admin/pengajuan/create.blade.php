@extends('layouts.app')

@section('title', 'Buat Pengajuan - Hujjatul')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.pengajuans.index') }}" class="text-indigo-600 hover:text-indigo-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Buat Pengajuan</h1>
    </div>
</div>

<div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <form id="createPengajuanForm" class="space-y-6" action="{{ route('admin.pengajuans.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-2 gap-6">
                <!-- Penduduk Field -->
                <div>
                    <label for="penduduk_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Penduduk <span class="text-red-500">*</span>
                    </label>
                    <select id="penduduk_id" name="penduduk_id" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Pilih Penduduk</option>
                        @foreach($penduduks as $penduduk)
                            <option value="{{ $penduduk->id }}" 
                                    data-nik="{{ $penduduk->nik }}" 
                                    data-nama="{{ $penduduk->nama_lengkap }}">
                                {{ $penduduk->nik }} - {{ $penduduk->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>
                    @error('penduduk_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Layanan Field -->
                <div>
                    <label for="layanan_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Layanan <span class="text-red-500">*</span>
                    </label>
                    <select id="layanan_id" name="layanan_id" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Pilih Layanan</option>
                        @foreach($layanans as $layanan)
                            <option value="{{ $layanan->id }}">{{ $layanan->nama }}</option>
                        @endforeach
                    </select>
                    @error('layanan_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tanggal Field -->
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="tanggal" name="tanggal" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('tanggal') ?? date('Y-m-d') }}">
                    @error('tanggal')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Keterangan Field -->
            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                    Keterangan
                </label>
                <textarea id="keterangan" name="keterangan" rows="3"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Masukkan keterangan pengajuan (opsional)">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Persyaratan Section -->
            <div id="persyaratanSection" class="hidden">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Upload Persyaratan</h3>
                <div id="persyaratanList" class="space-y-4">
                    <!-- Persyaratan fields will be dynamically loaded here -->
                </div>
            </div>

            <!-- Hidden input for route URL -->
            <input type="hidden" id="getPersyaratanRoute" value="{{ route('admin.pengajuans.getPersyaratan', ['layananId' => 'PLACEHOLDER']) }}">

            <!-- Submit Button -->
            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Buat Pengajuan
                </button>
                <a href="{{ route('admin.pengajuans.index') }}"
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-3 px-6 rounded-lg transition duration-200 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
waitForJQuery(function($) {
    // Initialize Select2 for penduduk_id
    $('#penduduk_id').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Cari penduduk (NIK atau Nama)...',
        allowClear: true,
        minimumInputLength: 0,
        templateResult: function(data) {
            if (data.id === '') {
                return data.text;
            }
            var $element = $(data.element);
            var nik = $element.data('nik');
            var nama = $element.data('nama');
            return $('<div>' + nik + ' - ' + nama + '</div>');
        },
        templateSelection: function(data) {
            if (data.id === '') {
                return data.text;
            }
            var $element = $(data.element);
            var nik = $element.data('nik');
            var nama = $element.data('nama');
            return $('<div>' + nik + ' - ' + nama + '</div>');
        },
        matcher: function(params, data) {
            // Return if no search term
            if ($.trim(params.term) === '') {
                return data;
            }
            
            // Return if no text
            if (typeof data.text === 'undefined' || data.text === null) {
                return null;
            }
            
            // Simple text matching - the text already contains "NIK - Nama" format
            var text = '';
            var term = '';
            
            try {
                text = String(data.text || '').toLowerCase();
                term = String(params.term || '').toLowerCase();
            } catch (e) {
                console.log('Error in matcher:', e);
                return null;
            }
            
            // Check if term matches anywhere in the text
            if (text.indexOf(term) > -1) {
                return data;
            }
            
            return null;
        }
    });

    // Load persyaratan when layanan is selected
    $('#layanan_id').on('change', function() {
        var layananId = $(this).val();
        var $persyaratanSection = $('#persyaratanSection');
        var $persyaratanList = $('#persyaratanList');
        
        if (layananId) {
            // Show loading
            $persyaratanSection.removeClass('hidden');
            $persyaratanList.html('<div class="text-center py-4"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mx-auto"></div><p class="mt-2 text-gray-600">Memuat persyaratan...</p></div>');
            
            // Fetch persyaratan via AJAX
            var routeUrl = $('#getPersyaratanRoute').val().replace('PLACEHOLDER', layananId);
            $.get(routeUrl)
                .done(function(response) {
                    if (response.success && response.persyaratan.length > 0) {
                        var html = '';
                        
                        response.persyaratan.forEach(function(item) {
                            var required = item.wajib ? '<span class="text-red-500">*</span>' : '';
                            var requiredClass = item.wajib ? 'required' : '';
                            var maxSizeText = item.max_size ? '(Maks: ' + (item.max_size / 1024) + ' MB)' : '';
                            var acceptTypes = item.tipe_file ? 'accept="' + item.tipe_file + '"' : '';
                            
                            html += `
                                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        ${item.nama_dokumen} ${required}
                                        ${item.keterangan ? '<span class="text-gray-500 text-xs block mt-1">' + item.keterangan + '</span>' : ''}
                                    </label>
                                    <input type="file" 
                                           name="dokumen_${item.id}" 
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 ${requiredClass}"
                                           ${acceptTypes}
                                           data-persyaratan-id="${item.id}"
                                           data-wajib="${item.wajib}">
                                    <p class="mt-1 text-xs text-gray-500">${maxSizeText}</p>
                                    @error('dokumen_${item.id}')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            `;
                        });
                        
                        $persyaratanList.html(html);
                    } else {
                        $persyaratanList.html('<div class="text-center py-4 text-gray-600">Tidak ada persyaratan untuk layanan ini</div>');
                    }
                })
                .fail(function() {
                    $persyaratanList.html('<div class="text-center py-4 text-red-600">Gagal memuat persyaratan. Silakan coba lagi.</div>');
                });
        } else {
            // Hide persyaratan section if no layanan selected
            $persyaratanSection.addClass('hidden');
            $persyaratanList.empty();
        }
    });

    // Form validation before submit
    $('#createPengajuanForm').on('submit', function(e) {
        var isValid = true;
        
        // Check required file uploads
        $('[data-wajib="true"]').each(function() {
            if ($(this).prop('files').length === 0) {
                isValid = false;
                $(this).addClass('border-red-500');
            } else {
                $(this).removeClass('border-red-500');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua persyaratan yang wajib diupload.');
        }
    });
});
</script>
@endsection