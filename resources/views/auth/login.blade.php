<x-guest-layout>
    {{-- Card dengan backdrop blur effect --}}
    <div
<<<<<<< HEAD
        class="w-full max-w-md mx-4 sm:mx-auto animated-border rounded-2xl shadow-2xl transform transition-all duration-300 hover:shadow-3xl">
        <div class="bg-white/95 backdrop-blur-lg p-4 sm:p-6 rounded-2xl">
            {{-- Header Section --}}
            <div class="mb-6 text-center">
                {{-- Logo atau Icon --}}
                <div class="mb-4">
                    <a href="/" class="flex justify-center">
                        <img src="{{ asset('images/logo-bkpsdm.png') }}" alt="Logo Kantor"
                            class="w-16 h-16 sm:w-20 sm:h-20">
                    </a>
                </div>

                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-1">Selamat Datang</h2>
                <p class="text-gray-600">Masuk untuk melanjutkan ke <span
                        class="font-semibold text-blue-600">SIMPEG</span>
                </p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- NIP Input --}}
                <div class="space-y-1">
                    <x-input-label for="nip" value="Nomor Induk Pegawai (NIP)"
                        class="font-semibold text-gray-700 text-start" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <x-text-input id="nip"
                            class="block w-full pl-10 pr-4 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            type="text" name="nip" :value="old('nip')" required autofocus
                            placeholder="Masukkan NIP Anda" />
                    </div>
                    <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                </div>

                {{-- Password Input --}}
                <div class="space-y-1">
                    <x-input-label for="password" value="Password" class="font-semibold text-gray-700 text-start" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <x-text-input id="password"
                            class="block w-full pl-10 pr-4 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            type="password" name="password" required autocomplete="current-password"
                            placeholder="Masukkan Password" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- CAPTCHA Section --}}
                <div class="space-y-2">
                    <x-input-label for="captcha" value="Verifikasi Keamanan"
                        class="font-semibold text-gray-700" />

                    {{-- Captcha Container --}}
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                            {{-- Captcha Image --}}
                            <div class="flex-shrink-0 mx-auto sm:mx-0">
                                <div class="p-2 bg-white rounded-lg shadow-sm border border-gray-200">
                                    {!! captcha_img('flat') !!}
                                </div>
                            </div>

                            {{-- Captcha Input --}}
                            <div class="flex-1">
                                <x-text-input id="captcha"
                                    class="w-full py-2 px-4 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    type="text" name="captcha" required autocomplete="off"
                                    placeholder="Masukkan kode captcha..." />
                            </div>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('captcha')" class="mt-2" />
                </div>


                {{-- Submit Button --}}
                <div>
                    <button type="submit" id="login-button"
                        class="group relative w-full flex justify-center items-center py-2 px-4 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-lg active:scale-[0.98]">
                        <span id="button-text">
                            <svg class="w-5 h-5 mr-2 opacity-0 group-hover:opacity-100 transition-opacity inline-block"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            LOGIN
                        </span>
                        <span id="loading-spinner" class="hidden">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                    </button>
                </div>
            </form>

            {{-- Footer --}}
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500">
                    Sistem Informasi Manajemen Kepegawaian <br> <span class="font-semibold text-blue-600">BKPSDM KOTA
                        BENGKULU</span>
                </p>
            </div>
        </div>
        <script>
            const form = document.querySelector('form');
            const loginButton = document.getElementById('login-button');
            const buttonText = document.getElementById('button-text');
            const loadingSpinner = document.getElementById('loading-spinner');

            form.addEventListener('submit', function() {
                // Disable the button
                loginButton.disabled = true;

                // Hide the button text and show the spinner
                buttonText.classList.add('hidden');
                loadingSpinner.classList.remove('hidden');
            });
        </script>
=======
        class="w-full max-w-md mx-auto bg-white/90 backdrop-blur-sm border border-white/20 p-8 rounded-3xl shadow-2xl transform transition-all duration-300 hover:shadow-3xl">
        {{-- Header Section --}}
        <div class="mb-8 text-center">
            {{-- Logo atau Icon --}}
            <div class="mb-6">
                <a href="/" class="flex justify-center">
                    <img src="{{ asset('images/logo-bkpsdm.png') }}" alt="Logo Kantor" class="w-24 h-24">
                </a>
            </div>

            <h2 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang</h2>
            <p class="text-gray-600">Masuk untuk melanjutkan ke <span class="font-semibold text-blue-600">SIMPEG</span>
            </p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            {{-- NIP Input --}}
            <div class="space-y-2">
                <x-input-label for="nip" value="Nomor Induk Pegawai (NIP)"
                    class="font-semibold text-gray-700 text-start" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <x-text-input id="nip"
                        class="block w-full pl-10 pr-4 py-3 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        type="text" name="nip" :value="old('nip')" required autofocus
                        placeholder="Masukkan NIP Anda" />
                </div>
                <x-input-error :messages="$errors->get('nip')" class="mt-2" />
            </div>

            {{-- Password Input --}}
            <div class="space-y-2">
                <x-input-label for="password" value="Password" class="font-semibold text-gray-700 text-start" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <x-text-input id="password"
                        class="block w-full pl-10 pr-4 py-3 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                        type="password" name="password" required autocomplete="current-password"
                        placeholder="Masukkan Password" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- CAPTCHA Section --}}
            <div class="space-y-3">
                <x-input-label for="image_captcha" value="Verifikasi Keamanan" class="font-semibold text-gray-700" />
                <p class="text-sm text-gray-600">Ketik ulang teks pada gambar di bawah ini:</p>

                {{-- Captcha Container --}}
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        {{-- Captcha Image --}}
                        <div class="flex-shrink-0 mx-auto sm:mx-0">
                            <div class="p-3 bg-white rounded-lg shadow-sm border border-gray-200">
                                <img src="{{ asset('images/captcha/' . $captcha_image) }}" alt="Captcha Image"
                                    class="w-36 h-16 object-contain">
                            </div>
                        </div>

                        {{-- Captcha Input --}}
                        <div class="flex-1">
                            <x-text-input id="image_captcha"
                                class="w-full py-3 px-4 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                type="text" name="image_captcha" required autocomplete="off"
                                placeholder="Masukkan kode captcha..." />
                        </div>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('image_captcha')" class="mt-2" />
            </div>


            {{-- Submit Button --}}
            <div class="pt-2">
                <button type="submit"
                    class="group relative w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-lg active:scale-[0.98]">
                    <svg class="w-5 h-5 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    MASUK KE SISTEM
                </button>
            </div>
        </form>

        {{-- Footer --}}
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-500">
                Sistem Informasi Manajemen Kepegawaian
            </p>
        </div>
    </div>
>>>>>>> 82e007e84e5692e3a77758ea4a1d8379eb8fc049
</x-guest-layout>
