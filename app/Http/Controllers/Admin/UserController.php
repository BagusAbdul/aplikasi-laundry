<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Outlet;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'outlet'])->latest()->paginate(10);
        $roles = Role::all();
        $outlets = Outlet::all();
        return view('admin.user.index', compact('users', 'roles', 'outlets'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        User::create($data);
        return redirect()->route('admin.user.index')->with('success', 'Pengguna berhasil dibuat!');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $outlets = Outlet::all();
        return view('admin.user.edit', compact('user', 'roles', 'outlets'));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();

        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('admin.user.index')->with('success', 'Data pengguna diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
