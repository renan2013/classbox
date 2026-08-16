<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('modules')->latest()->paginate(15);
        $modules = Module::all();
        return view('admin.users.index', compact('users', 'modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'full_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:superadmin,admin',
            'modules' => 'nullable|array',
        ]);

        $user = User::create([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->filled('modules')) {
            $user->modules()->sync($request->modules);
        }

        return back()->with('success', 'Usuario administrador creado.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:50|unique:users,username,' . $id,
            'full_name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:superadmin,admin',
            'modules' => 'nullable|array',
        ]);

        $data = [
            'username' => $request->username,
            'full_name' => $request->full_name,
            'name' => $request->full_name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if ($request->has('modules')) {
            $user->modules()->sync($request->modules);
        }

        return back()->with('success', 'Usuario actualizado.');
    }

    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta actual.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Usuario eliminado.');
    }
}
