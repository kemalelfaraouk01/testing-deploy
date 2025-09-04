<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // Versi SETELAH diubah
    public function store(Request $request): RedirectResponse
    {
        // 1. Ubah validasi
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:255', 'unique:' . User::class], // Ganti 'email' menjadi 'nip'
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Ubah proses pembuatan user
        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip, // Ganti 'email' menjadi 'nip'
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
