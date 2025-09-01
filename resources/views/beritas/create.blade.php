@extends('layouts.admin')
@section('title','Buat Berita')
@section('body')
<form action="{{ route('guru.beritas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">@csrf
    <div>
        <label class="block text-sm font-medium text-gray-700">Judul</label>
        <input name="judul" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Isi</label>
        <textarea name="isi" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 h-32 resize-y focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Gambar</label>
        <input type="file" name="gambar" class="mt-1 block w-full text-sm text-gray-600" />
    </div>

    <div>
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
    <a href="{{ route('guru.beritas.index') }}" class="inline-flex items-center px-4 py-2 ms-2 border rounded text-sm">Batal</a>
    </div>
</form>
@endsection
