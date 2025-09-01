@extends('layouts.admin')
@section('title','Edit Jadwal')
@section('body')
<form action="{{ route('jadwals.update', $jadwal) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div>
        <label>Kelas</label>
        <select name="kelas_id">
            @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ $jadwal->kelas_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="mt-2">
        <label>Gambar (biarkan kosong untuk tidak mengganti)</label>
        @if($jadwal->gambar)
            <div class="mb-2"><img src="{{ asset('storage/'.$jadwal->gambar) }}" alt="jadwal" class="w-48 h-48 object-cover"></div>
        @endif
        <input type="file" name="gambar">
    </div>
    <div class="mt-3">
        <button class="px-3 py-1 bg-green-600 text-white rounded">Simpan</button>
        <a href="{{ route('jadwals.index') }}" class="px-3 py-1 bg-gray-300 rounded">Batal</a>
    </div>
</form>
@endsection
