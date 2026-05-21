<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $query = Dosen::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nidn', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        if ($request->has('jabatan_fungsional') && $request->jabatan_fungsional != '') {
            $query->where('jabatan_fungsional', $request->jabatan_fungsional);
        }

        $dosens = $query->paginate(10)->appends($request->query());

        return view('dosen.index', compact('dosens'));
    }

    public function create()
    {
        return view('dosen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nidn' => 'required|string|size:15|unique:dosens,nidn',
            'nama' => 'required|string|max:255',
            'jabatan_fungsional' => 'required|in:Asisten Ahli,Lektor,Lektor Kepala,Guru Besar',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('dosen_fotos', 'public');
            $validated['foto'] = $path;
        }

        Dosen::create($validated);

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function show(Dosen $dosen)
    {
        $dosen->load('mataKuliahs');
        return view('dosen.show', compact('dosen'));
    }

    public function edit(Dosen $dosen)
    {
        return view('dosen.edit', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $validated = $request->validate([
            'nidn' => 'required|string|size:15|unique:dosens,nidn,' . $dosen->id,
            'nama' => 'required|string|max:255',
            'jabatan_fungsional' => 'required|in:Asisten Ahli,Lektor,Lektor Kepala,Guru Besar',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($dosen->foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($dosen->foto);
            }
            $path = $request->file('foto')->store('dosen_fotos', 'public');
            $validated['foto'] = $path;
        }

        $dosen->update($validated);

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diupdate.');
    }

    public function destroy(Dosen $dosen)
    {
        // Hapus foto dari storage jika ada
        if ($dosen->foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($dosen->foto);
        }
        $dosen->delete();
        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil dihapus.');
    }
}
