<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    // Fetch users for DataTables
    public function getUsersData(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select(['id', 'name', 'email', 'role', 'created_at']);

            return DataTables::of($users)
                ->addColumn('actions', function ($user) {
                    return '
                        <button class="edit-btn bg-blue text-black px-2 py-1 rounded" data-id="' . $user->id . '">Edit</button>
                        <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded" data-id="' . $user->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    // Fetch user details for editing
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Update user details
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'role' => 'required|in:admin,user'
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ]);

        return response()->json(['message' => 'User updated successfully']);
    }

    // Delete user
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully!']);
    }
}
