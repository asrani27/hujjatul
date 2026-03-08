@extends('layouts.app')

@section('title', 'Manajemen Pengajuan - Hujjatul')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Pengajuan</h1>
        <a href="{{ route('admin.pengajuans.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Buat Pengajuan
        </a>
    </div>
</div>

<!-- Search and Filter -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="relative">
            <input type="text" id="search"
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Cari berdasarkan nomor, penduduk, atau layanan...">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
        <div>
            <select id="statusFilter" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="all">Semua Status</option>
                <option value="menunggu">Menunggu</option>
                <option value="diproses">Diproses</option>
                <option value="selesai">Selesai</option>
                <option value="ditolak">Ditolak</option>
            </select>
        </div>
        <div></div>
    </div>
</div>

<!-- Pengajuans Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penduduk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="pengajuansTableBody" class="bg-white divide-y divide-gray-200">
                <!-- Pengajuans will be loaded here via AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div id="pagination" class="px-6 py-4 border-t border-gray-200">
        <!-- Pagination will be loaded here -->
    </div>
</div>

<!-- Loading Spinner -->
<div id="loading" class="hidden flex justify-center items-center py-8">
    <svg class="animate-spin h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
        </path>
    </svg>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 backdrop-blur-sm bg-white/30 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Pengajuan</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus pengajuan ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="flex justify-center gap-3 mt-4">
                <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">Batal</button>
                <button type="button" onclick="confirmDelete()"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    let deletePengajuanId = null;

    // Load pengajuans on page load
    waitForJQuery(function($) {
        loadPengajuans();

        // Search functionality with debounce
        let searchTimeout;
        $('#search').on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                loadPengajuans();
            }, 500);
        });

        // Status filter change
        $('#statusFilter').on('change', function() {
            loadPengajuans();
        });
    });

    function loadPengajuans(page = 1, isPagination = false) {
        // Get pagination element position before making changes
        let paginationElement = $('#pagination')[0];
        let scrollPos = isPagination && paginationElement ? paginationElement.getBoundingClientRect().top + window.scrollY - 50 : 0;
        
        $('#loading').removeClass('hidden');
        
        let searchValue = $('#search').val();
        let statusFilter = $('#statusFilter').val();
        
        $.ajax({
            url: '{{ route("admin.pengajuans.index") }}',
            method: 'GET',
            data: {
                search: searchValue,
                status: statusFilter,
                page: page
            },
            success: function(response) {
                displayPengajuans(response.pengajuans.data, response.pengajuans.current_page);
                $('#pagination').html(response.pagination);
                $('#loading').addClass('hidden');
                
                // Scroll to pagination area after content is loaded
                if (isPagination) {
                    setTimeout(function() {
                        window.scrollTo({
                            top: scrollPos,
                            behavior: 'auto'
                        });
                    }, 10);
                }
                
                // Re-attach click events to pagination links
                $('#pagination a').off('click').on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    let href = $(this).attr('href');
                    let pageParam = new URLSearchParams(href.split('?')[1]);
                    let page = pageParam.get('page');
                    loadPengajuans(page, true);
                });
            },
            error: function(xhr) {
                console.error('Error loading pengajuans:', xhr);
                $('#loading').addClass('hidden');
            }
        });
    }

    function displayPengajuans(pengajuans, currentPage = 1) {
        let html = '';
        let perPage = 10;
        
        if (pengajuans.length === 0) {
            html = `
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data pengajuan ditemukan
                    </td>
                </tr>
            `;
        } else {
            pengajuans.forEach(function(pengajuan, index) {
                let number = ((currentPage - 1) * perPage) + index + 1;
                
                html += `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">${number}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">${pengajuan.nomor}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">${pengajuan.penduduk_nama}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">${pengajuan.layanan_nama}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">${pengajuan.tanggal}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            ${pengajuan.status_badge}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <a href="${pengajuan.show_url}" class="text-green-600 hover:text-green-900" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="${pengajuan.edit_url}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button onclick="openDeleteModal(${pengajuan.id})" class="text-red-600 hover:text-red-900" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        }
        
        $('#pengajuansTableBody').html(html);
    }

    function openDeleteModal(pengajuanId) {
        deletePengajuanId = pengajuanId;
        $('#deleteModal').removeClass('hidden');
    }

    function closeDeleteModal() {
        deletePengajuanId = null;
        $('#deleteModal').addClass('hidden');
    }

    function confirmDelete() {
        if (deletePengajuanId) {
            $.ajax({
                url: `/admin/pengajuans/${deletePengajuanId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        closeDeleteModal();
                        location.reload();
                    }
                },
                error: function(xhr) {
                    console.error('Error deleting pengajuan:', xhr);
                    closeDeleteModal();
                }
            });
        }
    }
</script>
@endsection