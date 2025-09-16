<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Rules\ValidCityCaptcha;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Menangani permintaan autentikasi masuk.
     */
    // app/Http/Controllers/Auth/AuthenticatedSessionController.php

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nip' => ['required', 'string'],
            'password' => ['required', 'string'],
            'captcha' => ['required', 'captcha'],
        ]);

        // 2. Logika Rate Limiter (tidak berubah)
        $throttleKey = Str::lower($request->input('nip')) . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 4)) { // Batas 4x percobaan
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'nip' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik atau hubungi Admin.",
            ]);
        }

        // ==========================================================
        // BAGIAN YANG DISESUAIKAN: Ambil HANYA kredensial yang dibutuhkan
        // ==========================================================
        $credentials = $request->only('nip', 'password');

        // 3. Coba login HANYA dengan kredensial tersebut
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Jika berhasil, bersihkan hitungan percobaan
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard', absolute: false))
                ->with('success', 'Anda berhasil login!');
        }

        // 4. Jika login gagal
        RateLimiter::hit($throttleKey);
        throw ValidationException::withMessages([
            'nip' => 'NIP atau Password yang Anda masukkan tidak sesuai.',
        ]);
    }

    /**
     * Menghancurkan sesi terautentikasi (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
