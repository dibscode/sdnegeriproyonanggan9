@extends('layouts.app')
@section('title','Pilih Tahun Ajaran & Semester')
@section('content')
<div class="container mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Pilih Tahun Ajaran & Semester</h2>
    <form method="GET" action="{{ route('murid.nilai.pdf') }}">
        <div class="mb-3 max-w-md">
            <label class="block text-sm font-medium">Tahun Ajaran</label>
            <select name="tahun_ajaran" required class="mt-1 block w-full rounded border-gray-300">
                @foreach($years as $y)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 max-w-md">
            <label class="block text-sm font-medium">Semester</label>
            <select name="semester" required class="mt-1 block w-full rounded border-gray-300">
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </div>
        <div>
            <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded">Unduh Nilai</button>
        </div>
    </form>
</div>
@endsection
