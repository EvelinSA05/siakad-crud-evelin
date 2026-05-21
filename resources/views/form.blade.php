{{-- Tampilkan error validasi --}}
@if ($errors->any())
<div class="mb-4 bg-red-50 dark:bg-rose-900/30 border-l-4 border-red-500 dark:border-rose-500 p-4 rounded transition-colors">
    <p class="font-semibold text-red-700 dark:text-rose-400 mb-2">Terdapat kesalahan:</p>
    <ul class="list-disc list-inside text-sm text-red-700 dark:text-rose-400 space-y-1">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- NIM & Nama --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">NIM
            <span class="text-rose-500">*</span></label>
        <input type="text" name="nim" value="{{ old('nim', $mahasiswa->nim ?? '') }}" required
            maxlength="10"
            class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-lg focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 dark:focus:border-emerald-500 transition-all duration-200 outline-none">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nama
            Lengkap <span class="text-rose-500">*</span></label>
        <input type="text" name="nama" value="{{ old('nama', $mahasiswa->nama ?? '') }}" required class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-lg focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 dark:focus:border-emerald-500 transition-all duration-200 outline-none">
    </div>
</div>

{{-- Email & No HP --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email
            <span class="text-rose-500">*</span></label>
        <input type="email" name="email" value="{{ old('email', $mahasiswa->email ?? '') }}" required class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-lg focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 dark:focus:border-emerald-500 transition-all duration-200 outline-none">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">No
            HP</label>
        <input type="text" name="no_hp" value="{{ old('no_hp', $mahasiswa->no_hp ?? '') }}" maxlength="15" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-lg focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 dark:focus:border-emerald-500 transition-all duration-200 outline-none">
    </div>
</div>

{{-- Jenis Kelamin & Tanggal Lahir --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Jenis
            Kelamin <span class="text-rose-500">*</span></label>
        <select name="jenis_kelamin" required class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-lg focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 dark:focus:border-emerald-500 transition-all duration-200 outline-none appearance-none">
            <option value="">-- Pilih --</option>
            <option value="L" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ old('jenis_kelamin', $mahasiswa->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Tanggal
            Lahir</label>
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', isset($mahasiswa->tanggal_lahir) ? $mahasiswa->tanggal_lahir->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-lg focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 dark:focus:border-emerald-500 transition-all duration-200 outline-none">
    </div>
</div>

{{-- Prodi & Angkatan --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Program
            Studi <span class="text-rose-500">*</span></label>
        <select name="prodi" required class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-lg focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 dark:focus:border-emerald-500 transition-all duration-200 outline-none appearance-none">
            <option value="">-- Pilih Prodi --</option>
            <option value="Teknik Informatika" {{ old('prodi', $mahasiswa->prodi ?? '') == 'Teknik Informatika' ? 'selected' : '' }}>Informatika</option>
            <option value="Sistem Informasi" {{ old('prodi', $mahasiswa->prodi ?? '') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
            <option value="Sains Data" {{ old('prodi', $mahasiswa->prodi ?? '') == 'Sains Data' ? 'selected' : '' }}>Sains Data</option>
            <option value="Bisnis Digital" {{ old('prodi', $mahasiswa->prodi ?? '') == 'Bisnis Digital' ? 'selected' : '' }}>Bisnis Digital</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Angkatan
            <span class="text-rose-500">*</span></label>
        <input type="number" name="angkatan" value="{{ old('angkatan', $mahasiswa->angkatan ?? date('Y')) }}" min="2000" max="{{ date('Y') }}" required class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-lg focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 dark:focus:border-emerald-500 transition-all duration-200 outline-none">
    </div>
</div>

{{-- IPK & Status --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">IPK</label>
        <input type="number" name="ipk" value="{{ old('ipk', $mahasiswa->ipk ?? '0.00') }}" min="0" max="4" step="0.01" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-lg focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 dark:focus:border-emerald-500 transition-all duration-200 outline-none">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Status
            <span class="text-rose-500">*</span></label>
        <select name="status" required class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-lg focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 dark:focus:border-emerald-500 transition-all duration-200 outline-none appearance-none">
            <option value="aktif" {{ old('status', $mahasiswa->status ?? 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="cuti" {{ old('status', $mahasiswa->status ?? '') == 'cuti' ? 'selected' : '' }}>Cuti</option>
            <option value="lulus" {{ old('status', $mahasiswa->status ?? '') == 'lulus' ? 'selected' : '' }}>Lulus</option>
            <option value="do" {{ old('status', $mahasiswa->status ?? '') == 'do' ? 'selected' : '' }}>Drop Out</option>
        </select>
    </div>
</div>

{{-- Alamat --}}
<div>
    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Alamat</label>
    <textarea name="alamat" rows="3" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 rounded-lg focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 dark:focus:border-emerald-500 transition-all duration-200 outline-none">{{ old('alamat', $mahasiswa->alamat ?? '') }}</textarea>
</div>

{{-- Foto --}}
<div>
    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Foto Profil</label>
    
    <div id="dropzone" class="relative border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-800/50 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:border-emerald-400 dark:hover:border-emerald-500 transition-all duration-200 cursor-pointer overflow-hidden group min-h-[160px] flex items-center justify-center">
        
        <input type="file" name="foto" id="foto-input" accept="image/jpeg,image/png,image/jpg" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" title="Klik atau seret foto ke sini">
        
        {{-- Preview Area --}}
        <div id="preview-container" class="absolute inset-0 w-full h-full bg-slate-100 dark:bg-slate-900 flex items-center justify-center {{ (isset($mahasiswa) && $mahasiswa->foto) ? '' : 'hidden' }}">
            <img id="image-preview" src="{{ (isset($mahasiswa) && $mahasiswa->foto) ? $mahasiswa->foto_url : '' }}" alt="Preview" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-slate-900/40 dark:bg-slate-900/60 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center backdrop-blur-sm">
                <p class="text-white font-medium text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Klik untuk mengubah foto
                </p>
            </div>
        </div>

        {{-- Default State Area --}}
        <div id="placeholder-container" class="flex flex-col items-center justify-center text-center p-6 {{ (isset($mahasiswa) && $mahasiswa->foto) ? 'hidden' : '' }}">
            <div class="w-14 h-14 mb-4 text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/50 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-sm shadow-emerald-200 dark:shadow-emerald-900/20">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-400 font-medium mb-1"><span class="text-emerald-600 dark:text-emerald-400">Klik untuk unggah</span> atau drag and drop foto ke sini</p>
            <p class="text-xs text-slate-400 dark:text-slate-500">Hanya format JPG/PNG (Maks. 2MB)</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('foto-input');
        const previewContainer = document.getElementById('preview-container');
        const placeholderContainer = document.getElementById('placeholder-container');
        const imagePreview = document.getElementById('image-preview');

        if (!dropzone || !fileInput) return;

        // Mendeteksi dark mode
        const isDark = document.documentElement.classList.contains('dark');

        // Visual feedback saat drag over
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            if (isDark) {
                dropzone.classList.add('border-emerald-500', 'bg-emerald-900/20');
                dropzone.classList.remove('border-slate-600', 'bg-slate-800/50');
            } else {
                dropzone.classList.add('border-emerald-400', 'bg-emerald-50');
                dropzone.classList.remove('border-slate-300', 'bg-slate-50');
            }
        });

        dropzone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            if (isDark) {
                dropzone.classList.remove('border-emerald-500', 'bg-emerald-900/20');
                dropzone.classList.add('border-slate-600', 'bg-slate-800/50');
            } else {
                dropzone.classList.remove('border-emerald-400', 'bg-emerald-50');
                dropzone.classList.add('border-slate-300', 'bg-slate-50');
            }
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            if (isDark) {
                dropzone.classList.remove('border-emerald-500', 'bg-emerald-900/20');
                dropzone.classList.add('border-slate-600', 'bg-slate-800/50');
            } else {
                dropzone.classList.remove('border-emerald-400', 'bg-emerald-50');
                dropzone.classList.add('border-slate-300', 'bg-slate-50');
            }
            
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                handlePreview(e.dataTransfer.files[0]);
            }
        });

        fileInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                handlePreview(this.files[0]);
            }
        });

        function handlePreview(file) {
            // Pastikan yang diupload adalah gambar
            if (!file.type.startsWith('image/')) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Tidak Didukung',
                        text: 'Silakan pilih file berupa gambar (JPG/PNG).',
                        background: document.documentElement.classList.contains('dark') ? '#1e293b' : '#ffffff',
                        color: document.documentElement.classList.contains('dark') ? '#f8fafc' : '#0f172a',
                    });
                } else {
                    alert('Silakan pilih file berupa gambar (JPG/PNG).');
                }
                fileInput.value = ""; // Reset input
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('hidden');
                placeholderContainer.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>