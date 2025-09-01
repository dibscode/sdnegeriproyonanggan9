<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Murid;
use App\Models\Nilai;
use App\Models\MataPelajaran;

class NilaiController extends Controller
{
    // Tampilkan daftar kelas yang menjadi tanggung jawab guru saat ini
    public function kelasIndex()
    {
        $guru = auth()->user()->guru;
        $matchMethod = null;
        $kelas = collect();
        if ($guru) {
            // primary: kelas where wali_guru_id matches guru id
            $kelas = Kelas::where('wali_guru_id', $guru->id)->get();
            if ($kelas->isEmpty()) {
                // fallback 1: maybe admin assigned by user_id instead of guru id
                if (!empty($guru->user_id)) {
                    $kelas = Kelas::where('wali_guru_id', $guru->user_id)->get();
                    if ($kelas->isNotEmpty()) $matchMethod = 'user_id';
                }
            }
            if ($kelas->isEmpty()) {
                // fallback 2: maybe wali_guru_id set to the auth user id
                $kelas = Kelas::where('wali_guru_id', auth()->id())->get();
                if ($kelas->isNotEmpty()) $matchMethod = 'auth_id';
            }
        }

        return view('guru.nilai.kelas', compact('kelas','matchMethod'));
    }

    // Tampilkan daftar murid untuk kelas tertentu
    public function muridIndex(\Illuminate\Http\Request $request, Kelas $kelas)
    {
        $guru = auth()->user()->guru;
        // Pastikan guru ini wali kelas tersebut
        if (!$guru || $kelas->wali_guru_id !== $guru->id) {
            abort(403);
        }
        // If semester/tahun_ajaran not provided, show a selection page
        $semester = $request->query('semester');
        $tahun = $request->query('tahun_ajaran');
        if (empty($semester) || empty($tahun)) {
            // build a small list of recent academic years for selection
            $current = date('Y');
            $years = [];
            for ($i = 0; $i < 6; $i++) {
                $y1 = $current - $i;
                $y2 = $y1 + 1;
                $years[] = $y1 . '/' . $y2;
            }
            return view('guru.nilai.select', compact('kelas','years'));
        }

        $murids = $kelas->murids()->with('user')->get();
        return view('guru.nilai.murids', compact('kelas','murids','semester','tahun'));
    }

    // Form untuk melihat/menambah nilai pada satu murid (tampilkan semua mapel)
    public function edit(\Illuminate\Http\Request $request, Murid $murid)
    {
        $guru = auth()->user()->guru;
        // Pastikan guru ini wali untuk kelas murid
        if (!$guru || $murid->kelas_id !== $guru->kelas()->pluck('id')->first()) {
            // simpler check: ensure murid's kelas is among guru->kelas ids
            $guruKelasIds = $guru->kelas()->pluck('id')->toArray();
            if (!in_array($murid->kelas_id, $guruKelasIds)) abort(403);
        }

        $mapels = MataPelajaran::all();
        $semester = $request->query('semester');
        $tahun = $request->query('tahun_ajaran');
        $existingQuery = Nilai::where('murid_id', $murid->id);
        if ($semester) $existingQuery->where('semester', $semester);
        if ($tahun) $existingQuery->where('tahun_ajaran', $tahun);
    $existing = $existingQuery->get()->keyBy('mapel_id');
    return view('guru.nilai.edit', compact('murid','mapels','existing','semester','tahun'));
    }

    // Simpan nilai baru (dari form guru per murid per mapel)
    public function store(Request $request, Murid $murid)
    {
        $guru = auth()->user()->guru;
        $this->authorize('isGuru');

        $data = $request->validate([
            'mapel_id' => 'required|exists:mata_pelajarans,id',
            'nilai' => 'required|integer|min:0|max:100',
            'semester' => 'nullable|integer',
            'tahun_ajaran' => 'nullable|string',
        ]);

        $data['murid_id'] = $murid->id;
        $data['kelas_id'] = $murid->kelas_id;
        $data['wali_guru_id'] = $guru->id;

        // Jika sudah ada nilai untuk murid+mapel+semester+tahun, update
        $existing = Nilai::where('murid_id', $murid->id)
            ->where('mapel_id', $data['mapel_id'])
            ->where('semester', $data['semester'] ?? null)
            ->where('tahun_ajaran', $data['tahun_ajaran'] ?? null)
            ->first();

        if ($existing) {
            $existing->update(['nilai' => $data['nilai']]);
            session()->flash('success', 'Nilai diperbarui.');
            return back();
        }

        Nilai::create($data);
        session()->flash('success', 'Nilai disimpan.');
        return back();
    }

    // Bulk store multiple nilai at once (single submit)
    public function bulkStore(Request $request, Murid $murid)
    {
        $this->authorize('isGuru');
        $guru = auth()->user()->guru;

        $data = $request->validate([
            'mapel_id' => 'required|array',
            'mapel_id.*' => 'required|exists:mata_pelajarans,id',
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|integer|min:0|max:100',
            'semester' => 'nullable|string',
            'tahun_ajaran' => 'nullable|string',
        ]);

        $semester = $data['semester'] ?? null;
        $tahun = $data['tahun_ajaran'] ?? null;

        foreach ($data['mapel_id'] as $idx => $mapelId) {
            $nilaiVal = isset($data['nilai'][$idx]) ? $data['nilai'][$idx] : null;
            if ($nilaiVal === null || $nilaiVal === '') continue; // skip empty

            $payload = [
                'murid_id' => $murid->id,
                'kelas_id' => $murid->kelas_id,
                'mapel_id' => $mapelId,
                'nilai' => $nilaiVal,
                'semester' => $semester,
                'tahun_ajaran' => $tahun,
                'wali_guru_id' => $guru->id,
            ];

            $existing = Nilai::where('murid_id', $murid->id)
                ->where('mapel_id', $mapelId)
                ->where('semester', $semester)
                ->where('tahun_ajaran', $tahun)
                ->first();

            if ($existing) {
                $existing->update(['nilai' => $nilaiVal]);
            } else {
                Nilai::create($payload);
            }
        }

        session()->flash('success', 'Semua nilai tersimpan.');
        return back();
    }

    public function update(Request $request, Nilai $nilai)
    {
        $this->authorize('isGuru');
        $data = $request->validate(['nilai' => 'required|integer|min:0|max:100']);
        $nilai->update($data);
        session()->flash('success','Nilai diupdate.');
        return back();
    }

    public function destroy(Nilai $nilai)
    {
        $this->authorize('isGuru');
        $nilai->delete();
        session()->flash('success','Nilai dihapus.');
        return back();
    }
}
