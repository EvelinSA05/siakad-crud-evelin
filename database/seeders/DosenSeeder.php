<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nidn' => '0415038901',
                'nama' => 'Dr. Eng. Hermawan, S.Kom., M.T.',
                'jabatan_fungsional' => 'Lektor Kepala',
                'foto' => null,
            ],
            [
                'nidn' => '0422088502',
                'nama' => 'Riza Arifudin, S.Pd., M.Cs.',
                'jabatan_fungsional' => 'Lektor',
                'foto' => null,
            ],
            [
                'nidn' => '0409119103',
                'nama' => 'Fitra A. Bachtiar, S.Kom., M.Eng.',
                'jabatan_fungsional' => 'Asisten Ahli',
                'foto' => null,
            ],
            [
                'nidn' => '0405067804',
                'nama' => 'Prof. Dr. Ir. Suprapto, M.T.',
                'jabatan_fungsional' => 'Guru Besar',
                'foto' => null,
            ],
            [
                'nidn' => '0412128705',
                'nama' => 'Wahyuni, S.T., M.Kom.',
                'jabatan_fungsional' => 'Lektor',
                'foto' => null,
            ],
        ];

        foreach ($data as $row) {
            Dosen::firstOrCreate(['nidn' => $row['nidn']], $row);
        }
    }
}
