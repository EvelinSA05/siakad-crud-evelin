<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="space-y-2">
        <label for="nidn" class="block text-sm font-medium text-slate-700 dark:text-slate-300">NIDN <span class="text-rose-500">*</span></label>
        <input type="text" name="nidn" id="nidn" value="{{ old('nidn', $dosen->nidn ?? '') }}" 
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 dark:text-slate-200 outline-none transition-colors"
            required minlength="15" maxlength="15" placeholder="15 Digit NIDN" pattern="\d{15}" title="NIDN harus 15 digit angka">
        @error('nidn') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-2">
        <label for="nama" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Nama Lengkap <span class="text-rose-500">*</span></label>
        <input type="text" name="nama" id="nama" value="{{ old('nama', $dosen->nama ?? '') }}" 
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 dark:text-slate-200 outline-none transition-colors"
            required>
        @error('nama') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-2">
        <label for="jabatan_fungsional" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Jabatan Fungsional <span class="text-rose-500">*</span></label>
        <select name="jabatan_fungsional" id="jabatan_fungsional" 
            class="w-full px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 text-slate-800 dark:text-slate-200 outline-none transition-colors appearance-none" required>
            <option value="">Pilih Jabatan</option>
            @foreach(['Asisten Ahli', 'Lektor', 'Lektor Kepala', 'Guru Besar'] as $jabatan)
                <option value="{{ $jabatan }}" {{ old('jabatan_fungsional', $dosen->jabatan_fungsional ?? '') == $jabatan ? 'selected' : '' }}>{{ $jabatan }}</option>
            @endforeach
        </select>
        @error('jabatan_fungsional') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-2">
        <label for="foto" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Foto Profil</label>
        <input type="file" name="foto" id="foto" accept="image/jpeg,image/png,image/jpg"
            class="w-full px-3 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 dark:file:bg-emerald-900/30 dark:file:text-emerald-400 transition-colors">
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Format: JPG, PNG. Maksimal 2MB.</p>
        @error('foto') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
    </div>
</div>
