@extends('layouts.app')

@section('title', 'Detail Pengajuan - Hujjatul')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Detail Pengajuan</h1>
        <a href="{{ route('admin.pengajuans.index') }}"
            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>
</div>

<!-- Pengajuan Info -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Pengajuan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Nomor</p>
                <p class="text-lg font-medium text-gray-900">{{ $pengajuan->nomor }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status Saat Ini</p>
                <div class="mt-1">
                    @php
                        $statusBadges = [
                            'menunggu' => '<span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>',
                            'diproses' => '<span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">Diproses</span>',
                            'selesai' => '<span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>',
                            'ditolak' => '<span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>',
                        ];
                        echo $statusBadges[$pengajuan->status] ?? '<span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">' . $pengajuan->status . '</span>';
                    @endphp
                </div>
            </div>
        </div>
    </div>
    
    <div class="border-t pt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pengajuan an. {{ $pengajuan->penduduk->nama_lengkap }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="text-md font-medium text-gray-700 mb-3">Data Penduduk</h4>
                <div class="space-y-2">
                    <div class="flex">
                        <span class="w-32 text-sm text-gray-500">NIK:</span>
                        <span class="text-sm text-gray-900">{{ $pengajuan->penduduk->nik }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-sm text-gray-500">Nama Lengkap:</span>
                        <span class="text-sm text-gray-900">{{ $pengajuan->penduduk->nama_lengkap }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-sm text-gray-500">Alamat:</span>
                        <span class="text-sm text-gray-900">{{ $pengajuan->penduduk->alamat }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-sm text-gray-500">Desa:</span>
                        <span class="text-sm text-gray-900">{{ $pengajuan->penduduk->desa }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-sm text-gray-500">No. HP:</span>
                        <span class="text-sm text-gray-900">{{ $pengajuan->penduduk->no_hp }}</span>
                    </div>
                </div>
            </div>
            
            <div>
                <h4 class="text-md font-medium text-gray-700 mb-3">Data Layanan</h4>
                <div class="space-y-2">
                    <div class="flex">
                        <span class="w-32 text-sm text-gray-500">Layanan:</span>
                        <span class="text-sm text-gray-900">{{ $pengajuan->layanan->nama }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-sm text-gray-500">Tanggal:</span>
                        <span class="text-sm text-gray-900">{{ $pengajuan->tanggal_indo }}</span>
                    </div>
                    <div class="flex">
                        <span class="w-32 text-sm text-gray-500">Keterangan:</span>
                        <span class="text-sm text-gray-900">{{ $pengajuan->keterangan ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Documents -->
@if($pengajuan->dokumen->count() > 0)
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Dokumen Persyaratan</h2>
    
    <div class="space-y-3">
        @foreach($pengajuan->dokumen as $dokumen)
        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0">
                            @if($dokumen->mime_type && str_starts_with($dokumen->mime_type, 'image'))
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            @elseif($dokumen->mime_type && str_starts_with($dokumen->mime_type, 'application/pdf'))
                                <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                </svg>
                            @else
                                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                {{ $dokumen->nama_file }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $dokumen->persyaratan->nama_dokumen ?? 'Dokumen' }}
                            </p>
                        </div>
                    </div>
                    <div class="ml-11 mt-2">
                        <span class="text-xs text-gray-400">
                            {{ $dokumen->ukuran_file_format }} 
                            • 
                            {{ $dokumen->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.pengajuans.downloadDokumen', $dokumen) }}"
                       class="inline-flex items-center gap-1 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                            </path>
                        </svg>
                        Download
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Status History -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Riwayat Status</h2>
    
    <div class="relative">
        <!-- Timeline line -->
        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
        
        @forelse($pengajuan->statusHistories as $index => $history)
            <div class="relative pl-10 pb-6 @if($loop->last) pb-0 @endif">
                <!-- Timeline dot -->
                <div class="absolute left-2.5 top-1 w-3 h-3 rounded-full
                    @if($history->status === 'menunggu') bg-yellow-500
                    @elseif($history->status === 'diproses') bg-blue-500
                    @elseif($history->status === 'selesai') bg-green-500
                    @elseif($history->status === 'ditolak') bg-red-500
                    @else bg-gray-500 @endif
                    ring-4 ring-white"></div>
                
                <!-- Status badge -->
                <div class="mb-2">
                    @php
                        $statusBadges = [
                            'menunggu' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>',
                            'diproses' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Diproses</span>',
                            'selesai' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>',
                            'ditolak' => '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>',
                        ];
                        echo $statusBadges[$history->status] ?? '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">' . $history->status . '</span>';
                    @endphp
                </div>
                
                <!-- Date and time -->
                <div class="text-sm text-gray-500 mb-1">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $history->created_at_indo }}
                </div>
                
                <!-- Note -->
                @if($history->catatan)
                <div class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg mt-2">
                    {{ $history->catatan }}
                </div>
                @endif
                
                <!-- User who changed the status -->
                @if($history->user)
                <div class="text-xs text-gray-400 mt-1">
                    Oleh: {{ $history->user->name }}
                </div>
                @endif
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p>Belum ada riwayat status</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Update Status Form -->
@if($pengajuan->status !== 'selesai' && $pengajuan->status !== 'ditolak')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Update Status</h2>
    
    <form id="updateStatusForm">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                <select id="status" name="status" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Pilih Status</option>
                    <option value="menunggu" @if($pengajuan->status === 'menunggu') selected @endif>Menunggu</option>
                    <option value="diproses" @if($pengajuan->status === 'diproses') selected @endif>Diproses</option>
                    <option value="selesai">Selesai</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
            
            <div>
                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                <input type="text" id="catatan" name="catatan"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Tambahkan catatan...">
            </div>
        </div>
        
        <div class="mt-4">
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition duration-200">
                Update Status
            </button>
        </div>
    </form>
</div>
@endif

<script>
    // Handle status update form submission
    $('#updateStatusForm').on('submit', function(e) {
        e.preventDefault();
        
        let status = $('#status').val();
        let catatan = $('#catatan').val();
        
        if (!status) {
            alert('Silakan pilih status baru');
            return;
        }
        
        $.ajax({
            url: '{{ route('admin.pengajuans.updateStatus', $pengajuan->id) }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: status,
                catatan: catatan
            },
            success: function(response) {
                if (response.success) {
                    alert('Status berhasil diperbarui');
                    location.reload();
                }
            },
            error: function(xhr) {
                console.error('Error updating status:', xhr);
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    alert(xhr.responseJSON.message);
                } else {
                    alert('Gagal memperbarui status');
                }
            }
        });
    });
</script>
@endsection