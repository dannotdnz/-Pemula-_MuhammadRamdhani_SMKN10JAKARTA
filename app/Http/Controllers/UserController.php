<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan semua pengguna.
     */
    public function index()
    {
        $users = User::all();
        return view('home', compact('users'));
    }

    /**
     * Menampilkan formulir untuk membuat pengguna baru oleh admin.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Menyimpan pengguna baru yang dibuat oleh admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users',
            'password' => 'required|string',
            'role_id' => 'required|exists:roles,id',
            // Anda dapat menambahkan validasi lain sesuai kebutuhan
        ]);

        // Tambahkan pengguna baru ke dalam database
        $user = new User([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role_id' => $request->input('role_id'),
            // Anda dapat menambahkan atribut lain sesuai kebutuhan
        ]);

        $user->save();

        return redirect('/home')->with('status', 'Pengguna berhasil ditambahkan');
    }

    /**
     * Menampilkan informasi pengguna.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Menampilkan formulir untuk mengedit pengguna.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Menyimpan perubahan pada pengguna.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|unique:users,username,' . $id,
            // Anda dapat menambahkan validasi lain sesuai kebutuhan
        ]);

        $user->update($request->all());

        return redirect('/home')->with('status', 'Pengguna berhasil diperbarui');
    }

    /**
     * Menghapus pengguna.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect('/home')->with('status', 'Pengguna berhasil dihapus');
    }
}
