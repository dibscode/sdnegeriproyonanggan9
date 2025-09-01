@extends('layouts.admin')
@section('title','Daftar Jadwal')
@section('breadcrumbs')
<a href="{{ route('dashboard') }}">Dashboard</a> / Jadwal
@endsection
@section('action')
<a href="{{ route('jadwals.create') }}" class="px-3 py-1 bg-blue-600 text-white rounded">Upload Jadwal</a>
@endsection
@section('body')
@if($jadwals->isEmpty())
    <div class="text-gray-600">Belum ada jadwal yang diunggah.</div>
@else
    <div class="grid grid-cols-2 gap-4">
    @foreach($jadwals as $j)
        <div class="border rounded p-2 bg-white">
            @if($j->gambar)
                <img src="{{ asset('storage/'.$j->gambar) }}" alt="jadwal" class="w-full h-48 object-cover mb-2 cursor-pointer jadwal-thumb" data-src="{{ asset('storage/'.$j->gambar) }}">
            @endif
            <div class="mt-2 flex items-center gap-2">
                <a href="{{ route('jadwals.edit',$j) }}" class="inline-block px-2 py-1 bg-yellow-500 text-white rounded text-xs">Edit</a>
                <form action="{{ route('jadwals.destroy', $j) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-block px-2 py-1 bg-red-600 text-white rounded text-xs">Hapus</button>
                </form>
            </div>
        </div>
    @endforeach
    </div>
@endif

<!-- Image zoom modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
    <div class="relative max-w-4xl w-full mx-4">
        <button id="closeImageModal" class="absolute top-2 right-2 text-white bg-gray-800 bg-opacity-50 rounded-full p-2">✕</button>
        <img id="modalImage" src="" class="w-full h-auto rounded shadow-lg" alt="zoom">
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const closeBtn = document.getElementById('closeImageModal');

        document.querySelectorAll('.jadwal-thumb').forEach(img => {
            img.addEventListener('click', () => {
                modalImg.src = img.dataset.src || img.src;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modalImg.src = '';
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeBtn.click();
            }
        });
    });
</script>
@endpush
@endsection
