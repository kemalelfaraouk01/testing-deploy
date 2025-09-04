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
        // Daftar nama kota yang sesuai dengan nama file gambar Anda
        $captchaOptions = ['bengkulu', 'curup', 'manna', 'mukomuko', 'kepahiang'];

        // Pilih satu kota secara acak
        $selectedCaptcha = $captchaOptions[array_rand($captchaOptions)];

        // Simpan jawaban yang benar ke session
        session(['captcha_answer' => $selectedCaptcha]);

        // Kirim nama file gambar ke view
        return view('auth.login', ['captcha_image' => $selectedCaptcha . '.png']);
    }

    /**
     * Menangani permintaan autentikasi masuk.
     */
    // app/Http/Controllers/Auth/AuthenticatedSessionController.php

    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi semua input, termasuk CAPTCHA
        $request->validate([
            'nip' => ['required', 'string'],
            'password' => ['required', 'string'],
            'image_captcha' => ['required', 'string', function ($attribute, $value, $fail) {
                if (strtolower($value) !== session('captcha_answer')) {
                    $fail('Jawaban CAPTCHA tidak cocok.');
                }
            }],
        ]);

        // Setelah divalidasi, hapus jawaban dari session agar tidak bisa dipakai lagi
        $request->session()->forget('captcha_answer');

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
