<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::with('kelas')->paginate(20);
        return view('jadwals.index', compact('jadwals'));
    }

    public function create()
    {
    $kelas = Kelas::all();
    return view('jadwals.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'gambar' => 'required|image',
        ]);

        $data['gambar'] = $request->file('gambar')->store('jadwal', 'public');
        Jadwal::create($data);
        return redirect()->route('jadwals.index');
    }

    public function edit(Jadwal $jadwal)
    {
    $kelas = Kelas::all();
    return view('jadwals.edit', compact('jadwal','kelas'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $data = $request->validate([
            'gambar' => 'nullable|image',
        ]);
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('jadwal', 'public');
        }
        $jadwal->update($data);
        return redirect()->route('jadwals.index');
    }

    public function destroy(Jadwal $jadwal)
    {
        if ($jadwal->gambar) {
            Storage::disk('public')->delete($jadwal->gambar);
        }
        $jadwal->delete();
        return back();
    }
}
