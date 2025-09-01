<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('wali')->paginate(20);
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
    $gurus = \App\Models\Guru::orderBy('nama')->get();
    return view('admin.kelas.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'wali_guru_id' => 'nullable|exists:gurus,id',
        ]);

    Kelas::create($data);
    session()->flash('success', 'Kelas berhasil dibuat.');
    return redirect()->route('admin.kelas.index');
    }

    public function edit(Kelas $kelas)
    {
    $gurus = \App\Models\Guru::orderBy('nama')->get();
    return view('admin.kelas.edit', compact('kelas','gurus'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'wali_guru_id' => 'nullable|exists:gurus,id',
        ]);

    $kelas->update($data);
    session()->flash('success', 'Perubahan kelas disimpan.');
    return redirect()->route('admin.kelas.index');
    }

    public function destroy(Kelas $kelas)
    {
    // Prevent deleting a kelas that still has murids
    if (method_exists($kelas, 'murids') && $kelas->murids()->exists()) {
        session()->flash('error', 'Kelas tidak dapat dihapus karena masih memiliki murid. Pindahkan atau hapus murid terlebih dahulu.');
        return back();
    }

    $kelas->delete();
    session()->flash('success', 'Kelas dihapus.');
    return back();
    }
}
