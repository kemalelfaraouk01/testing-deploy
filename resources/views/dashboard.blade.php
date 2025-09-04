<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex items-center justify-end space-x-2 sm:space-x-4">
                @role('Admin|Kepala Bidang')
                    {{-- Dropdown Notifikasi --}}
                @endrole
                <div class="flex items-center">
                    {{-- Dropdown User --}}
                </div>
            </div>
        </div>
    </x-slot>

    {{-- ========================================================== --}}
    {{-- BAGIAN BARU: Kartu Tugas Satyalancana (Mobile Optimized) --}}
    {{-- ========================================================== --}}
    @if ($tugasSatyalancana)
        <div class="mx-4 sm:mx-0 mb-4 sm:mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-3 sm:p-4 shadow-sm rounded-lg"
            role="alert">
            <div class="flex flex-col sm:flex-row sm:items-start space-y-3 sm:space-y-0">
                <div class="flex-1">
                    <p class="font-bold text-sm sm:text-base">Tugas untuk Anda: Melengkapi Berkas</p>
                    <p class="text-xs sm:text-sm mt-1">Anda telah diusulkan untuk menerima penghargaan Satyalancana
                        Karya Satya
                        {{ $tugasSatyalancana->masa_kerja }} Tahun. Harap segera melengkapi berkas administratif yang
                        diperlukan.</p>
                </div>
                <div class="sm:ml-4 sm:pl-3 flex-shrink-0">
                    <a href="{{ route('satyalancana.berkas.show', $tugasSatyalancana->id) }}"
                        class="inline-flex items-center justify-center w-full sm:w-auto px-3 sm:px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 transition-colors duration-200">
                        Lengkapi Sekarang
                    </a>
                </div>
            </div>
        </div>
    @endif

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Welcome Card --}}
            <div
                class="bg-gradient-to-r from-blue-500 to-purple-600 overflow-hidden shadow-lg rounded-xl mb-6 text-white">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <h3 class="text-base sm:text-lg font-medium">Selamat Datang Kembali!</h3>
                            <p class="text-lg sm:text-xl font-bold mt-1">{{ Auth::user()->name }}</p>
                            <p class="text-xs sm:text-sm text-blue-100 mt-2">Sistem Informasi Kepegawaian BKPSDM Kota
                                Bengkulu</p>
                        </div>
                        <div class="hidden sm:block">
                            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats Cards Grid --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
                {{-- Card Total Pegawai --}}
                <div
                    class="bg-white overflow-hidden shadow-md hover:shadow-lg rounded-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-3 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <div
                                class="bg-blue-500 p-2 sm:p-3 rounded-full text-white mb-2 sm:mb-0 sm:mr-4 self-center sm:self-auto">
                                <svg class="w-4 h-4 sm:w-6 sm:h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m-7.5-2.962a3.75 3.75 0 0 1 5.25 0m4.5 0a3.75 3.75 0 0 1 5.25 0M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15A2.25 2.25 0 0 0 2.25 6.75v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                </svg>
                            </div>
                            <div class="text-center sm:text-left">
                                <p class="text-xs sm:text-sm text-gray-500">Total Pegawai</p>
                                <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $totalPegawai }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Pegawai Cuti --}}
                <div
                    class="bg-white overflow-hidden shadow-md hover:shadow-lg rounded-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-3 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <div
                                class="bg-green-500 p-2 sm:p-3 rounded-full text-white mb-2 sm:mb-0 sm:mr-4 self-center sm:self-auto">
                                <svg class="w-4 h-4 sm:w-6 sm:h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                            </div>
                            <div class="text-center sm:text-left">
                                <p class="text-xs sm:text-sm text-gray-600">Pegawai Cuti</p>
                                <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $jumlahCuti }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Usulan Pangkat --}}
                <div
                    class="bg-white overflow-hidden shadow-md hover:shadow-lg rounded-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-3 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <div
                                class="bg-yellow-500 p-2 sm:p-3 rounded-full text-white mb-2 sm:mb-0 sm:mr-4 self-center sm:self-auto">
                                <svg class="w-4 h-4 sm:w-6 sm:h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m4.5 18.75 7.5-7.5 7.5 7.5" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m4.5 12.75 7.5-7.5 7.5 7.5" />
                                </svg>
                            </div>
                            <div class="text-center sm:text-left">
                                <p class="text-xs sm:text-sm text-gray-500">Usulan Pangkat</p>
                                <p class="text-lg sm:text-2xl font-bold text-gray-900">8</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Pengguna Online --}}
                <div
                    class="bg-white overflow-hidden shadow-md hover:shadow-lg rounded-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-3 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <div
                                class="bg-red-500 p-2 sm:p-3 rounded-full text-white mb-2 sm:mb-0 sm:mr-4 self-center sm:self-auto">
                                <svg class="w-4 h-4 sm:w-6 sm:h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </div>
                            <div class="text-center sm:text-left">
                                <p class="text-xs sm:text-sm text-gray-500">Pengguna Online</p>
                                <p class="text-lg sm:text-2xl font-bold text-gray-900">1</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================================== --}}
            {{-- BAGIAN CHARTS: Stack pada mobile, side-by-side pada desktop --}}
            {{-- ========================================================== --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-8">
                {{-- Grafik 1: Sebaran Golongan --}}
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl rounded-xl transition-all duration-300">
                    <div class="p-4 sm:p-6 text-gray-900">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm sm:text-lg font-medium">Sebaran Golongan</h3>
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        </div>
                        <div class="relative" style="height: 250px;">
                            <canvas id="golonganChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Grafik 2: Sebaran OPD --}}
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-xl rounded-xl transition-all duration-300">
                    <div class="p-4 sm:p-6 text-gray-900">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm sm:text-lg font-medium">Sebaran OPD</h3>
                            <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                        </div>
                        <div class="relative" style="height: 250px;">
                            <canvas id="opdChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mobile Quick Actions (tampil hanya di mobile) --}}
            <div class="mt-6 sm:hidden">
                <div class="bg-white rounded-xl shadow-lg p-4">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Aksi Cepat</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <button
                            class="flex flex-col items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <svg class="w-6 h-6 text-blue-600 mb-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="text-xs text-blue-600 font-medium">Tambah Data</span>
                        </button>
                        <button
                            class="flex flex-col items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <svg class="w-6 h-6 text-green-600 mb-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <span class="text-xs text-green-600 font-medium">Laporan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Fungsi untuk inisialisasi grafik dengan responsive settings
        function initializeCharts() {
            // --- Script untuk Grafik Golongan ---
            const chartLabels = @json($chartLabels ?? []);
            const chartData = @json($chartData ?? []);
            const golonganCtx = document.getElementById('golonganChart');

            if (golonganCtx && chartLabels.length > 0) {
                // Hancurkan chart yang sudah ada jika ada
                if (window.golonganChart instanceof Chart) {
                    window.golonganChart.destroy();
                }

                window.golonganChart = new Chart(golonganCtx, {
                    type: 'bar',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Jumlah Pegawai',
                            data: chartData,
                            backgroundColor: 'rgba(59, 130, 246, 0.8)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 2,
                            borderRadius: 6,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    fontSize: window.innerWidth < 640 ? 10 : 12
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.1)'
                                }
                            },
                            x: {
                                ticks: {
                                    fontSize: window.innerWidth < 640 ? 10 : 12,
                                    maxRotation: window.innerWidth < 640 ? 45 : 0
                                },
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: window.innerWidth >= 640,
                                position: 'top',
                                labels: {
                                    fontSize: window.innerWidth < 640 ? 10 : 12
                                }
                            },
                            title: {
                                display: false
                            }
                        },
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        }
                    }
                });
            }

            // --- Script untuk Grafik OPD (Doughnut) ---
            const opdChartLabels = @json($opdChartLabels ?? []);
            const opdChartData = @json($opdChartData ?? []);
            const opdLegendLabels = @json($opdLegendLabels ?? []); // Ambil data legenda Top 5
            const opdCtx = document.getElementById('opdChart');

            if (opdCtx && opdChartLabels.length > 0) {
                // Hancurkan chart yang sudah ada jika ada
                if (window.opdChart instanceof Chart) {
                    window.opdChart.destroy();
                }

                window.opdChart = new Chart(opdCtx, {
                    type: 'doughnut',
                    data: {
                        labels: opdChartLabels, // Data label tetap semua OPD
                        datasets: [{
                            label: 'Jumlah Pegawai',
                            data: opdChartData,
                            backgroundColor: [
                                'rgba(147, 51, 234, 0.8)',
                                'rgba(59, 130, 246, 0.8)',
                                'rgba(16, 185, 129, 0.8)',
                                'rgba(245, 158, 11, 0.8)',
                                'rgba(239, 68, 68, 0.8)',
                                'rgba(139, 92, 246, 0.8)',
                                'rgba(6, 182, 212, 0.8)'
                            ],
                            borderWidth: 3,
                            borderColor: '#ffffff',
                            hoverOffset: window.innerWidth < 640 ? 8 : 15
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: window.innerWidth < 640 ? '50%' : '60%',
                        plugins: {
                            legend: {
                                display: window.innerWidth >= 640,
                                position: window.innerWidth < 640 ? 'bottom' : 'right',
                                labels: {
                                    // === FUNGSI FILTER UNTUK LEGENDA ===
                                    filter: function(legendItem, chartData) {
                                        return opdLegendLabels.includes(legendItem.text);
                                    },
                                    // =====================================
                                    fontSize: window.innerWidth < 640 ? 10 : 12,
                                    padding: window.innerWidth < 640 ? 10 : 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.parsed;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        animation: {
                            animateRotate: true,
                            duration: 1500,
                            easing: 'easeInOutQuart'
                        }
                    }
                });
            }
        }

        // Event listeners untuk responsive behavior
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                initializeCharts();
            }, 250);
        });

        // Multiple event listeners untuk memastikan grafik ter-load
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initializeCharts, 100);
        });

        document.addEventListener('turbo:load', function() {
            setTimeout(initializeCharts, 100);
        });

        document.addEventListener('turbo:render', function() {
            setTimeout(initializeCharts, 100);
        });

        window.addEventListener('load', function() {
            setTimeout(initializeCharts, 200);
        });

        document.addEventListener('turbo:visit', function() {
            setTimeout(initializeCharts, 300);
        });

        // Touch gestures untuk mobile (optional enhancement)
        if ('ontouchstart' in window) {
            document.addEventListener('touchstart', function() {
                // Add any touch-specific behaviors here
            }, {
                passive: true
            });
        }
    </script>
</x-app-layout>
