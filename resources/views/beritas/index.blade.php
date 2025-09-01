@extends('layouts.admin')
@section('title','Daftar Berita')
@section('breadcrumbs')
<a href="{{ route('dashboard') }}">Dashboard</a> / Berita
@endsection
@section('action')
<a href="{{ route('guru.beritas.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded">Buat Berita</a>
@endsection
@section('body')
@if($beritas->isEmpty())
    <div class="text-gray-600">Belum ada berita.</div>
@else
    <div class="space-y-3">
    @foreach($beritas as $b)
        <article class="p-3 border rounded bg-white flex items-start gap-3">
            @if($b->gambar)
                <div class="w-24 h-16 flex-shrink-0 overflow-hidden rounded">
                    <img src="{{ asset('storage/' . $b->gambar) }}" alt="{{ $b->judul }}" class="w-full h-full object-cover" />
                </div>
            @endif
            <div class="flex-1">
                <h3 class="font-semibold">{{ $b->judul }}</h3>
                <p class="text-sm text-gray-600">{{ Str::limit($b->isi,200) }}</p>
                <div class="mt-2 flex items-center gap-2">
                    <a href="{{ route('guru.beritas.edit',$b) }}" class="inline-block px-3 py-1 bg-yellow-500 text-white rounded text-xs">Edit</a>
                    <form action="{{ route('guru.beritas.destroy', $b) }}" method="POST" onsubmit="return confirm('Hapus berita ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-block px-3 py-1 bg-red-600 text-white rounded text-xs">Hapus</button>
                    </form>
                </div>
            </div>
        </article>
    @endforeach
    </div>
@endif
@endsection
