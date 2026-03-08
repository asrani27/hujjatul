@extends('layouts.app')

@section('title', 'Manajemen Penduduk - Hujjatul')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Penduduk</h1>
        <a href="{{ route('admin.penduduks.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Penduduk
        </a>
    </div>
</div>

<!-- Search Box -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="relative">
        <input type="text" id="search"
            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            placeholder="Cari berdasarkan NIK, nama, alamat, atau desa...">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>
</div>

<!-- Penduduks Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                        Lengkap
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis
                        Kelamin
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Desa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. HP
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                    </th>
                </tr>
            </thead>
            <tbody id="penduduksTableBody" class="bg-white divide-y divide-gray-200">
                <!-- Penduduks will be loaded here via AJAX -->
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
            <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Penduduk</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus data penduduk ini? Tindakan ini tidak
                    dapat dibatalkan.</p>
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
    let deletePendudukId = null;

    // Load penduduks on page load
    waitForJQuery(function($) {
        loadPenduduks();

        // Search functionality with debounce
        let searchTimeout;
        $('#search').on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                loadPenduduks();
            }, 500);
        });
    });

    function loadPenduduks(page = 1, isPagination = false) {
        // Get pagination element position before making changes
        let paginationElement = $('#pagination')[0];
        let scrollPos = isPagination && paginationElement ? paginationElement.getBoundingClientRect().top + window.scrollY - 50 : 0;
        
        $('#loading').removeClass('hidden');
        
        let searchValue = $('#search').val();
        
        $.ajax({
            url: '{{ route("admin.penduduks.index") }}',
            method: 'GET',
            data: {
                search: searchValue,
                page: page
            },
            success: function(response) {
                // Update content
                displayPenduduks(response.penduduks.data, response.penduduks.current_page);
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
                    loadPenduduks(page, true);
                });
            },
            error: function(xhr) {
                console.error('Error loading penduduks:', xhr);
                $('#loading').addClass('hidden');
            }
        });
    }
    

    function displayPenduduks(penduduks, currentPage = 1) {
        let html = '';
        let perPage = 10;
        
        if (penduduks.length === 0) {
            html = `
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data penduduk ditemukan
                    </td>
                </tr>
            `;
        } else {
            penduduks.forEach(function(penduduk, index) {
                let jkBadge = penduduk.jenis_kelamin === 'Laki-laki' 
                    ? '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Laki-laki</span>'
                    : '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-pink-100 text-pink-800">Perempuan</span>';
                
                let number = ((currentPage - 1) * perPage) + index + 1;
                
                // Check if penduduk has user
                let hasUser = penduduk.user !== null;
                
                html += `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">${number}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-mono text-gray-900">${penduduk.nik}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">${penduduk.nama_lengkap}</div>
                            <div class="text-sm text-gray-500">${penduduk.tempat_lahir}, ${penduduk.tanggal_lahir_indo}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            ${jkBadge}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">${penduduk.desa}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">${penduduk.no_hp}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <a href="${penduduk.edit_url}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                ${hasUser 
                                    ? `<button onclick="resetPassword(${penduduk.id})" class="text-yellow-600 hover:text-yellow-900" title="Reset Password">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                        </svg>
                                       </button>`
                                    : `<button onclick="createUser(${penduduk.id})" class="text-green-600 hover:text-green-900" title="Buat Akun">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                        </svg>
                                       </button>`
                                }
                                <button onclick="openDeleteModal(${penduduk.id})" class="text-red-600 hover:text-red-900" title="Hapus">
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
        
        $('#penduduksTableBody').html(html);
    }

    function openDeleteModal(pendudukId) {
        deletePendudukId = pendudukId;
        $('#deleteModal').removeClass('hidden');
    }

    function closeDeleteModal() {
        deletePendudukId = null;
        $('#deleteModal').addClass('hidden');
    }

    function confirmDelete() {
        if (deletePendudukId) {
            $.ajax({
                url: `/admin/penduduks/${deletePendudukId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        closeDeleteModal();
                        location.reload(); // Reload page to show flash notification
                    }
                },
                error: function(xhr) {
                    console.error('Error deleting penduduk:', xhr);
                    closeDeleteModal();
                }
            });
        }
    }

    function createUser(pendudukId) {
        if (confirm('Apakah Anda yakin ingin membuat akun user untuk penduduk ini? Username akan menggunakan NIK dan password "masyarakat"')) {
            $.ajax({
                url: `/admin/penduduks/${pendudukId}/create-user`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload(); // Reload page to show flash notification
                    } else {
                        alert(response.message || 'Gagal membuat user');
                    }
                },
                error: function(xhr) {
                    console.error('Error creating user:', xhr);
                    let message = xhr.responseJSON?.message || 'Gagal membuat user';
                    alert(message);
                }
            });
        }
    }

    function resetPassword(pendudukId) {
        if (confirm('Apakah Anda yakin ingin me-reset password penduduk ini menjadi "masyarakat"?')) {
            $.ajax({
                url: `/admin/penduduks/${pendudukId}/reset-password`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload(); // Reload page to show flash notification
                    } else {
                        alert(response.message || 'Gagal me-reset password');
                    }
                },
                error: function(xhr) {
                    console.error('Error resetting password:', xhr);
                    let message = xhr.responseJSON?.message || 'Gagal me-reset password';
                    alert(message);
                }
            });
        }
    }
</script>
@endsection
