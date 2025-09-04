<x-guest-layout>
    {{-- Ini adalah "Kartu" Form --}}
    <div class="w-full max-w-sm sm:max-w-md mx-auto bg-white p-4 sm:p-6 lg:p-8 rounded-2xl shadow-xl">
        <div class="mb-6 sm:mb-8 text-center">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Selamat Datang</h2>
            <p class="text-sm sm:text-base text-gray-500 mt-1">Masuk untuk melanjutkan ke SIMPEG</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-6">
            @csrf

            <div>
                <x-input-label for="nip" value="Nomor Induk Pegawai (NIP)"
                    class="font-semibold text-sm sm:text-base" />
                <x-text-input id="nip" class="block mt-1 sm:mt-2 w-full text-sm sm:text-base" type="text"
                    name="nip" :value="old('nip')" required autofocus />
                <x-input-error :messages="$errors->get('nip')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" value="Password" class="font-semibold text-sm sm:text-base" />
                <x-text-input id="password" class="block mt-1 sm:mt-2 w-full text-sm sm:text-base" type="password"
                    name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- ========================================================== --}}
            {{-- BAGIAN BARU: CAPTCHA KUSTOM --}}
            {{-- ========================================================== --}}
            <div class="mt-4">
                <x-input-label for="image_captcha" value="Ketik ulang teks pada gambar di bawah ini:"
                    class="text-sm sm:text-base" />

                {{-- Wadah Flexbox untuk menyejajarkan item - Mobile: Stack Vertical, Desktop: Horizontal --}}
                <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-4 mt-2 sm:mt-1">

                    {{-- Gambar di Atas (Mobile) / Kiri (Desktop) --}}
                    <div class="p-2 bg-gray-200 rounded-md flex-shrink-0 self-center sm:self-auto">
                        <img src="{{ asset('images/captcha/' . $captcha_image) }}" alt="Captcha Image"
                            class="w-32 h-16 sm:w-35 sm:h-20 object-contain">
                    </div>

                    {{-- Input di Bawah (Mobile) / Kanan (Desktop) --}}
                    <div class="w-full">
                        <x-text-input id="image_captcha" class="w-full text-sm sm:text-base" type="text"
                            name="image_captcha" required autocomplete="off" placeholder="Ketik Captcha..." />
                    </div>
                </div>

                <x-input-error :messages="$errors->get('image_captcha')" class="mt-2" />
            </div>

            <div class="block mt-4">
                {{-- ... kode "Remember Me" ... --}}
            </div>

            {{-- <div class="flex items-center justify-between text-sm">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                    <span class="ms-2 text-gray-600">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="underline text-gray-600 hover:text-blue-700" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div> --}}

            <div class="pt-2">
                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm sm:text-base font-medium text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                    MASUK
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
