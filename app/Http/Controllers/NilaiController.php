<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Murid;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $nilais = Nilai::with('murid','mapel','wali')->paginate(50);
        return view('nilais.index', compact('nilais'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'murid_id' => 'required|exists:murids,id',
            'kelas_id' => 'required|exists:kelas,id',
            'semester' => 'required|integer',
            'tahun_ajaran' => 'required|string',
            'mapel_id' => 'required|exists:mata_pelajarans,id',
            'nilai' => 'required|integer',
        ]);

        $data['wali_guru_id'] = auth()->user()->guru->id ?? null;

        Nilai::create($data);
        return back();
    }

    public function update(Request $request, Nilai $nilai)
    {
        $data = $request->validate([
            'nilai' => 'required|integer',
        ]);
        $nilai->update($data);
        return back();
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        return back();
    }
}
