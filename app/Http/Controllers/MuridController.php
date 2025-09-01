<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Murid;
use App\Models\Nilai;
use App\Models\Berita;
use App\Models\Jadwal;
use App\Models\Gallery;
use Illuminate\Http\Request;

class MuridController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $murid = $user->murid ?? null;

        $nilais = $murid ? Nilai::where('murid_id', $murid->id)->with('mapel')->get() : collect();
        $beritas = Berita::latest()->take(10)->get();
        $jadwals = Jadwal::where('kelas_id', $murid->kelas_id ?? 0)->get();
        $galleries = Gallery::latest()->take(10)->get();

        return view('murid.dashboard', compact('murid','nilais','beritas','jadwals','galleries'));
    }

    public function nilaiPdf(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();
        $murid = $user->murid ?? null;
        if (!$murid) {
            return back()->with('error','Murid tidak ditemukan');
        }
        $semester = $request->query('semester');
        $tahun = $request->query('tahun_ajaran');

        if (empty($semester) || empty($tahun)) {
            // show selection page
            // build recent years list
            $current = date('Y');
            $years = [];
            for ($i = 0; $i < 6; $i++) {
                $y1 = $current - $i;
                $y2 = $y1 + 1;
                $years[] = $y1 . '/' . $y2;
            }
            return view('murid.nilai_select', compact('murid','years'));
        }

        $nilais = Nilai::where('murid_id', $murid->id)
            ->where('semester', $semester)
            ->where('tahun_ajaran', $tahun)
            ->with('mapel')
            ->get();

        // If DomPDF is installed, render PDF
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('murid.nilai_pdf', compact('murid','nilais','semester','tahun'));
            return $pdf->download('nilai-'.$murid->nama.'-'.str_replace('/','-',$tahun).'-s'.$semester.'-'.date('Ymd').'.pdf');
        }

        // Fallback: render html view
        return view('murid.nilai_pdf', compact('murid','nilais','semester','tahun'));
    }
}
