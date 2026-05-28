<!DOCTYPE html>
<html lang="id" class="antialiased font-inter">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIAKAD Mini')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    <!-- Dark Mode Init Script (Mencegah FOUC) -->
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="bg-slate-50 dark:bg-slate-900 min-h-screen flex flex-col text-slate-800 dark:text-slate-200 transition-colors duration-300">
    {{-- Navbar --}}
    <nav class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200 dark:border-slate-700 shadow-sm transition-colors duration-300">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('mahasiswa.index') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-md shadow-emerald-500/30 group-hover:shadow-emerald-500/50 transition-all duration-300 transform group-hover:-translate-y-0.5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-600 to-teal-500 dark:from-emerald-400 dark:to-teal-300 tracking-tight">SIAKAD Mini</h1>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Campus Portal</p>
                </div>
            </a>
            <div class="flex items-center gap-6">
                <a href="{{ route('report.index') }}" class="hover:text-blue-200
transition {{ request()->routeIs('report.*') ? 'font-semibold' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('mahasiswa.index') }}"
                    class="font-medium transition-all duration-200 border-b-2 py-2 {{ request()->routeIs('mahasiswa.*') || request()->is('/') ? 'text-emerald-600 dark:text-emerald-400 border-emerald-500 dark:border-emerald-400' : 'text-slate-500 dark:text-slate-400 border-transparent hover:text-emerald-600 dark:hover:text-emerald-400 hover:border-emerald-200 dark:hover:border-emerald-800' }}">
                    Mahasiswa
                </a>
                <a href="{{ route('dosen.index') }}"
                    class="font-medium transition-all duration-200 border-b-2 py-2 {{ request()->routeIs('dosen.*') ? 'text-emerald-600 dark:text-emerald-400 border-emerald-500 dark:border-emerald-400' : 'text-slate-500 dark:text-slate-400 border-transparent hover:text-emerald-600 dark:hover:text-emerald-400 hover:border-emerald-200 dark:hover:border-emerald-800' }}">
                    Dosen
                </a>
                <a href="{{ route('mata-kuliah.index') }}"
                    class="font-medium transition-all duration-200 border-b-2 py-2 {{ request()->routeIs('mata-kuliah.*') ? 'text-emerald-600 dark:text-emerald-400 border-emerald-500 dark:border-emerald-400' : 'text-slate-500 dark:text-slate-400 border-transparent hover:text-emerald-600 dark:hover:text-emerald-400 hover:border-emerald-200 dark:hover:border-emerald-800' }}">
                    Mata Kuliah
                </a>

                <!-- Dark Mode Toggle Button -->
                <button id="theme-toggle" type="button" class="text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none rounded-lg text-sm p-2.5 transition-colors">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-grow max-w-6xl mx-auto px-4 py-8 w-full">
        {{-- Flash messages have been moved to SweetAlert Toast --}}

        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 mt-auto py-8 transition-colors duration-300">
        <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                &copy; {{ date('Y') }} SIAKAD Mini.
            </p>
            <p class="text-sm text-slate-400 dark:text-slate-500 flex items-center gap-1">
                Built with
                <svg class="w-4 h-4 text-red-400 dark:text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                </svg>
                Laravel & Tailwind CSS
            </p>
        </div>
    </footer>

    {{-- Session Data (Hidden) --}}
    @if(session('success'))
    <div id="flash-success" data-message="{{ session('success') }}" class="hidden"></div>
    @endif
    @if(session('error'))
    <div id="flash-error" data-message="{{ session('error') }}" class="hidden"></div>
    @endif

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // --- Dark Mode Toggle Logic ---
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Mengubah ikon berdasarkan tema aktif
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        const themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            // toggle icons
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // if set via local storage previously
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }

                // if NOT set via local storage previously
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });

        // --- SweetAlert Logic ---
        document.addEventListener('DOMContentLoaded', function() {
            // Global Delete Confirmation
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const itemName = this.getAttribute('data-name');
                    const isDark = document.documentElement.classList.contains('dark');

                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        html: `Yakin ingin menghapus data <strong>${itemName}</strong>?<br><span class="text-sm ${isDark ? 'text-slate-400' : 'text-gray-500'}">Tindakan ini tidak dapat dibatalkan!</span>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: isDark ? '#475569' : '#94a3b8',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        background: isDark ? '#1e293b' : '#ffffff',
                        color: isDark ? '#f8fafc' : '#0f172a',
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'rounded-lg px-6 py-2.5 font-medium shadow-md shadow-rose-500/20',
                            cancelButton: 'rounded-lg px-6 py-2.5 font-medium'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Menghapus...',
                                text: 'Mohon tunggu sebentar',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                background: isDark ? '#1e293b' : '#ffffff',
                                color: isDark ? '#f8fafc' : '#0f172a',
                                willOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            this.submit();
                        }
                    });
                });
            });

            // Konfigurasi SweetAlert Toast
            const isDark = document.documentElement.classList.contains('dark');
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: isDark ? '#1e293b' : '#ffffff',
                color: isDark ? '#f8fafc' : '#0f172a',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // Cek flash message dari elemen HTML tersembunyi
            const flashSuccess = document.getElementById('flash-success');
            if (flashSuccess) {
                Toast.fire({
                    icon: 'success',
                    title: flashSuccess.dataset.message
                });
            }

            const flashError = document.getElementById('flash-error');
            if (flashError) {
                Toast.fire({
                    icon: 'error',
                    title: flashError.dataset.message
                });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>