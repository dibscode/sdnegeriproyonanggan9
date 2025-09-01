@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Berita</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($beritas as $b)
            <article class="border rounded overflow-hidden bg-white shadow-sm">
                @if($b->gambar)
                    <img src="{{ asset('storage/'.$b->gambar) }}" alt="{{ $b->judul }}" class="w-full h-40 object-cover">
                @endif
                <div class="p-4">
                    <h3 class="font-semibold">{{ $b->judul }}</h3>
                    <p class="text-sm text-gray-600 mt-2">{{ Str::limit(strip_tags($b->isi), 140) }}</p>
                    <div class="mt-3 text-xs text-gray-500">{{ $b->created_at->format('d M Y') }} &middot; oleh {{ $b->penulis->nama ?? 'Admin' }}</div>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $beritas->links() }}
    </div>
</div>
@endsection
