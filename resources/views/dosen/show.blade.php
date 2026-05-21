@extends('layouts.app')
@section('title', 'Detail Dosen')
@section('content')
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 p-8 transition-all duration-300">
    <div class="mb-8 flex items-center justify-between">
        <a href="{{ route('dosen.index') }}" class="inline-flex items-center text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 hover:underline text-sm font-medium transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke daftar
        </a>
    </div>

    <div class="flex flex-col md:flex-row gap-8 items-start mb-8 pb-8 border-b border-slate-100 dark:border-slate-700">
        <img src="{{ $dosen->foto_url }}" alt="{{ $dosen->nama }}" class="w-32 h-32 rounded-2xl object-cover shadow-md">
        
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">{{ $dosen->nama }}</h1>
            <p class="text-slate-500 dark:text-slate-400 font-mono mt-1 mb-4">NIDN: {{ $dosen->nidn }}</p>
            
            <div class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-bold bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600">
                Jabatan Fungsional: {{ $dosen->jabatan_fungsional }}
            </div>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">Mata Kuliah yang Diampu</h2>
        
        <div class="overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-700 transition-colors">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 dark:bg-slate-900/80 border-b border-slate-100 dark:border-slate-700 transition-colors">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kode MK</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nama Mata Kuliah</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">SKS</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Prodi</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Semester</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700 bg-white dark:bg-slate-800 transition-colors">
                    @forelse ($dosen->mataKuliahs as $index => $mk)
                    <tr class="hover:bg-emerald-50/30 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-mono text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $mk->kode_mk }}</td>
                        <td class="px-6 py-4 font-bold text-slate-800 dark:text-slate-200">{{ $mk->nama_mk }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-1 rounded bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-bold">{{ $mk->sks }} SKS</span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $mk->prodi }}</td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">Semester {{ $mk->semester }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            Dosen ini belum mengampu mata kuliah apapun.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
