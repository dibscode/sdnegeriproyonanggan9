@extends('layouts.admin')
@section('title','Input Nilai - ' . $murid->nama)
@section('breadcrumbs')
<a href="{{ route('dashboard') }}">Dashboard</a> / Nilai / <a href="{{ route('guru.nilais.kelas') }}">Kelas</a> / <a href="{{ route('guru.nilais.murid.index',$murid->kelas) }}">{{ $murid->kelas->nama }}</a> / {{ $murid->nama }}
@endsection
@section('body')
<h2 class="text-lg font-medium mb-4">Input Nilai untuk {{ $murid->nama }}</h2>
@if(session('success'))<div class="p-2 bg-green-100 text-green-800 mb-3">{{ session('success') }}</div>@endif
@if($mapels->isEmpty())
    <div class="text-gray-600">Belum ada mata pelajaran terdaftar.</div>
@else
    <form method="POST" action="{{ route('guru.nilais.murid.bulk', $murid) }}">
        @csrf
        <div class="grid grid-cols-1 gap-3">
            @foreach($mapels as $index => $mapel)
                <div class="p-3 border rounded flex items-center justify-between">
                    <div>
                        <div class="font-semibold">{{ $mapel->nama }}</div>
                        <div class="text-sm text-gray-500">Kode: {{ $mapel->kode ?? '-' }}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="mapel_id[]" value="{{ $mapel->id }}" />
                        <input name="nilai[]" type="number" min="0" max="100" step="1" value="{{ $existing->has($mapel->id) ? $existing[$mapel->id]->nilai : '' }}" class="w-20 px-2 py-1 border rounded" />
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            <input type="hidden" name="semester" value="{{ $semester ?? '' }}" />
            <input type="hidden" name="tahun_ajaran" value="{{ $tahun ?? '' }}" />
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan Semua</button>
        </div>
    </form>
@endif
@endsection
