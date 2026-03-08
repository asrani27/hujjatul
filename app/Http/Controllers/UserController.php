<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of users with AJAX search.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query();

            // Search functionality
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('username', 'like', '%' . $search . '%')
                        ->orWhere('role', 'like', '%' . $search . '%');
                });
            }

            $users = $query->latest()->paginate(10);

            // Add edit_url to each user
            $users->getCollection()->transform(function ($user) {
                $user->edit_url = route('admin.users.edit', $user->id);
                return $user;
            });

            return response()->json([
                'users' => $users,
                'pagination' => $users->links('pagination::bootstrap-4')->toHtml()
            ]);
        }

        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'role' => 'required|in:ADMIN,MASYARAKAT,KEPALA_DESA',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        Session::flash('success', "User <b>{$user->name}</b> berhasil ditambahkan!");

        return response()->json([
            'success' => true,
            'message' => 'User created successfully!'
        ]);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'role' => 'required|in:ADMIN,MASYARAKAT,KEPALA_DESA',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->role = $request->role;

        if ($request->has('password') && $request->password != '') {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        Session::flash('success', "Data user <b>{$user->name}</b> berhasil diperbarui!");

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!'
        ]);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting the currently logged-in user
        if ($user->id === auth()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account!'
            ], 403);
        }

        $userName = $user->name;
        $user->delete();

        Session::flash('success', "User <b>{$userName}</b> berhasil dihapus!");

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully!'
        ]);
    }
}
