@extends('layouts.app')
@section('title', 'Daftar Mahasiswa')
@section('content')
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 p-8 transition-all duration-300">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Daftar Mahasiswa</h1>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-2">
                Manajemen data akademik mahasiswa secara real-time
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="document.getElementById('importModal').classList.remove('hidden')"
                class="bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 font-medium px-5 py-2.5 rounded-lg shadow-sm transition-all duration-200 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                <span>Import CSV</span>
            </button>
            <a href="{{ route('mahasiswa.export-csv', request()->all()) }}"
                class="bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 font-medium px-5 py-2.5 rounded-lg shadow-sm transition-all duration-200 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('mahasiswa.create') }}"
                class="bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-medium px-5 py-2.5 rounded-lg shadow-md shadow-emerald-500/20 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Tambah Data</span>
            </a>
        </div>
    </div>

    {{-- Pesan Error Import --}}
    @if(session('import_errors'))
    <div class="mb-8 p-4 bg-rose-50 dark:bg-rose-900/30 rounded-xl border border-rose-200 dark:border-rose-800 transition-colors">
        <h3 class="font-bold text-rose-800 dark:text-rose-400 mb-2">Terdapat Kesalahan Saat Import:</h3>
        <ul class="list-disc list-inside text-sm text-rose-700 dark:text-rose-400 space-y-1">
            @foreach(array_slice(session('import_errors'), 0, 10) as $err)
            <li>{{ $err }}</li>
            @endforeach
            @if(count(session('import_errors')) > 10)
            <li>...dan {{ count(session('import_errors')) - 10 }} kesalahan lainnya.</li>
            @endif
        </ul>
    </div>
    @endif

    {{-- Dashboard Statistik Mini --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        {{-- Card: Total Mahasiswa --}}
        <div class="bg-white dark:bg-slate-800/80 p-5 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm flex items-center gap-4 transition-colors">
            <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Mahasiswa</p>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mt-0.5">{{ number_format($totalMahasiswa ?? 0) }}</h3>
            </div>
        </div>

        {{-- Card: Mahasiswa Aktif --}}
        <div class="bg-white dark:bg-slate-800/80 p-5 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm flex items-center gap-4 transition-colors">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Status Aktif</p>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mt-0.5">{{ number_format($mahasiswaAktif ?? 0) }}</h3>
            </div>
        </div>

        {{-- Card: Rata-rata IPK --}}
        <div class="bg-white dark:bg-slate-800/80 p-5 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm flex items-center gap-4 transition-colors">
            <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-900/30 text-amber-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Rata-rata IPK</p>
                <h3 class="text-2xl font-bold text-slate-800 dark:text-white mt-0.5">{{ number_format($rataIpk ?? 0, 2) }}</h3>
            </div>
        </div>

        {{-- Card: Chart Prodi Mini --}}
        <div class="bg-white dark:bg-slate-800/80 p-3 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm flex items-center justify-center transition-colors">
            <div class="h-20 w-full relative">
                <canvas id="prodiChart" data-statistik="{{ json_encode($statistikProdi ?? []) }}"></canvas>
            </div>
        </div>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('mahasiswa.index') }}" class="mb-8 p-4 bg-slate-50/50 dark:bg-slate-900/50 rounded-xl border border-slate-100 dark:border-slate-700 grid grid-cols-1 md:grid-cols-4 gap-4 transition-colors">
        <div class="md:col-span-2 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari NIM, nama, atau email..."
                class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-lg focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 outline-none placeholder-slate-400 dark:placeholder-slate-500">
        </div>
        <div class="relative">
            <select name="prodi" class="w-full px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-lg focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 outline-none appearance-none">
                <option value="">Semua Prodi</option>
                <option value="Teknik Informatika" {{ request('prodi') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                <option value="Sistem Informasi" {{ request('prodi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                <option value="Manajemen" {{ request('prodi') == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                <option value="Akuntansi" {{ request('prodi') == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
            </select>
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-emerald-100 dark:bg-emerald-900/50 hover:bg-emerald-200 dark:hover:bg-emerald-800 text-emerald-800 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 font-semibold px-4 py-2.5 rounded-lg transition-colors">
                Cari
            </button>
            @if(request()->hasAny(['search', 'prodi', 'status']))
            <a href="{{ route('mahasiswa.index') }}" class="flex items-center justify-center bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 px-4 py-2.5 rounded-lg transition-colors" title="Reset Filter">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            </a>
            @endif
        </div>
    </form>

    {{-- Tabel --}}
    <div class="overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-700 transition-colors">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/80 dark:bg-slate-900/80 border-b border-slate-100 dark:border-slate-700 transition-colors">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">No</th>
                    @php
                        $sortable = [
                            'nama' => 'Profil',
                            'prodi' => 'Prodi',
                            'ipk' => 'IPK',
                            'status' => 'Status'
                        ];
                        $currentSort = request('sort');
                        $currentDir = request('direction', 'desc');
                    @endphp
                    @foreach($sortable as $col => $label)
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        @php
                            $newDir = ($currentSort === $col && $currentDir === 'asc') ? 'desc' : 'asc';
                            $icon = '';
                            if ($currentSort === $col) {
                                $icon = $currentDir === 'asc' ? '↑' : '↓';
                            }
                        @endphp
                        <a href="{{ request()->fullUrlWithQuery(['sort' => $col, 'direction' => $newDir]) }}" class="flex items-center gap-1 group">
                            {{ $label }}
                            <span class="text-emerald-500 font-bold {{ $icon ? 'opacity-100' : 'opacity-0 group-hover:opacity-30' }} transition-opacity">
                                {{ $icon ?: '↕' }}
                            </span>
                        </a>
                    </th>
                    @endforeach
                    <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-slate-800 transition-colors">
                @forelse ($mahasiswa as $index => $mhs)
                <tr class="hover:bg-emerald-50/30 dark:hover:bg-slate-700/50 transition-colors group">
                    <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                        {{ $mahasiswa->firstItem() + $index }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <img src="{{ $mhs->foto_url }}" alt="{{ $mhs->nama }}" class="w-12 h-12 rounded-full object-cover border-2 border-white dark:border-slate-700 shadow-sm group-hover:border-emerald-100 dark:group-hover:border-slate-600 transition-colors">
                            <div>
                                <div class="font-bold text-slate-800 dark:text-slate-200">{{ $mhs->nama }}</div>
                                <div class="text-sm text-slate-500 dark:text-slate-400 font-mono mt-0.5">{{ $mhs->nim }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-slate-700 dark:text-slate-300">{{ $mhs->prodi }}</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Angkatan {{ $mhs->angkatan }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-bold bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600">
                            {{ number_format($mhs->ipk, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                        $statusStyle = [
                            'aktif' => 'bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800',
                            'cuti'  => 'bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-800',
                            'lulus' => 'bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-400 border-indigo-200 dark:border-indigo-800',
                            'do'    => 'bg-rose-100 dark:bg-rose-900/50 text-rose-700 dark:text-rose-400 border-rose-200 dark:border-rose-800',
                        ][$mhs->status] ?? 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-700';
                        @endphp
                        <span class="px-3 py-1 text-xs font-bold rounded-full border {{ $statusStyle }}">
                            {{ ucfirst($mhs->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('mahasiswa.show', $mhs) }}" class="p-2 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-slate-700 rounded-lg transition-colors" title="Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <a href="{{ route('mahasiswa.edit', $mhs) }}" class="p-2 text-amber-500 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-slate-700 rounded-lg transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('mahasiswa.destroy', $mhs) }}" method="POST" class="inline delete-form" data-name="{{ $mhs->nama }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="this.closest('form').dispatchEvent(new Event('submit'))" class="p-2 text-rose-500 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-slate-700 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center space-y-4">
                            <div class="w-20 h-20 bg-slate-50 dark:bg-slate-700/50 rounded-full flex items-center justify-center transition-colors">
                                <svg class="w-10 h-10 text-slate-300 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div class="text-slate-500 dark:text-slate-400">
                                <p class="text-lg font-medium text-slate-700 dark:text-slate-300">Belum ada data mahasiswa</p>
                                <p class="text-sm mt-1">Mulai tambahkan data mahasiswa baru ke dalam sistem.</p>
                            </div>
                            <a href="{{ route('mahasiswa.create') }}" class="mt-2 text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 font-medium hover:underline flex items-center gap-1">
                                <span>Tambah Mahasiswa Pertama</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($mahasiswa->hasPages())
    <div class="mt-6 dark:opacity-90">
        {{ $mahasiswa->links() }}
    </div>
    @endif
</div>

{{-- Modal Import CSV --}}
<div id="importModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm overflow-y-auto w-full h-full flex items-center justify-center transition-opacity">
    <div class="bg-white dark:bg-slate-800 p-8 rounded-2xl shadow-xl w-full max-w-md border border-slate-100 dark:border-slate-700 relative">
        <button onclick="document.getElementById('importModal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-4">Import Data Mahasiswa</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Upload file CSV. Pastikan format kolom sesuai: NIM, Nama, Email, Jenis Kelamin (L/P), Tanggal Lahir (Y-m-d), Prodi, Angkatan, IPK, Status.</p>
        
        <form action="{{ route('mahasiswa.import-csv') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <input type="file" name="file_csv" required accept=".csv"
                    class="block w-full text-sm text-slate-500 dark:text-slate-400
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100
                    dark:file:bg-slate-700 dark:file:text-slate-300">
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-lg font-medium transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium shadow-sm transition-colors">Upload & Import</button>
            </div>
        </form>
    </div>
</div>

{{-- Script untuk Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('prodiChart');
        if (!ctx) return;

        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#cbd5e1' : '#64748b'; // slate-300 or slate-500
        
        // Parsing data dari dataset HTML (Bebas dari IDE Error)
        const rawData = JSON.parse(ctx.dataset.statistik || '{}');
        const labels = Object.keys(rawData).length > 0 ? Object.keys(rawData) : ['Belum ada data'];
        const data = Object.values(rawData).length > 0 ? Object.values(rawData) : [1];
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        '#10b981', // emerald-500
                        '#0ea5e9', // sky-500
                        '#f59e0b', // amber-500
                        '#6366f1', // indigo-500
                        '#ec4899', // pink-500
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: 0
                },
                plugins: {
                    legend: {
                        display: false // Sembunyikan legend agar muat di kotak kecil
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed + ' Mahasiswa';
                                }
                                return label;
                            }
                        }
                    }
                },
                cutout: '70%' // Ukuran lubang di tengah
            }
        });
    });
</script>
@endsection