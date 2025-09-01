<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::with('penulis')->paginate(20);
        return view('beritas.index', compact('beritas'));
    }

    public function create()
    {
        return view('beritas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string',
            'isi' => 'required|string',
            'gambar' => 'nullable|image',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $data['penulis_id'] = auth()->user()->guru->id ?? null;

    Berita::create($data);
    return redirect()->route('guru.beritas.index');
    }

    public function edit(Berita $berita)
    {
        return view('beritas.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $request->validate([
            'judul' => 'required|string',
            'isi' => 'required|string',
            'gambar' => 'nullable|image',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('berita', 'public');
            $data['gambar'] = $path;
        }

    $berita->update($data);
    return redirect()->route('guru.beritas.index');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }
        $berita->delete();
        return back();
    }

    // Public listing for site visitors
    public function publicIndex()
    {
        $beritas = Berita::with('penulis')->latest()->paginate(12);
        return view('beritas.public_index', compact('beritas'));
    }

    // Public detail view
    public function publicShow(Berita $berita)
    {
        $related = Berita::with('penulis')->where('id', '!=', $berita->id)->latest()->take(6)->get();
        return view('beritas.show', compact('berita', 'related'));
    }
}
