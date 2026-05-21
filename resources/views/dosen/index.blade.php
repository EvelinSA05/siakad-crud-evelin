@extends('layouts.app')
@section('title', 'Daftar Dosen')
@section('content')
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 p-8 transition-all duration-300">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Daftar Dosen</h1>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-2">
                Manajemen data dosen pengajar
            </p>
        </div>
        <a href="{{ route('dosen.create') }}"
            class="bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-medium px-5 py-2.5 rounded-lg shadow-md shadow-emerald-500/20 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Data</span>
        </a>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('dosen.index') }}" class="mb-8 p-4 bg-slate-50/50 dark:bg-slate-900/50 rounded-xl border border-slate-100 dark:border-slate-700 grid grid-cols-1 md:grid-cols-4 gap-4 transition-colors">
        <div class="md:col-span-2 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari NIDN atau nama..."
                class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-lg focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 outline-none placeholder-slate-400 dark:placeholder-slate-500">
        </div>
        <div class="relative">
            <select name="jabatan_fungsional" class="w-full px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-lg focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 outline-none appearance-none">
                <option value="">Semua Jabatan</option>
                <option value="Asisten Ahli" {{ request('jabatan_fungsional') == 'Asisten Ahli' ? 'selected' : '' }}>Asisten Ahli</option>
                <option value="Lektor" {{ request('jabatan_fungsional') == 'Lektor' ? 'selected' : '' }}>Lektor</option>
                <option value="Lektor Kepala" {{ request('jabatan_fungsional') == 'Lektor Kepala' ? 'selected' : '' }}>Lektor Kepala</option>
                <option value="Guru Besar" {{ request('jabatan_fungsional') == 'Guru Besar' ? 'selected' : '' }}>Guru Besar</option>
            </select>
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-emerald-100 dark:bg-emerald-900/50 hover:bg-emerald-200 dark:hover:bg-emerald-800 text-emerald-800 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 font-semibold px-4 py-2.5 rounded-lg transition-colors">
                Cari
            </button>
            @if(request()->hasAny(['search', 'jabatan_fungsional']))
            <a href="{{ route('dosen.index') }}" class="flex items-center justify-center bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 px-4 py-2.5 rounded-lg transition-colors" title="Reset Filter">
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
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Profil</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Jabatan Fungsional</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-slate-800 transition-colors">
                @forelse ($dosens as $index => $dosen)
                <tr class="hover:bg-emerald-50/30 dark:hover:bg-slate-700/50 transition-colors group">
                    <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                        {{ $dosens->firstItem() + $index }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            <img src="{{ $dosen->foto_url }}" alt="{{ $dosen->nama }}" class="w-12 h-12 rounded-full object-cover border-2 border-white dark:border-slate-700 shadow-sm group-hover:border-emerald-100 dark:group-hover:border-slate-600 transition-colors">
                            <div>
                                <div class="font-bold text-slate-800 dark:text-slate-200">{{ $dosen->nama }}</div>
                                <div class="text-sm text-slate-500 dark:text-slate-400 font-mono mt-0.5">{{ $dosen->nidn }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-bold bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600">
                            {{ $dosen->jabatan_fungsional }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('dosen.show', $dosen) }}" class="p-2 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-slate-700 rounded-lg transition-colors" title="Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <a href="{{ route('dosen.edit', $dosen) }}" class="p-2 text-amber-500 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-slate-700 rounded-lg transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('dosen.destroy', $dosen) }}" method="POST" class="inline delete-form" data-name="{{ $dosen->nama }}">
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
                    <td colspan="4" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center space-y-4">
                            <div class="w-20 h-20 bg-slate-50 dark:bg-slate-700/50 rounded-full flex items-center justify-center transition-colors">
                                <svg class="w-10 h-10 text-slate-300 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div class="text-slate-500 dark:text-slate-400">
                                <p class="text-lg font-medium text-slate-700 dark:text-slate-300">Belum ada data dosen</p>
                                <p class="text-sm mt-1">Mulai tambahkan data dosen baru ke dalam sistem.</p>
                            </div>
                            <a href="{{ route('dosen.create') }}" class="mt-2 text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 font-medium hover:underline flex items-center gap-1">
                                <span>Tambah Dosen Pertama</span>
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
    @if($dosens->hasPages())
    <div class="mt-6 dark:opacity-90">
        {{ $dosens->links() }}
    </div>
    @endif
</div>
@endsection
