<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules;
use App\Models\Opd;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('nip', 'like', '%' . $searchTerm . '%');
            });
        }

        $users = $query->with('roles')->oldest()->paginate(10)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $opds = Opd::orderBy('nama_opd')->get();
        return view('users.create', compact('roles', 'opds'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => ['required', 'array'], // Pastikan validasinya adalah 'array'
            'opd_id' => ['nullable', 'exists:opds,id'],
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'opd_id' => $request->opd_id,
            'password' => Hash::make($request->password),
        ]);

        // Berikan peran ke user menggunakan syncRoles
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $opds = Opd::orderBy('nama_opd')->get();
        $userRoles = $user->roles->pluck('name')->all(); // Ambil peran yang dimiliki user
        return view('users.edit', compact('user', 'roles', 'opds', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:255', 'unique:' . User::class . ',nip,' . $user->id],
            'roles' => ['required', 'array'], // <-- UBAH INI: dari 'role' menjadi 'roles' dan tipenya 'array'
            'opd_id' => ['nullable', 'exists:opds,id'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'opd_id' => $request->opd_id,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // ▼▼▼ PASTIKAN MENGGUNAKAN syncRoles ▼▼▼
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (auth()->user()->id == $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
