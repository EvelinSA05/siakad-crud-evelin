@extends('layouts.app')
@section('title', 'Detail ' . $mahasiswa->nama)
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('mahasiswa.index') }}" class="inline-flex items-center text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 hover:underline text-sm font-medium transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke daftar
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 overflow-hidden transition-all duration-300">
        {{-- Cover Header with Profile Info --}}
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 dark:from-emerald-600 dark:to-teal-700 px-8 py-8">
            <div class="flex flex-col md:flex-row gap-6 md:items-center">
                <img src="{{ $mahasiswa->foto_url }}" alt="{{ $mahasiswa->nama }}"
                    class="w-32 h-32 rounded-xl object-cover ring-4 ring-white/30 dark:ring-slate-900/30 shadow-lg bg-white/10 backdrop-blur-sm">
                
                <div class="flex-1">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-white tracking-tight">{{ $mahasiswa->nama }}</h1>
                            <div class="flex items-center gap-3 mt-2 text-emerald-50">
                                <span class="font-mono bg-white/20 px-2.5 py-0.5 rounded-md border border-white/30 backdrop-blur-sm shadow-sm">{{ $mahasiswa->nim }}</span>
                                <span>&bull;</span>
                                <span class="font-medium">{{ $mahasiswa->prodi }} ({{ $mahasiswa->angkatan }})</span>
                            </div>
                        </div>
                        
                        <div>
                            @php
                            $statusStyle = [
                                'aktif' => 'bg-emerald-500 text-white border-emerald-600 shadow-emerald-500/30',
                                'cuti'  => 'bg-amber-500 text-white border-amber-600 shadow-amber-500/30',
                                'lulus' => 'bg-indigo-500 text-white border-indigo-600 shadow-indigo-500/30',
                                'do'    => 'bg-rose-500 text-white border-rose-600 shadow-rose-500/30',
                            ][$mahasiswa->status] ?? 'bg-slate-500 text-white border-slate-600 shadow-slate-500/30';
                            @endphp
                            <span class="px-4 py-1.5 text-sm font-bold rounded-full border shadow-md {{ $statusStyle }}">
                                {{ ucfirst($mahasiswa->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="px-8 pb-8 pt-8 relative">

            {{-- Info Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="bg-slate-50/80 dark:bg-slate-900/50 rounded-xl p-5 border border-slate-100 dark:border-slate-700 transition-colors">
                        <h3 class="text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-4">Informasi Kontak</h3>
                        <dl class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 text-slate-400 dark:text-slate-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-slate-500 dark:text-slate-400">Email</dt>
                                    <dd class="text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $mahasiswa->email }}</dd>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 text-slate-400 dark:text-slate-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-slate-500 dark:text-slate-400">Nomor HP</dt>
                                    <dd class="text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $mahasiswa->no_hp ?? '-' }}</dd>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 text-slate-400 dark:text-slate-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-slate-500 dark:text-slate-400">Alamat</dt>
                                    <dd class="text-sm font-medium text-slate-800 dark:text-slate-200 mt-0.5 leading-relaxed">{{ $mahasiswa->alamat ?? '-' }}</dd>
                                </div>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-slate-50/80 dark:bg-slate-900/50 rounded-xl p-5 border border-slate-100 dark:border-slate-700 transition-colors">
                        <h3 class="text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-4">Data Pribadi & Akademik</h3>
                        <dl class="grid grid-cols-2 gap-y-4 gap-x-4">
                            <div>
                                <dt class="text-xs font-medium text-slate-500 dark:text-slate-400">Jenis Kelamin</dt>
                                <dd class="text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $mahasiswa->jenis_kelamin_label }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-slate-500 dark:text-slate-400">Tanggal Lahir</dt>
                                <dd class="text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">
                                    {{ $mahasiswa->tanggal_lahir ? $mahasiswa->tanggal_lahir->format('d F Y') : '-' }}
                                </dd>
                            </div>
                            <div class="col-span-2 pt-2 border-t border-slate-200/60 dark:border-slate-700/60 mt-2">
                                <dt class="text-xs font-medium text-slate-500 dark:text-slate-400">Indeks Prestasi Kumulatif (IPK)</dt>
                                <dd class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-1 flex items-baseline gap-2">
                                    {{ number_format($mahasiswa->ipk, 2) }}
                                    <span class="text-xs text-slate-400 dark:text-slate-500 font-medium">/ 4.00</span>
                                </dd>
                            </div>
                            <div class="col-span-2">
                                <dt class="text-xs font-medium text-slate-500 dark:text-slate-400">Terdaftar Sejak</dt>
                                <dd class="text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $mahasiswa->created_at->format('d F Y') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="mt-10 pt-6 border-t border-slate-100 dark:border-slate-700 flex flex-wrap items-center justify-end gap-3 transition-colors">
                <form action="{{ route('mahasiswa.destroy', $mahasiswa) }}" method="POST" class="delete-form" data-name="{{ $mahasiswa->nama }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="this.closest('form').dispatchEvent(new Event('submit'))" class="flex items-center gap-2 bg-white dark:bg-slate-800 hover:bg-rose-50 dark:hover:bg-rose-900/30 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-900/50 font-medium px-5 py-2.5 rounded-lg shadow-sm transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus Data
                    </button>
                </form>
                <a href="{{ route('mahasiswa.edit', $mahasiswa) }}" class="flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-medium px-6 py-2.5 rounded-lg shadow-md shadow-amber-500/20 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Data
                </a>
            </div>
        </div>
    </div>
</div>
@endsection