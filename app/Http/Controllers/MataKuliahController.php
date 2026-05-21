<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\Dosen;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index(Request $request)
    {
        $query = MataKuliah::with('dosen');

        if ($request->has('prodi') && $request->prodi != '') {
            $query->where('prodi', $request->prodi);
        }

        if ($request->has('semester') && $request->semester != '') {
            $query->where('semester', $request->semester);
        }

        // Calculate total SKS per prodi (for the active filter, or overall if no filter)
        $totalSksQuery = clone $query;
        $totalSks = $totalSksQuery->sum('sks');

        $mata_kuliahs = $query->paginate(10)->appends($request->query());

        return view('mata_kuliah.index', compact('mata_kuliahs', 'totalSks'));
    }

    public function create()
    {
        $dosens = Dosen::all();
        return view('mata_kuliah.create', compact('dosens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mk' => ['required', 'string', 'unique:mata_kuliahs,kode_mk', 'regex:/^[A-Z]{3}[0-9]{3}$/'],
            'nama_mk' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'prodi' => 'required|string',
            'semester' => 'required|integer|min:1|max:8',
            'dosen_id' => 'required|exists:dosens,id',
        ], [
            'kode_mk.regex' => 'Format Kode MK harus 3 huruf kapital diikuti 3 angka (contoh: TIF101).'
        ]);

        MataKuliah::create($validated);

        return redirect()->route('mata-kuliah.index')->with('success', 'Data mata kuliah berhasil ditambahkan.');
    }

    public function show(MataKuliah $mataKuliah)
    {
        return view('mata_kuliah.show', compact('mataKuliah'));
    }

    public function edit(MataKuliah $mataKuliah)
    {
        $dosens = Dosen::all();
        return view('mata_kuliah.edit', compact('mataKuliah', 'dosens'));
    }

    public function update(Request $request, MataKuliah $mataKuliah)
    {
        $validated = $request->validate([
            'kode_mk' => ['required', 'string', 'unique:mata_kuliahs,kode_mk,'.$mataKuliah->id, 'regex:/^[A-Z]{3}[0-9]{3}$/'],
            'nama_mk' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'prodi' => 'required|string',
            'semester' => 'required|integer|min:1|max:8',
            'dosen_id' => 'required|exists:dosens,id',
        ], [
            'kode_mk.regex' => 'Format Kode MK harus 3 huruf kapital diikuti 3 angka (contoh: TIF101).'
        ]);

        $mataKuliah->update($validated);

        return redirect()->route('mata-kuliah.index')->with('success', 'Data mata kuliah berhasil diupdate.');
    }

    public function destroy(MataKuliah $mataKuliah)
    {
        $mataKuliah->delete();
        return redirect()->route('mata-kuliah.index')->with('success', 'Data mata kuliah berhasil dihapus.');
    }
}
