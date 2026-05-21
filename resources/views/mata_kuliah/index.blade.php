@extends('layouts.app')
@section('title', 'Daftar Mata Kuliah')
@section('content')
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 p-8 transition-all duration-300">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Daftar Mata Kuliah</h1>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-2">
                Manajemen kurikulum dan jadwal mata kuliah
            </p>
        </div>
        <a href="{{ route('mata-kuliah.create') }}"
            class="bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-medium px-5 py-2.5 rounded-lg shadow-md shadow-emerald-500/20 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Data</span>
        </a>
    </div>

    {{-- Filter & Total SKS --}}
    <div class="bg-slate-50/50 dark:bg-slate-900/50 rounded-xl border border-slate-100 dark:border-slate-700 p-6 mb-8 transition-colors">
        <form method="GET" action="{{ route('mata-kuliah.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="relative">
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Filter Prodi</label>
                <select name="prodi" class="w-full px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 outline-none appearance-none">
                    <option value="">Semua Prodi</option>
                    @foreach(['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi'] as $pr)
                        <option value="{{ $pr }}" {{ request('prodi') == $pr ? 'selected' : '' }}>{{ $pr }}</option>
                    @endforeach
                </select>
            </div>
            <div class="relative">
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Filter Semester</label>
                <select name="semester" class="w-full px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 outline-none appearance-none">
                    <option value="">Semua Semester</option>
                    @for($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-emerald-100 dark:bg-emerald-900/50 hover:bg-emerald-200 dark:hover:bg-emerald-800 text-emerald-800 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 font-semibold px-6 py-2.5 rounded-lg transition-colors">
                    Terapkan
                </button>
                @if(request()->hasAny(['prodi', 'semester']))
                <a href="{{ route('mata-kuliah.index') }}" class="flex items-center justify-center bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 px-4 py-2.5 rounded-lg transition-colors" title="Reset Filter">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </a>
                @endif
            </div>
            
            <div class="md:col-span-1 text-right md:text-right mt-4 md:mt-0 bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-100 dark:border-slate-700 shadow-sm flex flex-col justify-center items-center md:items-end">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total SKS Difilter</span>
                <span class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 leading-none mt-1">{{ $totalSks ?? 0 }}</span>
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-700 transition-colors">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/80 dark:bg-slate-900/80 border-b border-slate-100 dark:border-slate-700 transition-colors">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kode MK</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Mata Kuliah</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">SKS</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Prodi / Semester</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Dosen Pengampu</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-slate-800 transition-colors">
                @forelse ($mata_kuliahs as $mk)
                <tr class="hover:bg-emerald-50/30 dark:hover:bg-slate-700/50 transition-colors group">
                    <td class="px-6 py-4">
                        <span class="font-mono text-sm font-semibold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded">{{ $mk->kode_mk }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800 dark:text-slate-200">{{ $mk->nama_mk }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-bold bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50">
                            {{ $mk->sks }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-slate-700 dark:text-slate-300">{{ $mk->prodi }}</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Semester {{ $mk->semester }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($mk->dosen)
                        <div class="flex items-center gap-3">
                            <img src="{{ $mk->dosen->foto_url }}" alt="{{ $mk->dosen->nama }}" class="w-8 h-8 rounded-full object-cover">
                            <div class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $mk->dosen->nama }}</div>
                        </div>
                        @else
                        <span class="text-xs text-slate-400 italic">Belum ditentukan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('mata-kuliah.edit', $mk) }}" class="p-2 text-amber-500 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-slate-700 rounded-lg transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('mata-kuliah.destroy', $mk) }}" method="POST" class="inline delete-form" data-name="{{ $mk->nama_mk }}">
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
                                <p class="text-lg font-medium text-slate-700 dark:text-slate-300">Belum ada data mata kuliah</p>
                            </div>
                            <a href="{{ route('mata-kuliah.create') }}" class="mt-2 text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 font-medium hover:underline flex items-center gap-1">
                                <span>Tambah Mata Kuliah Pertama</span>
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
    @if($mata_kuliahs->hasPages())
    <div class="mt-6 dark:opacity-90">
        {{ $mata_kuliahs->links() }}
    </div>
    @endif
</div>
@endsection
