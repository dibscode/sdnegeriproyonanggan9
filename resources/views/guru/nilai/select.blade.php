@extends('layouts.admin')
@section('title','Pilih Tahun Ajaran & Semester - ' . $kelas->nama)
@section('breadcrumbs')
<a href="{{ route('dashboard') }}">Dashboard</a> / Nilai / <a href="{{ route('guru.nilais.kelas') }}">Kelas</a> / {{ $kelas->nama }}
@endsection
@section('body')
<h2 class="text-lg font-medium mb-4">Pilih Tahun Ajaran dan Semester untuk {{ $kelas->nama }}</h2>
<div class="max-w-md">
    <form method="GET" action="{{ route('guru.nilais.murid.index', $kelas) }}">
        <div class="mb-3">
            <label class="block text-sm font-medium">Tahun Ajaran</label>
            <select name="tahun_ajaran" class="mt-1 block w-full rounded border-gray-300">
                @foreach($years as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="block text-sm font-medium">Semester</label>
            <select name="semester" class="mt-1 block w-full rounded border-gray-300">
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </div>
        <div>
            <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded">Lanjutkan</button>
        </div>
    </form>
</div>
@endsection
