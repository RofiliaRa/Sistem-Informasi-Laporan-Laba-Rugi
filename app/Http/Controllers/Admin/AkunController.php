<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AkunController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        if (Auth::user()->role === 'admin') {

            $users = User::orderBy('role')
                ->orderBy('name')
                ->paginate(5);

        } else {

            $users = User::where('id', Auth::id())
                ->paginate(5);

        }

        return view('admin.akun.index', compact('users'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        // Direktur tidak boleh menambah akun
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required',

            'email' => 'required|email|unique:users',

            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).+$/'
            ],

            'role' => 'required|in:admin,direktur'

        ], [

            'password.confirmed' =>
                'Konfirmasi password tidak sesuai.',

            'password.min' =>
                'Password minimal 8 karakter.',

            'password.regex' =>
                'Password harus mengandung huruf, angka dan simbol.'

        ]);

        User::create([

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make($request->password),

            'role' => $request->role,

        ]);

        return back()->with(
            'success',
            'Akun berhasil ditambahkan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, User $akun)
    {
        // Direktur hanya boleh mengubah akun miliknya sendiri
        if (
            Auth::user()->role === 'direktur' &&
            $akun->id != Auth::id()
        ) {
            abort(403);
        }

        $rules = [

            'name' => 'required',

            'email' => 'required|email|unique:users,email,' . $akun->id,

            'password' => [
                'nullable',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).+$/'
            ]

        ];

        // Hanya admin yang boleh mengubah role
        if (Auth::user()->role === 'admin') {

            $rules['role'] = 'required|in:admin,direktur';

        }

        $request->validate($rules, [

            'password.confirmed' =>
                'Konfirmasi password tidak sesuai.',

            'password.min' =>
                'Password minimal 8 karakter.',

            'password.regex' =>
                'Password harus mengandung huruf, angka dan simbol.'

        ]);

        $data = [

            'name' => $request->name,

            'email' => $request->email,

        ];

        // Hanya admin yang boleh mengubah role
        if (Auth::user()->role === 'admin') {

            $data['role'] = $request->role;

        }

        if ($request->filled('password')) {

            $data['password'] = Hash::make($request->password);

        }

        $akun->update($data);

        return back()->with(
            'success',
            'Akun berhasil diperbarui'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(User $akun)
    {
        // Direktur tidak boleh menghapus akun
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        if ($akun->id == Auth::id()) {

            return back()->with(
                'error',
                'Anda tidak dapat menghapus akun yang sedang digunakan.'
            );

        }

        $akun->delete();

        return back()->with(
            'success',
            'Akun berhasil dihapus.'
        );
    }
}