<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapels = MataPelajaran::paginate(20);
        return view('admin.mata_pelajarans.index', compact('mapels'));
    }

    public function create()
    {
        return view('admin.mata_pelajarans.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        MataPelajaran::create($data);
        session()->flash('success','Mata pelajaran ditambahkan.');
        return redirect()->route('admin.mata_pelajarans.index');
    }

    public function edit(MataPelajaran $mata_pelajaran)
    {
        return view('admin.mata_pelajarans.edit', ['mapel'=>$mata_pelajaran]);
    }

    public function update(Request $request, MataPelajaran $mata_pelajaran)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        $mata_pelajaran->update($data);
        session()->flash('success','Mata pelajaran diupdate.');
        return redirect()->route('admin.mata_pelajarans.index');
    }

    public function destroy(MataPelajaran $mata_pelajaran)
    {
        $mata_pelajaran->delete();
        session()->flash('success','Mata pelajaran dihapus.');
        return back();
    }
}
