@extends('layouts.app')
@section('title','Dashboard Murid')
@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Halo, {{ $murid->nama ?? auth()->user()->name }}</h2>

    <section class="mb-6">
    <h3 class="text-xl font-semibold mb-2">Jadwal Pelajaran</h3>
        @if($jadwals->isEmpty())
            <div class="text-gray-600">Belum ada jadwal untuk kelas Anda.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($jadwals as $j)
                    <div class="border rounded p-2 bg-white">
                        @if($j->gambar)
                            <img src="{{ asset('storage/'.$j->gambar) }}" alt="jadwal" class="w-full h-56 object-cover cursor-pointer jadwal-thumb" data-src="{{ asset('storage/'.$j->gambar) }}">
                        @endif
                        <div class="mt-2 text-sm">{{ $j->keterangan ?? 'Jadwal' }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section class="mb-6">
        <h3 class="text-xl font-semibold mb-2">Nilai Saya</h3>
        <div class="mb-2">
            <a href="{{ route('murid.nilai.pdf') }}" class="px-3 py-1 bg-blue-600 text-white rounded">Unduh Nilai (PDF)</a>
        </div>
        @if($nilais->isEmpty())
            <div class="text-gray-600">Belum ada nilai.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($nilais as $n)
                    <div class="border rounded p-2 bg-white">
                        <div class="font-medium">{{ $n->mapel->nama ?? 'Mapel' }}</div>
                        <div class="text-lg font-bold">{{ $n->nilai }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- other sections like beritas, nilais can be displayed by existing blade logic if present -->
    @if(!empty($beritas))
        <section class="mb-6">
            <h3 class="text-xl font-semibold mb-2">Berita Terbaru</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($beritas as $b)
                    <div class="border rounded p-2 bg-white">
                        <a href="{{ route('public.beritas.show', $b) }}" class="font-semibold">{{ $b->judul ?? 'Berita' }}</a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

</div>
@endsection

<!-- Modal (inline here because layouts.app doesn't include a scripts stack) -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
    <div class="relative max-w-4xl w-full mx-4">
        <button id="closeImageModal" class="absolute top-2 right-2 text-white bg-gray-800 bg-opacity-50 rounded-full p-2">✕</button>
        <img id="modalImage" src="" class="w-full h-auto rounded shadow-lg" alt="zoom">
    </div>
</div>

<script>
    (function(){
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
            if (e.target === modal) closeBtn.click();
        });
    })();
</script>
