<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="space-y-2">
        <label for="kode_mk" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Kode MK <span class="text-rose-500">*</span></label>
        <input type="text" name="kode_mk" id="kode_mk" value="{{ old('kode_mk', $mataKuliah->kode_mk ?? '') }}" 
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 dark:text-slate-200 outline-none transition-colors"
            required placeholder="Contoh: TIF101" pattern="[A-Z]{3}[0-9]{3}" title="3 huruf kapital diikuti 3 angka">
        @error('kode_mk') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-2">
        <label for="nama_mk" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Nama Mata Kuliah <span class="text-rose-500">*</span></label>
        <input type="text" name="nama_mk" id="nama_mk" value="{{ old('nama_mk', $mataKuliah->nama_mk ?? '') }}" 
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 dark:text-slate-200 outline-none transition-colors"
            required>
        @error('nama_mk') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-2">
        <label for="sks" class="block text-sm font-medium text-slate-700 dark:text-slate-300">SKS <span class="text-rose-500">*</span></label>
        <input type="number" name="sks" id="sks" value="{{ old('sks', $mataKuliah->sks ?? '') }}" 
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 dark:text-slate-200 outline-none transition-colors"
            required min="1" max="6">
        @error('sks') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-2">
        <label for="prodi" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Program Studi <span class="text-rose-500">*</span></label>
        <select name="prodi" id="prodi" class="w-full px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 dark:text-slate-200 outline-none transition-colors appearance-none" required>
            <option value="">Pilih Program Studi</option>
            @foreach(['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Akuntansi'] as $pr)
                <option value="{{ $pr }}" {{ old('prodi', $mataKuliah->prodi ?? '') == $pr ? 'selected' : '' }}>{{ $pr }}</option>
            @endforeach
        </select>
        @error('prodi') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-2">
        <label for="semester" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Semester <span class="text-rose-500">*</span></label>
        <input type="number" name="semester" id="semester" value="{{ old('semester', $mataKuliah->semester ?? '') }}" 
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 dark:text-slate-200 outline-none transition-colors"
            required min="1" max="8">
        @error('semester') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-2">
        <label for="dosen_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Dosen Pengampu <span class="text-rose-500">*</span></label>
        <select name="dosen_id" id="dosen_id" class="w-full px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 dark:text-slate-200 outline-none transition-colors appearance-none" required>
            <option value="">Pilih Dosen Pengampu</option>
            @foreach($dosens as $dsn)
                <option value="{{ $dsn->id }}" {{ old('dosen_id', $mataKuliah->dosen_id ?? '') == $dsn->id ? 'selected' : '' }}>
                    {{ $dsn->nama }} ({{ $dsn->nidn }})
                </option>
            @endforeach
        </select>
        @error('dosen_id') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
</div>
