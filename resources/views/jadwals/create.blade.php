@extends('layouts.admin')
@section('title','Upload Jadwal')
@section('body')
<form action="{{ route('jadwals.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">@csrf
    <div>
        <label class="block text-sm font-medium text-gray-700">Kelas</label>
        <select name="kelas_id" class="mt-1 block w-full rounded border-gray-300">@foreach($kelas as $k)<option value="{{ $k->id }}">{{ $k->nama }}</option>@endforeach</select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Gambar</label>
        <input type="file" name="gambar" class="mt-1 block w-full" />
    </div>
    <div class="flex gap-2">
        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded">Simpan</button>
        <a href="{{ route('jadwals.index') }}" class="px-3 py-1 bg-gray-300 rounded">Batal</a>
    </div>
</form>
@endsection
