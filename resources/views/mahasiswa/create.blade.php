@extends('layouts.app')
@section('title', 'Tambah Mahasiswa')
@section('content')
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 p-8 max-w-3xl mx-auto transition-all duration-300">
    <div class="mb-8">
        <a href="{{ route('mahasiswa.index') }}" class="inline-flex items-center text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 hover:underline text-sm font-medium transition-colors mb-4">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke daftar
        </a>
        <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Tambah Mahasiswa</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-2">Lengkapi formulir di bawah untuk menambahkan data mahasiswa baru.</p>
    </div>

    @if ($errors->any())
    <div class="mb-6 bg-red-50 dark:bg-rose-900/30 border-l-4 border-red-500 dark:border-rose-500 p-4 rounded-r-lg transition-colors">
        <div class="flex items-center mb-2">
            <svg class="w-5 h-5 text-red-500 dark:text-rose-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            <p class="font-semibold text-red-800 dark:text-rose-400">Terdapat kesalahan pengisian:</p>
        </div>
        <ul class="list-disc list-inside text-sm text-red-700 dark:text-rose-400 space-y-1 ml-2">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="bg-slate-50/50 dark:bg-slate-900/50 rounded-xl p-6 border border-slate-100 dark:border-slate-700 space-y-5 transition-colors">
            @include('form')
        </div>

        <div class="flex items-center gap-4 pt-6 border-t border-slate-100 dark:border-slate-700 transition-colors">
            <button type="submit" class="bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-medium px-8 py-2.5 rounded-lg shadow-md shadow-emerald-500/20 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200 transform hover:-translate-y-0.5">
                Simpan Data
            </button>
            <a href="{{ route('mahasiswa.index') }}" class="bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 font-medium px-8 py-2.5 rounded-lg shadow-sm transition-all duration-200">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection