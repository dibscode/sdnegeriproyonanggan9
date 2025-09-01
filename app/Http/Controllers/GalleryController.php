<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::paginate(20);
        return view('galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('galleries.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'deskripsi' => 'nullable|string',
            'gambar' => 'required|image',
        ]);

        $data['gambar'] = $request->file('gambar')->store('gallery', 'public');
        Gallery::create($data);
        return redirect()->route('galleries.index');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->gambar) {
            Storage::disk('public')->delete($gallery->gambar);
        }
        $gallery->delete();
        return back();
    }
}
