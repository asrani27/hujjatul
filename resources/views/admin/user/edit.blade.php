@extends('layouts.app')

@section('title', 'Edit User - Hujjatul')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
    </div>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form id="editUserForm" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ $user->name }}" required
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter full name">
                <span class="text-red-500 text-sm" id="nameError"></span>
            </div>

            <!-- Username Field -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    Username <span class="text-red-500">*</span>
                </label>
                <input type="text" id="username" name="username" value="{{ $user->username }}" required
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter username">
                <span class="text-red-500 text-sm" id="usernameError"></span>
            </div>

            <!-- Role Field -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                    Role <span class="text-red-500">*</span>
                </label>
                <select id="role" name="role" required
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Select Role</option>
                    <option value="ADMIN" {{ $user->role === 'ADMIN' ? 'selected' : '' }}>Admin</option>
                    <option value="MASYARAKAT" {{ $user->role === 'MASYARAKAT' ? 'selected' : '' }}>Masyarakat</option>
                    <option value="KEPALA_DESA" {{ $user->role === 'KEPALA_DESA' ? 'selected' : '' }}>Kepala Desa
                    </option>
                </select>
                <span class="text-red-500 text-sm" id="roleError"></span>
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password <span class="text-gray-500 text-sm">(Leave blank to keep current)</span>
                </label>
                <input type="password" id="password" name="password"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter new password (minimum 6 characters)">
                <span class="text-red-500 text-sm" id="passwordError"></span>
            </div>

            <!-- Password Confirmation Field -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirm Password
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Confirm new password">
            </div>

            <!-- Submit Button -->
            <div class="flex gap-4">
                <button type="submit" id="submitBtn"
                    class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span id="btnText">Update User</span>
                    <svg id="btnSpinner" class="hidden animate-spin h-5 w-5 text-white mx-auto" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-3 px-6 rounded-lg transition duration-200 text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
waitForJQuery(function($) {
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        $('.text-red-500').text('');
        
        // Show loading state
        $('#submitBtn').prop('disabled', true);
        $('#btnText').addClass('hidden');
        $('#btnSpinner').removeClass('hidden');
        
        $.ajax({
            url: '{{ route("admin.users.update", $user->id) }}',
            method: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    window.location.href = '{{ route("admin.users.index") }}';
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                
                if (errors.name) {
                    $('#nameError').text(errors.name[0]);
                }
                if (errors.username) {
                    $('#usernameError').text(errors.username[0]);
                }
                if (errors.role) {
                    $('#roleError').text(errors.role[0]);
                }
                if (errors.password) {
                    $('#passwordError').text(errors.password[0]);
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