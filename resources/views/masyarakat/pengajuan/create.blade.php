@extends('layouts.app')

@section('title', 'Buat Pengajuan - Hujjatul')

@push('styles')
<style>
    .step-indicator {
        transition: all 0.3s ease;
    }
    .step-indicator.active {
        background-color: #4F46E5;
        color: white;
    }
    .step-indicator.completed {
        background-color: #10B981;
        color: white;
    }
    .step-line {
        transition: all 0.3s ease;
    }
    .step-line.completed {
        background-color: #10B981;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Buat Pengajuan Baru</h1>
        <p class="text-gray-600 mt-1">Lengkapi formulir di bawah ini untuk membuat pengajuan layanan</p>
    </div>

    <!-- Wizard Progress -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-8">
            <!-- Step 1 -->
            <div class="flex items-center">
                <div class="step-indicator active flex items-center justify-center w-10 h-10 rounded-full border-2 border-indigo-600 text-indigo-600 font-semibold" data-step="1">
                    1
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Informasi Layanan</p>
                    <p class="text-xs text-gray-500">Pilih layanan dan keterangan</p>
                </div>
            </div>
            
            <!-- Line -->
            <div class="step-line flex-1 h-0.5 bg-gray-300 mx-4"></div>
            
            <!-- Step 2 -->
            <div class="flex items-center">
                <div class="step-indicator flex items-center justify-center w-10 h-10 rounded-full border-2 border-gray-300 text-gray-400 font-semibold" data-step="2">
                    2
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Upload Dokumen</p>
                    <p class="text-xs text-gray-500">Unggah persyaratan</p>
                </div>
            </div>
            
            <!-- Line -->
            <div class="step-line flex-1 h-0.5 bg-gray-300 mx-4"></div>
            
            <!-- Step 3 -->
            <div class="flex items-center">
                <div class="step-indicator flex items-center justify-center w-10 h-10 rounded-full border-2 border-gray-300 text-gray-400 font-semibold" data-step="3">
                    3
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Konfirmasi</p>
                    <p class="text-xs text-gray-500">Review dan kirim</p>
                </div>
            </div>
        </div>

        <form action="{{ route('masyarakat.pengajuan.store') }}" method="POST" enctype="multipart/form-data" id="wizardForm">
            @csrf

            <!-- Error Messages -->
            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
                <h3 class="text-sm font-medium text-red-800 mb-2">Terjadi kesalahan:</h3>
                <ul class="text-sm text-red-700 list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- STEP 1: Informasi Layanan -->
            <div class="wizard-step active" id="step-1">
                <!-- Informasi Penduduk -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Informasi Penduduk</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" value="{{ $penduduk->nama_lengkap }}" readonly
                                class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">NIK</label>
                            <input type="text" value="{{ $penduduk->nik }}" readonly
                                class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Desa</label>
                            <input type="text" value="{{ $penduduk->desa }}" readonly
                                class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-600">
                        </div>
                    </div>
                </div>

                <!-- Tanggal Pengajuan -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Pengajuan
                    </label>
                    <input type="text" value="{{ now()->format('d F Y') }}" readonly
                        class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-600">
                </div>

                <!-- Pilihan Layanan -->
                <div class="mb-6">
                    <label for="layanan_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Layanan <span class="text-red-500">*</span>
                    </label>
                    <select id="layanan_id" name="layanan_id" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($layanans as $layanan)
                        <option value="{{ $layanan->id }}">{{ $layanan->nama }}</option>
                        @endforeach
                    </select>
                    @error('layanan_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div class="mb-6">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                        Keterangan Tambahan
                    </label>
                    <textarea id="keterangan" name="keterangan" rows="3"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Tuliskan keterangan tambahan jika ada...">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Navigation Buttons -->
                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('masyarakat.pengajuan.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="button" onclick="nextStep(2)"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                        Lanjut →
                    </button>
                </div>
            </div>

            <!-- STEP 2: Upload Dokumen -->
            <div class="wizard-step" id="step-2" style="display: none;">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Upload Dokumen Persyaratan</h3>
                
                <!-- Persyaratan List -->
                <div id="persyaratan-container" class="mb-6">
                    <div id="persyaratan-list" class="space-y-4">
                        <div class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="mt-2">Silakan pilih layanan terlebih dahulu</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex items-center justify-end space-x-3">
                    <button type="button" onclick="prevStep(1)"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        ← Kembali
                    </button>
                    <button type="button" onclick="nextStep(3)"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                        Lanjut →
                    </button>
                </div>
            </div>

            <!-- STEP 3: Konfirmasi -->
            <div class="wizard-step" id="step-3" style="display: none;">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Pengajuan</h3>
                
                <div class="space-y-4">
                    <!-- Summary Card -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h4 class="text-sm font-semibold text-gray-700 mb-4">Ringkasan Pengajuan</h4>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Nama Lengkap</span>
                                <span class="text-sm font-medium text-gray-900">{{ $penduduk->nama_lengkap }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">NIK</span>
                                <span class="text-sm font-medium text-gray-900">{{ $penduduk->nik }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Tanggal Pengajuan</span>
                                <span class="text-sm font-medium text-gray-900">{{ now()->format('d F Y') }}</span>
                            </div>
                            <hr class="my-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Layanan</span>
                                <span class="text-sm font-medium text-gray-900" id="summary-layanan">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Keterangan</span>
                                <span class="text-sm font-medium text-gray-900 text-right" id="summary-keterangan">-</span>
                            </div>
                            <hr class="my-2">
                            <div>
                                <span class="text-sm text-gray-600">Dokumen yang diupload:</span>
                                <ul id="summary-dokumen" class="text-sm text-gray-900 mt-2 list-disc list-inside">
                                    <li class="text-gray-500">Belum ada dokumen</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Warning -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Pastikan semua informasi sudah benar sebelum mengirim pengajuan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex items-center justify-end space-x-3 mt-6">
                    <button type="button" onclick="prevStep(2)"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        ← Kembali
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                        Kirim Pengajuan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentStep = 1;
    const totalSteps = 3;
    let uploadedFiles = [];

    // Initialize: Hide all steps except step 1 on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Hide step 2 and step 3
        document.getElementById('step-2').style.display = 'none';
        document.getElementById('step-3').style.display = 'none';
        
        // Ensure step 1 is visible
        const step1 = document.getElementById('step-1');
        step1.style.display = 'block';
    });

    function nextStep(step) {
        // Validate step before proceeding
        if (currentStep === 1) {
            const layananId = document.getElementById('layanan_id').value;
            if (!layananId) {
                alert('Silakan pilih layanan terlebih dahulu');
                return;
            }
        }

        if (currentStep === 2) {
            // Check if any documents are uploaded (optional, but good UX)
            const fileInputs = document.querySelectorAll('input[type="file"]');
            let hasFiles = false;
            fileInputs.forEach(input => {
                if (input.files.length > 0) hasFiles = true;
            });
            
            // Update summary
            updateSummary();
        }

        // Hide current step
        const currentStepElement = document.getElementById(`step-${currentStep}`);
        currentStepElement.classList.remove('active');
        currentStepElement.style.display = 'none';
        
        // Update step indicators
        document.querySelector(`[data-step="${currentStep}"]`).classList.remove('active');
        document.querySelector(`[data-step="${currentStep}"]`).classList.add('completed');
        
        // Update step lines
        if (currentStep < totalSteps) {
            const lines = document.querySelectorAll('.step-line');
            lines[currentStep - 1]?.classList.add('completed');
        }
        
        // Show next step
        const nextStepElement = document.getElementById(`step-${step}`);
        nextStepElement.classList.add('active');
        nextStepElement.style.display = 'block';
        document.querySelector(`[data-step="${step}"]`).classList.add('active');
        
        currentStep = step;

        // Load persyaratan when entering step 2
        if (step === 2) {
            loadPersyaratan();
        }
    }

    function prevStep(step) {
        // Hide current step
        const currentStepElement = document.getElementById(`step-${currentStep}`);
        currentStepElement.classList.remove('active');
        currentStepElement.style.display = 'none';
        document.querySelector(`[data-step="${currentStep}"]`).classList.remove('active');
        
        // Remove completed status from current step
        document.querySelector(`[data-step="${currentStep}"]`).classList.remove('completed');
        
        // Update step lines
        if (currentStep > 1) {
            const lines = document.querySelectorAll('.step-line');
            lines[currentStep - 2]?.classList.remove('completed');
        }
        
        // Show previous step
        const prevStepElement = document.getElementById(`step-${step}`);
        prevStepElement.classList.add('active');
        prevStepElement.style.display = 'block';
        document.querySelector(`[data-step="${step}"]`).classList.add('active');
        
        currentStep = step;
    }

    function loadPersyaratan() {
        const layananId = document.getElementById('layanan_id').value;
        const persyaratanList = document.getElementById('persyaratan-list');
        
        if (!layananId) {
            persyaratanList.innerHTML = `
                <div class="text-center py-8 text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="mt-2">Silakan pilih layanan terlebih dahulu</p>
                </div>
            `;
            return;
        }

        // Show loading
        persyaratanList.innerHTML = `
            <div class="text-center py-8">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mx-auto"></div>
                <p class="mt-2 text-gray-600">Memuat persyaratan...</p>
            </div>
        `;

        // Fetch persyaratan
        fetch(`/masyarakat/pengajuan/get-persyaratan/${layananId}`)
            .then(response => response.json())
            .then(data => {
                if (data.persyaratan && data.persyaratan.length > 0) {
                    persyaratanList.innerHTML = data.persyaratan.map(p => {
                        const required = p.wajib ? '<span class="text-red-500">*</span>' : '';
                        const requiredAttr = p.wajib ? 'required' : '';
                        
                        return `
                            <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    ${p.nama} ${required}
                                </label>
                                <div class="flex items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-indigo-500 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                                <span>Pilih file</span>
                                                <input type="file" name="dokumen_${p.id}" 
                                                       class="sr-only" 
                                                       accept=".pdf,.jpg,.jpeg,.png"
                                                       onchange="handleFileUpload(this, ${p.wajib})"
                                                       ${requiredAttr}>
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PDF, JPG, JPEG, PNG sampai 5MB</p>
                                    </div>
                                </div>
                                <div class="mt-2 file-info hidden">
                                    <span class="text-sm text-green-600">✓ File dipilih: </span>
                                    <span class="text-sm text-gray-700 filename"></span>
                                </div>
                            </div>
                        `;
                    }).join('');
                } else {
                    persyaratanList.innerHTML = `
                        <div class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="mt-2">Tidak ada persyaratan untuk layanan ini</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                persyaratanList.innerHTML = `
                    <div class="text-center py-8 text-red-600">
                        <p>Gagal memuat persyaratan. Silakan coba lagi.</p>
                    </div>
                `;
            });
    }

    function handleFileUpload(input, isRequired) {
        const maxSize = 5 * 1024 * 1024; // 5MB
        const wrapper = input.closest('.border-gray-200');
        
        if (!wrapper) {
            console.error('Wrapper not found');
            return;
        }
        
        const fileInfo = wrapper.querySelector('.file-info');
        
        if (!fileInfo) {
            console.error('file-info element not found');
            return;
        }
        
        const filename = fileInfo.querySelector('.filename');
        
        if (!filename) {
            console.error('filename element not found');
            return;
        }
        
        if (input.files.length > 0) {
            const file = input.files[0];
            
            if (file.size > maxSize) {
                alert(`File ${file.name} melebihi ukuran maksimal 5MB`);
                input.value = '';
                fileInfo.classList.add('hidden');
                return;
            }
            
            fileInfo.classList.remove('hidden');
            filename.textContent = file.name;
            
            // Add to uploaded files list
            uploadedFiles.push(file.name);
        } else {
            if (isRequired) {
                fileInfo.classList.add('hidden');
            }
            uploadedFiles = uploadedFiles.filter(name => name !== filename.textContent);
        }
    }

    function updateSummary() {
        const layananSelect = document.getElementById('layanan_id');
        const keterangan = document.getElementById('keterangan');
        
        // Update layanan
        const layananText = layananSelect.options[layananSelect.selectedIndex]?.text || '-';
        document.getElementById('summary-layanan').textContent = layananText;
        
        // Update keterangan
        document.getElementById('summary-keterangan').textContent = keterangan.value || '-';
        
        // Update dokumen list
        const dokumenList = document.getElementById('summary-dokumen');
        if (uploadedFiles.length > 0) {
            dokumenList.innerHTML = uploadedFiles.map(file => `<li>${file}</li>`).join('');
        } else {
            dokumenList.innerHTML = '<li class="text-gray-500">Belum ada dokumen</li>';
        }
    }

    // Add form validation before submit
    document.getElementById('wizardForm').addEventListener('submit', function(e) {
        // Validate required files
        const requiredInputs = document.querySelectorAll('input[type="file"][required]');
        let missingRequired = false;
        
        requiredInputs.forEach(input => {
            if (input.files.length === 0) {
                missingRequired = true;
                input.parentElement.parentElement.parentElement.parentElement.classList.add('border-red-500');
            }
        });
        
        if (missingRequired) {
            e.preventDefault();
            alert('Mohon lengkapi semua dokumen yang wajib diupload');
            prevStep(2);
            return false;
        }
    });
</script>
@endpush