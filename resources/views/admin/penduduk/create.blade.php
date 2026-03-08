@extends('layouts.app')

@section('title', 'Tambah Penduduk - Hujjatul')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.penduduks.index') }}" class="text-indigo-600 hover:text-indigo-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Tambah Penduduk</h1>
    </div>
</div>

<div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <form id="createPendudukForm" class="space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-6">
                <!-- NIK Field -->
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                        NIK <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nik" name="nik" required maxlength="16"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono"
                        placeholder="Masukkan 16 digit NIK">
                    <span class="text-red-500 text-sm" id="nikError"></span>
                </div>

                <!-- Nama Lengkap Field -->
                <div>
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan nama lengkap">
                    <span class="text-red-500 text-sm" id="nama_lengkapError"></span>
                </div>

                <!-- Tempat Lahir Field -->
                <div>
                    <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                        Tempat Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan tempat lahir">
                    <span class="text-red-500 text-sm" id="tempat_lahirError"></span>
                </div>

                <!-- Tanggal Lahir Field -->
                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <span class="text-red-500 text-sm" id="tanggal_lahirError"></span>
                </div>

                <!-- Agama Field -->
                <div>
                    <label for="agama" class="block text-sm font-medium text-gray-700 mb-2">
                        Agama <span class="text-red-500">*</span>
                    </label>
                    <select id="agama" name="agama" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Pilih Agama</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                    <span class="text-red-500 text-sm" id="agamaError"></span>
                </div>

                <!-- Status Kawin Field -->
                <div>
                    <label for="status_kawin" class="block text-sm font-medium text-gray-700 mb-2">
                        Status Perkawinan <span class="text-red-500">*</span>
                    </label>
                    <select id="status_kawin" name="status_kawin" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Pilih Status Perkawinan</option>
                        <option value="Belum Menikah">Belum Menikah</option>
                        <option value="Menikah">Menikah</option>
                        <option value="Cerai Hidup">Cerai Hidup</option>
                        <option value="Cerai Mati">Cerai Mati</option>
                    </select>
                    <span class="text-red-500 text-sm" id="status_kawinError"></span>
                </div>

                <!-- Desa Field -->
                <div>
                    <label for="desa" class="block text-sm font-medium text-gray-700 mb-2">
                        Desa <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="desa" name="desa" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan nama desa">
                    <span class="text-red-500 text-sm" id="desaError"></span>
                </div>

                <!-- Pekerjaan Field -->
                <div>
                    <label for="pekerjaan" class="block text-sm font-medium text-gray-700 mb-2">
                        Pekerjaan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="pekerjaan" name="pekerjaan" required
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Masukkan pekerjaan">
                    <span class="text-red-500 text-sm" id="pekerjaanError"></span>
                </div>
            </div>

            <!-- Jenis Kelamin Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jenis Kelamin <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-6">
                    <label class="flex items-center">
                        <input type="radio" name="jenis_kelamin" value="Laki-laki" required
                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-gray-700">Laki-laki</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="jenis_kelamin" value="Perempuan" required
                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-gray-700">Perempuan</span>
                    </label>
                </div>
                <span class="text-red-500 text-sm" id="jenis_kelaminError"></span>
            </div>

            <!-- Alamat Field -->
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                    Alamat <span class="text-red-500">*</span>
                </label>
                <textarea id="alamat" name="alamat" required rows="3"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Masukkan alamat lengkap"></textarea>
                <span class="text-red-500 text-sm" id="alamatError"></span>
            </div>

            <!-- No HP Field -->
            <div>
                <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor HP <span class="text-red-500">*</span>
                </label>
                <input type="text" id="no_hp" name="no_hp" required
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Masukkan nomor HP">
                <span class="text-red-500 text-sm" id="no_hpError"></span>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4">
                <button type="submit" id="submitBtn"
                    class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span id="btnText">Simpan Data</span>
                    <svg id="btnSpinner" class="hidden animate-spin h-5 w-5 text-white mx-auto" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </button>
                <a href="{{ route('admin.penduduks.index') }}"
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-3 px-6 rounded-lg transition duration-200 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    waitForJQuery(function($) {
    // NIK validation - only numbers and max 16 digits
    $('#nik').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        $(this).val(value.substring(0, 16));
    });

    $('#createPendudukForm').on('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        $('.text-red-500').text('');
        
        // Show loading state
        $('#submitBtn').prop('disabled', true);
        $('#btnText').addClass('hidden');
        $('#btnSpinner').removeClass('hidden');
        
        $.ajax({
            url: '{{ route("admin.penduduks.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    window.location.href = '{{ route("admin.penduduks.index") }}';
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                
                if (errors.nik) {
                    $('#nikError').text(errors.nik[0]);
                }
                if (errors.nama_lengkap) {
                    $('#nama_lengkapError').text(errors.nama_lengkap[0]);
                }
                if (errors.tempat_lahir) {
                    $('#tempat_lahirError').text(errors.tempat_lahir[0]);
                }
                if (errors.tanggal_lahir) {
                    $('#tanggal_lahirError').text(errors.tanggal_lahir[0]);
                }
                if (errors.jenis_kelamin) {
                    $('#jenis_kelaminError').text(errors.jenis_kelamin[0]);
                }
                if (errors.alamat) {
                    $('#alamatError').text(errors.alamat[0]);
                }
                if (errors.desa) {
                    $('#desaError').text(errors.desa[0]);
                }
                if (errors.agama) {
                    $('#agamaError').text(errors.agama[0]);
                }
                if (errors.status_kawin) {
                    $('#status_kawinError').text(errors.status_kawin[0]);
                }
                if (errors.pekerjaan) {
                    $('#pekerjaanError').text(errors.pekerjaan[0]);
                }
                if (errors.no_hp) {
                    $('#no_hpError').text(errors.no_hp[0]);
                }
                
                // Hide loading state
                $('#submitBtn').prop('disabled', false);
                $('#btnText').removeClass('hidden');
                $('#btnSpinner').addClass('hidden');
            }
        });
    });
});
</script>
@endsection