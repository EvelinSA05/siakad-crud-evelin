<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\MataKuliah;
use Illuminate\Database\Seeder;

class MataKuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan DosenSeeder sudah dijalankan agar data dosen tersedia
        if (Dosen::count() === 0) {
            $this->call(DosenSeeder::class);
        }

        $dosenMap = Dosen::pluck('id', 'nidn')->toArray();

        $data = [
            [
                'dosen_id' => $dosenMap['0415038901'] ?? null,
                'kode_mk' => 'IF201',
                'nama_mk' => 'Pemrograman Web',
                'sks' => 3,
                'prodi' => 'Informatika',
                'semester' => 4,
            ],
            [
                'dosen_id' => $dosenMap['0415038901'] ?? null,
                'kode_mk' => 'IF402',
                'nama_mk' => 'Kecerdasan Buatan',
                'sks' => 3,
                'prodi' => 'Informatika',
                'semester' => 6,
            ],
            [
                'dosen_id' => $dosenMap['0422088502'] ?? null,
                'kode_mk' => 'IF102',
                'nama_mk' => 'Algoritma Pemrograman',
                'sks' => 4,
                'prodi' => 'Informatika',
                'semester' => 1,
            ],
            [
                'dosen_id' => $dosenMap['0422088502'] ?? null,
                'kode_mk' => 'SI203',
                'nama_mk' => 'Struktur Data',
                'sks' => 3,
                'prodi' => 'Sistem Informasi',
                'semester' => 2,
            ],
            [
                'dosen_id' => $dosenMap['0409119103'] ?? null,
                'kode_mk' => 'SI301',
                'nama_mk' => 'Basis Data',
                'sks' => 4,
                'prodi' => 'Sistem Informasi',
                'semester' => 3,
            ],
            [
                'dosen_id' => $dosenMap['0409119103'] ?? null,
                'kode_mk' => 'IF305',
                'nama_mk' => 'Rekayasa Perangkat Lunak',
                'sks' => 3,
                'prodi' => 'Informatika',
                'semester' => 5,
            ],
            [
                'dosen_id' => $dosenMap['0405067804'] ?? null,
                'kode_mk' => 'SI405',
                'nama_mk' => 'Metodologi Penelitian',
                'sks' => 2,
                'prodi' => 'Sistem Informasi',
                'semester' => 6,
            ],
            [
                'dosen_id' => $dosenMap['0405067804'] ?? null,
                'kode_mk' => 'IF408',
                'nama_mk' => 'Sistem Terdistribusi',
                'sks' => 3,
                'prodi' => 'Informatika',
                'semester' => 7,
            ],
            [
                'dosen_id' => $dosenMap['0412128705'] ?? null,
                'kode_mk' => 'SI204',
                'nama_mk' => 'Interaksi Manusia dan Komputer',
                'sks' => 3,
                'prodi' => 'Sistem Informasi',
                'semester' => 2,
            ],
            [
                'dosen_id' => $dosenMap['0412128705'] ?? null,
                'kode_mk' => 'SI302',
                'nama_mk' => 'Analisis dan Desain Sistem',
                'sks' => 3,
                'prodi' => 'Sistem Informasi',
                'semester' => 3,
            ],
        ];

        foreach ($data as $row) {
            if ($row['dosen_id']) {
                MataKuliah::firstOrCreate(['kode_mk' => $row['kode_mk']], $row);
            }
        }
    }
}
