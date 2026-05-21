<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = [
        'nidn',
        'nama',
        'jabatan_fungsional',
        'foto',
    ];

    public function mataKuliahs()
    {
        return $this->hasMany(MataKuliah::class, 'dosen_id');
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&background=10b981&color=fff';
    }
}
