<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\DBLogActivities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * READ — Tampilkan daftar mahasiswa
     * Route: GET /mahasiswa
     */
    public function index(Request $request)
    {
        $query = Mahasiswa::query();
        // Pencarian berdasarkan NIM atau nama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        // Filter berdasarkan prodi
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        // Sorting
        $sortableColumns = ['nim', 'nama', 'prodi', 'ipk', 'status'];
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        if (in_array($sort, $sortableColumns) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        } else {
            $query->latest();
        }

        $mahasiswa = $query->paginate(10)->appends($request->query());

        // --- Data Statistik Dashboard ---
        $totalMahasiswa = \App\Models\Mahasiswa::count();
        $mahasiswaAktif = \App\Models\Mahasiswa::where('status', 'aktif')->count();
        $rataIpk = \App\Models\Mahasiswa::avg('ipk') ?? 0;

        // Data untuk grafik pie (jumlah mahasiswa per prodi)
        $statistikProdi = \App\Models\Mahasiswa::selectRaw('prodi, count(*) as jumlah')
            ->groupBy('prodi')
            ->pluck('jumlah', 'prodi')
            ->toArray();

        return view('mahasiswa.index', compact('mahasiswa', 'totalMahasiswa', 'mahasiswaAktif', 'rataIpk', 'statistikProdi'));
    }
    /**
     * CREATE — Tampilkan form tambah mahasiswa
     * Route: GET /mahasiswa/create
     */
    public function create()
    {
        return view('mahasiswa.create');
    }
    /**
     * CREATE — Simpan data mahasiswa baru
     * Route: POST /mahasiswa
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nim' => 'required|string|max:10|unique:mahasiswa,nim',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:mahasiswa,email',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:15',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'prodi' => 'required|string|max:50',
            'angkatan' => 'required|integer|min:2000|max:' . date('Y'),
            'ipk' => 'nullable|numeric|min:0|max:4',
            'status' => 'required|in:aktif,cuti,lulus,do',
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'email.email' => 'Format email tidak valid.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);
        // Upload foto (jika ada)
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('mahasiswa', 'public');
            $validated['foto'] = $path;
        }
        // Simpan ke database
        Mahasiswa::create($validated);
        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }
    /**
     * READ — Tampilkan detail mahasiswa
     * Route: GET /mahasiswa/{id}
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.show', compact('mahasiswa'));
    }
    /**
     * UPDATE — Tampilkan form edit
     * Route: GET /mahasiswa/{id}/edit
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }
    /**
     * UPDATE — Update data mahasiswa
     * Route: PUT/PATCH /mahasiswa/{id}
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:10|unique:mahasiswa,nim,' .
                $mahasiswa->id,
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:mahasiswa,email,' .
                $mahasiswa->id,
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:15',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'prodi' => 'required|string|max:50',
            'angkatan' => 'required|integer|min:2000|max:' . date('Y'),
            'ipk' => 'nullable|numeric|min:0|max:4',
            'status' => 'required|in:aktif,cuti,lulus,do',
        ]);
        // // Upload foto baru (jika ada)
        // if ($request->hasFile('foto')) {
        //     // Hapus foto lama
        //     if ($mahasiswa->foto) {
        //         Storage::disk('public')->delete($mahasiswa->foto);
        //     }
        //     $path = $request->file('foto')->store('mahasiswa', 'public');
        //     $validated['foto'] = $path;
        // }
        // $mahasiswa->update($validated);

        $oldPhoto = $mahasiswa->foto;
        $newPhoto = null;
        // 1. Memeriksa apakah ada file foto yang diunggah oleh user
        if ($request->hasFile('foto')) {
            $newPhoto = $request->file('foto')->store('mahasiswa', 'public');
            $validated['foto'] = $newPhoto;
        }
        // 2. Menjalankan proses update
        DB::transaction(function () use ($validated, $mahasiswa) {
            $oldNama = $mahasiswa->nama;
            $mahasiswa->update($validated);
            DBLogActivities::create([
                DBLogActivities::ACTION_COLUMN => DBLogActivities::UPDATE,
                DBLogActivities::DESC_COLUMN => "Update mahasiswa: {$oldNama} menjadi {$validated['nama']}",
            ]);
        });
        // 3. Cleanup file foto lama
        if ($newPhoto && $newPhoto) {
            Storage::disk('public')->delete($oldPhoto);
        }

        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }
    /**
     * DELETE — Hapus mahasiswa
     * Route: DELETE /mahasiswa/{id}
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        // Hapus foto dari storage (jika ada)
        $fotoPath = $mahasiswa->foto;
        $nama = $mahasiswa->nama;
        // menjalankan proses delete data mahasiswa
        DB::transaction(function () use ($mahasiswa, $nama) {
            $mahasiswa->delete();

            DBLogActivities::create([
                DBLogActivities::ACTION_COLUMN => DBLogActivities::DELETE,
                DBLogActivities::DESC_COLUMN => "Hapus mahasiswa: {$nama}"
            ]);
        });
        // menjalankan proses delete file foto
        if ($fotoPath) {
            Storage::disk('public')->delete($fotoPath);
        }
        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    public function exportCsv(Request $request)
    {
        $query = Mahasiswa::query();

        // Terapkan filter yang sama dengan index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Terapkan sorting
        $sortableColumns = ['nim', 'nama', 'prodi', 'ipk', 'status'];
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        if (in_array($sort, $sortableColumns) && in_array($direction, ['asc', 'desc'])) {
            $query->orderBy($sort, $direction);
        } else {
            $query->latest();
        }

        $mahasiswa = $query->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=data_mahasiswa.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function () use ($mahasiswa) {
            $file = fopen('php://output', 'w');

            // Tambahkan BOM agar file terbaca sebagai UTF-8 dengan benar di Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, array('NIM', 'Nama', 'Email', 'Jenis Kelamin', 'Tanggal Lahir', 'Prodi', 'Angkatan', 'IPK', 'Status'), ';');

            foreach ($mahasiswa as $row) {
                fputcsv($file, array(
                    $row->nim,
                    $row->nama,
                    $row->email,
                    $row->jenis_kelamin_label,
                    $row->tanggal_lahir ? $row->tanggal_lahir->format('Y-m-d') : '',
                    $row->prodi,
                    $row->angkatan,
                    str_replace('.', ',', $row->ipk),
                    ucfirst($row->status)
                ), ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'file_csv' => 'required|file|mimes:csv,txt|max:2048',
        ], [
            'file_csv.required' => 'File CSV wajib diupload.',
            'file_csv.mimes' => 'Format file harus CSV.',
        ]);

        $file = $request->file('file_csv');

        // Deteksi delimiter secara otomatis (koma atau titik koma)
        $firstLine = fgets(fopen($file->getPathname(), "r"));
        $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

        $handle = fopen($file->getPathname(), "r");

        $header = true;
        $successCount = 0;
        $failCount = 0;
        $errors = [];
        $rowNum = 1;

        while ($csvLine = fgetcsv($handle, 1000, $delimiter)) {
            if ($header) {
                $header = false;
                $rowNum++;
                continue;
            }

            // Skip jika baris kosong (sering terjadi di akhir file CSV hasil Excel)
            if (empty(array_filter($csvLine))) {
                $rowNum++;
                continue;
            }

            // Misal urutan kolom: NIM, Nama, Email, Jenis Kelamin (L/P), Tanggal Lahir (Y-m-d), Prodi, Angkatan, IPK, Status
            if (count($csvLine) < 9) {
                $failCount++;
                $errors[] = "Baris $rowNum: Jumlah kolom tidak sesuai.";
                $rowNum++;
                continue;
            }

            $nim = trim($csvLine[0]);
            $nama = trim($csvLine[1]);
            $email = trim($csvLine[2]);
            $jk = trim($csvLine[3]) == 'Perempuan' || trim($csvLine[3]) == 'P' ? 'P' : 'L';

            // Konversi tanggal lahir ke format Y-m-d yang dipahami MySQL
            $tgl_lahir_raw = trim($csvLine[4]);
            $tgl_lahir = null;
            if (!empty($tgl_lahir_raw)) {
                $parsedDate = null;
                // Coba parsing format d/m/Y (e.g., 21/03/2026)
                $dateObj = \DateTime::createFromFormat('d/m/Y', $tgl_lahir_raw);
                if ($dateObj && $dateObj->format('d/m/Y') === $tgl_lahir_raw) {
                    $parsedDate = $dateObj->format('Y-m-d');
                } else {
                    // Coba parsing format Y-m-d
                    $dateObj = \DateTime::createFromFormat('Y-m-d', $tgl_lahir_raw);
                    if ($dateObj && $dateObj->format('Y-m-d') === $tgl_lahir_raw) {
                        $parsedDate = $dateObj->format('Y-m-d');
                    } else {
                        // Jika gagal, coba convert menggunakan strtotime
                        $timestamp = strtotime(str_replace('/', '-', $tgl_lahir_raw));
                        if ($timestamp) {
                            $parsedDate = date('Y-m-d', $timestamp);
                        }
                    }
                }
                $tgl_lahir = $parsedDate;
            }

            $prodi = trim($csvLine[5]);
            $angkatan = trim($csvLine[6]);
            $ipk = str_replace(',', '.', trim($csvLine[7]));
            $status = strtolower(trim($csvLine[8]));

            // Validasi manual
            if (empty($nim) || empty($nama) || empty($email) || empty($prodi) || empty($angkatan)) {
                $failCount++;
                $errors[] = "Baris $rowNum: Data wajib (NIM/Nama/Email/Prodi/Angkatan) ada yang kosong.";
                $rowNum++;
                continue;
            }

            if (Mahasiswa::where('nim', $nim)->exists()) {
                $failCount++;
                $errors[] = "Baris $rowNum: NIM $nim sudah terdaftar.";
                $rowNum++;
                continue;
            }

            if (Mahasiswa::where('email', $email)->exists()) {
                $failCount++;
                $errors[] = "Baris $rowNum: Email $email sudah terdaftar.";
                $rowNum++;
                continue;
            }

            if (!in_array($status, ['aktif', 'cuti', 'lulus', 'do'])) {
                $status = 'aktif';
            }

            try {
                Mahasiswa::create([
                    'nim' => $nim,
                    'nama' => $nama,
                    'email' => $email,
                    'jenis_kelamin' => $jk,
                    'tanggal_lahir' => $tgl_lahir,
                    'prodi' => $prodi,
                    'angkatan' => $angkatan,
                    'ipk' => $ipk ?: 0,
                    'status' => $status,
                ]);
                $successCount++;
            } catch (\Exception $e) {
                $failCount++;
                $errors[] = "Baris $rowNum: Gagal menyimpan data (" . $e->getMessage() . ").";
            }

            $rowNum++;
        }

        fclose($handle);

        $msg = "Import selesai. Berhasil: $successCount, Gagal: $failCount.";
        if (count($errors) > 0) {
            return redirect()->route('mahasiswa.index')->with('success', $msg)->with('import_errors', $errors);
        }

        return redirect()->route('mahasiswa.index')->with('success', $msg);
    }
}
