@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 border rounded-lg p-6">
        <h1 class="text-xl font-semibold mb-4">Edit Berita</h1>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guru.beritas.update', $berita) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label class="block mb-3">
                <span class="text-sm font-medium">Judul</span>
                <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}" class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2" required />
            </label>

            <label class="block mb-3">
                <span class="text-sm font-medium">Isi</span>
                <textarea name="isi" rows="8" class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2" required>{{ old('isi', $berita->isi) }}</textarea>
            </label>

            <label class="block mb-3">
                <span class="text-sm font-medium">Gambar (opsional)</span>
                @if($berita->gambar)
                    <div class="mt-2 mb-2">
                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="current" class="w-48 h-32 object-cover rounded" />
                    </div>
                @endif
                <input type="file" name="gambar" class="mt-1 block w-full text-sm text-gray-600 dark:text-gray-300" accept="image/*" />
            </label>

            <div class="flex items-center gap-3 mt-4">
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded">Update</button>
                <a href="{{ route('guru.beritas.index') }}" class="px-4 py-2 border rounded text-sm">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
